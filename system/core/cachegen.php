<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_cache_clear() {

  $content = cs_paths('uploads/cache');
  unset($content['index.html'], $content['.htaccess']);
  foreach($content AS $file => $name)
    unlink('uploads/cache/' . $file);

  $unicode = extension_loaded('unicode') ? 1 : 0;
  $where = "options_mod = 'clansphere' AND options_name = 'cache_unicode'";
  cs_sql_update(__FILE__, 'options', array('options_value'), array($unicode), 0, $where); 
 }

function cs_cache_dirs($dir, $lang) {

  # $cs_lang and $cs_main are needed for info.php file content parsing
  global $cs_lang, $cs_main;
  $filename = $dir . '_' . $lang;
  $content = cs_cache_load($filename);

  if($content === false) {
    $cs_lang_old = $cs_lang;
    $info = array();
    $dirlist = cs_paths($dir);
    unset($dirlist['index.html'], $dirlist['.htaccess']);
    $directories = array_keys($dirlist);
    foreach($directories as $target) {
      $this_info = $dir . '/' . $target . '/info.php';
      if(file_exists($this_info)) {
        $cs_lang = array('mod' => '', 'mod_info' => '');
        $mod_info = array('show' => array());
        include($this_info);
        $name = empty($mod_info['name']) ? '[' . $target . ']' : $mod_info['name'];
        if(isset($info[$name])) {
          cs_error($this_info, 'cs_cache_dirs - Translated name "' . $name . '" is already in use');
        }
        else {
          $info[$name] = $mod_info;
          $info[$name]['name'] = $name;
          $info[$name]['dir'] = $target;
        }
        unset($info[$name]['text'], $info[$name]['url'], $info[$name]['team'], $info[$name]['creator']);
      }
      elseif(is_dir($dir . '/' . $target)) {
        cs_error($this_info, 'cs_cache_dirs - Required file not found');
      }
    }
    ksort($info);
    $cs_lang = $cs_lang_old;

    return cs_cache_save($filename, $info);
  }
  else {
    return $content;
  }
}

function cs_cache_load($filename) {

  if(!file_exists('uploads/cache/' . $filename . '.tmp'))
    return false;
  else
    return unserialize(file_get_contents('uploads/cache/' . $filename . '.tmp'));
}

function cs_cache_save($filename, $content) {

  global $cs_main;
  if(is_bool($content)) {
    cs_error('uploads/cache/' . $filename . '.tmp', 'cs_cache_save - It is not allowed to just store a boolean');
  }
  elseif(is_writeable('uploads/cache/')) {
    $store = serialize($content);
    $cache_file = 'uploads/cache/' . $filename . '.tmp';
    $save_cache = fopen($cache_file,'a');
    # set stream encoding if possible to avoid converting issues
    if(function_exists('stream_encoding'))
      stream_encoding($save_cache, $cs_main['charset']);
    fwrite($save_cache,$store);
    fclose($save_cache);
    chmod($cache_file,0644);
  }
  elseif($cs_main['mod'] != 'install') {
    cs_error('uploads/cache/' . $filename . '.tmp', 'cs_cache_save - Unable to write cache file');
  }
  return $content;
}