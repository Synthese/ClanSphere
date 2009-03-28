<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('joinus');

include_once('lang/' . $account['users_lang'] . '/countries.php');

$data = array();
$data['head']['getmsg'] = cs_getmsg();
$data['if']['form'] = empty($data['head']['getmsg']) ? TRUE : FALSE;

$captcha = 0;
if(empty($account['users_id']) AND extension_loaded('gd')) {
  $captcha = 1;
}

$data['if']['pass'] = 0;
$data['if']['nopass'] = 1;
$data['if']['captcha'] = 0;

if(isset($_POST['submit'])) {

  $data['join']['games_id'] = $_POST['games_id'];
  $data['join']['squads_id'] = $_POST['squads_id'];
  $data['join']['joinus_nick'] = $_POST['joinus_nick'];
  $data['join']['joinus_name'] = $_POST['joinus_name'];
  $data['join']['joinus_surname'] = $_POST['joinus_surname'];
  $data['join']['joinus_age'] = cs_datepost('age','date');
  $data['join']['joinus_country'] = $_POST['joinus_country'];
  $data['join']['joinus_place'] = $_POST['joinus_place'];
  $data['join']['joinus_icq'] = empty($_POST['joinus_icq']) ? 0 : str_replace('-','',$_POST['joinus_icq']);
  $data['join']['joinus_msn'] = $_POST['joinus_msn'];
  $data['join']['joinus_email'] = $_POST['joinus_email'];
  $data['join']['joinus_lanact'] = $_POST['joinus_lanact'];
  $data['join']['joinus_webcon'] = $_POST['joinus_webcon'];
  $data['join']['joinus_date'] = cs_datepost('join','date');
  $data['join']['joinus_more'] = $_POST['joinus_more'];
  $data2['join']['joinus_rules'] = empty($_POST['joinus_rules']) ? 0 : 1;  

  if(empty($account['users_id'])) {
    $data['join']['users_pwd'] = $_POST['users_pwd'];
  } else {
    $data['if']['pass'] = 1;
    $data['if']['nopass'] = 0;
  }

  $error = 0;
  $errormsg = '';

  $nick2 = str_replace(' ','',$data['join']['joinus_nick']);
  $nickchars = strlen($nick2);
  
  $op_users = cs_sql_option(__FILE__,'users');
  
  if($nickchars<$op_users['min_letters']) {
    $error++;
    $errormsg .= $cs_lang['short_nick'] . cs_html_br(1);
  }
  if(empty($account['users_id'])) {
    $pwd2 = str_replace(' ','',$data['join']['users_pwd']);
    $pwdchars = strlen($pwd2);
    if($pwdchars<4) {
      $error++;
      $errormsg .= $cs_lang['short_pwd'] . cs_html_br(1);
    }
  }
  if(empty($data['join']['joinus_age'])) {
    $error++;
    $errormsg .= $cs_lang['no_age'] . cs_html_br(1);
  }
  if(empty($data['join']['joinus_date'])) {
    $error++;
    $errormsg .= $cs_lang['no_date'] . cs_html_br(1);
  }
  if(empty($data2['join']['joinus_rules'])) {
    $error++;
    $errormsg .= $cs_lang['no_rules'] . cs_html_br(1);
  }
  
  $pattern = "=^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([0-9a-z](-?[0-9a-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$=i";
  if(!preg_match($pattern,$data['join']['joinus_email'])) {
    $error++;
    $errormsg .= $cs_lang['email_false'] . cs_html_br(1);
  }

  $flood = cs_sql_select(__FILE__,'joinus','joinus_since',0,'joinus_since DESC');
  $maxtime = $flood['joinus_since'] + $cs_main['def_flood'];
  if($maxtime > cs_time()) {
    $error++;
    $diff = $maxtime - cs_time();
    $errormsg .= sprintf($cs_lang['flood_on'], $diff);
  }
  if(empty($account['users_id'])) {
    if (!cs_captchacheck($_POST['captcha'])) {
      $error++;
      $errormsg .= $cs_lang['captcha_false'] . cs_html_br(1);
    }
  }
} else {
  $data['join']['games_id'] = '';
  $data['join']['squads_id'] = '';
  $data['join']['joinus_nick'] = '';
  $data['join']['joinus_name'] = '';
  $data['join']['joinus_surname'] = '';
  $data['join']['joinus_age'] = 0;
  $data['join']['joinus_country'] = 'fam';
  $data['join']['joinus_place'] = '';
  $data['join']['joinus_icq'] = '';
  $data['join']['joinus_msn'] = '';
  $data['join']['joinus_email'] = '';
  $data['join']['joinus_lanact'] = '';
  $data['join']['joinus_webcon'] = '';
  $data['join']['joinus_date'] = cs_datereal('Y-m-d');
  $data['join']['joinus_more'] = '';
  $data['join']['users_pwd'] = '';
  $data2['join']['joinus_rules'] = 0;

  if(!empty($account['users_id'])) {
    $fetch = 'users_nick, users_name, users_surname, users_age, users_country, users_place, users_icq, users_msn, users_email';
  $cs_user = cs_sql_select(__FILE__,'users',$fetch,"users_id = '" . $account['users_id'] . "'");
    $data['join']['joinus_nick'] = $cs_user['users_nick'];
    $data['join']['joinus_name'] = $cs_user['users_name'];
    $data['join']['joinus_surname'] = $cs_user['users_surname'];
  $data['join']['joinus_age'] = $cs_user['users_age'];
    $data['join']['joinus_country'] = $cs_user['users_country'];
    $data['join']['joinus_place'] = $cs_user['users_place'];
    $data['join']['joinus_icq'] = empty($cs_user['users_icq']) ? '' : $cs_user['users_icq'];
    $data['join']['joinus_msn'] = $cs_user['users_msn'];
    $data['join']['joinus_email'] = $cs_user['users_email'];
  $data['if']['pass'] = 1;
    $data['if']['nopass'] = 0;
  }
}

if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['body_new'];
} elseif(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['clip']['plus'] = cs_html_img('symbols/clansphere/plus.gif',0,0,'id="img_pass"');
  $data['join']['date'] = cs_dateselect('age','date',$data['join']['joinus_age']);
  $data['join']['country_url'] = cs_html_img('/symbols/countries/' . $data['join']['joinus_country'] . '.png',0,0,'id="country_1"');
  $data['country'] = array();
  $run = 0;
  foreach ($cs_country AS $short => $full) {
    $data['country'][$run]['short'] = $short;
    $data['country'][$run]['selection'] = $short == $data['join']['joinus_country'] ? ' selected="selected"' : '';
    $data['country'][$run]['full'] = $full;
    $run++;
  }
  $data['join']['games_url'] = cs_html_img('uploads/games/0.gif',0,0,'id="game"');
  $data['games'] = array();
  $cs_games = cs_sql_select(__FILE__,'games','games_name,games_id',0,'games_name',0,0);
  for($run = 0; $run < count($cs_games); $run++) {
    $data['games'][$run]['short'] = $cs_games[$run]['games_id'];
    $data['games'][$run]['selection'] = $cs_games[$run]['games_id'] == $data['join']['games_id'] ? ' selected="selected"' : '';
    $data['games'][$run]['name'] = $cs_games[$run]['games_name'];
  }
  $cid = "squads_own = '1' AND squads_joinus = '0'";
  $squads_data = cs_sql_select(__FILE__,'squads','squads_name, squads_id, squads_own, squads_joinus',$cid,'squads_name',0,0);
  $data['squad']['list'] = cs_dropdown('squads_id','squads_name',$squads_data,$data['join']['squads_id']);
  $data['date']['join'] = cs_dateselect('join','date',$data['join']['joinus_date'],2000);
  $data['abcode']['smileys'] = cs_abcode_smileys('joinus_more');
  $data['abcode']['features'] = cs_abcode_features('joinus_more');
  
  $data['rules']['link'] = cs_html_link(cs_url('rules','list'),$cs_lang['rules']);
  $data['joinus']['rules_selected'] = !empty($data2['join']['joinus_rules']) ? 'checked' : '';
  if(!empty($captcha)) {
    $data['if']['captcha'] = 1;
  }
} else {

  if(empty($account['users_id'])) {
    global $cs_db;
    if($cs_db['hash'] == 'md5') { $data['join']['users_pwd'] = md5($data['join']['users_pwd']); 
  } elseif($cs_db['hash'] == 'sha1') { $data['join']['users_pwd'] = sha1($data['join']['users_pwd']); }
  }

  settype($data['join']['joinus_icq'],'integer');
  $data['join']['joinus_since'] = cs_time();
  $joinus_cells = array_keys($data['join']);
  $joinus_save = array_values($data['join']);
  cs_sql_insert(__FILE__,'joinus',$joinus_cells,$joinus_save);
  
  $joinus_id = cs_sql_insertid(__FILE__);
    
  $tables = "joinus ju INNER JOIN {pre}_members mem ON ju.squads_id = mem.squads_id AND mem.members_admin = '1' ";
  $tables .= 'INNER JOIN {pre}_squads sq ON ju.squads_id = sq.squads_id';
  $cells = 'ju.squads_id AS squads_id, mem.users_id AS users_id, sq.squads_name AS squads_name';
  $select = cs_sql_select(__FILE__,$tables,$cells,"ju.joinus_id = '" . $joinus_id . "'",0,0,0);
  $select_count = count($select);
  
  for ($run = 0; $run < $select_count; $run++) {
    $user = cs_sql_select(__FILE__,'users','users_id',"users_id = '" . $select[$run]['users_id'] . "'");
    $message['users_id'] = '1';
    $message['users_id_to'] = $user['users_id'];
    $message['messages_time'] = cs_time();
    $message['messages_subject'] = $cs_lang['new_joinus'] . $select[$run]['squads_name'];
    $message['messages_text'] = $cs_lang['new_joinus_text'] . $select[$run]['squads_name'] . $cs_lang['new_joinus_text2'];
//  $message['messages_text'] .= $cs_lang['since'] . ': ' . $cs_joinus['joinus_date'];
//  $message['messages_text'] .= $cs_lang['nick'] . ': ' . $cs_joinus['joinus_nick'];
//  $message['messages_text'] .= $cs_lang['vorname'] . ': ' . $cs_joinus['joinus_name'];
//  $message['messages_text'] .= $cs_lang['surname'] . ': ' . $cs_joinus['joinus_surname'];
//  $message['messages_text'] .= $cs_lang['birthday'] . ': ' . $cs_joinus['joinus_age'];
    $message['messages_text'] .= ' ' . $cs_lang['new_joinus_text3'];
    $message['messages_show_receiver'] = '1';
    $messages_cells = array_keys($message);
    $messages_save = array_values($message);
    cs_sql_insert(__FILE__,'messages',$messages_cells,$messages_save);
  }
  cs_redirect($cs_lang['new_done'],'joinus','new');
}
echo cs_subtemplate(__FILE__,$data,'joinus','new');
?>