<?php
// ClanSphere 2009 - www.clansphere.net 
// $Id$

$cs_lang = cs_translate('servers');

$data = array();

// Submit Post
if(isset($_POST['submit'])) {

  $servers_error = 0; 
  $errormsg = $cs_lang['error_occurred'] . cs_html_br(1);;

  $data['create']['servers_name'] = $_POST['servers_name'];
  $data['create']['servers_ip'] = $_POST['servers_ip'];
  $data['create']['servers_port'] = $_POST['servers_port'];
  $data['create']['games_id'] = $_POST['games_id'];
  $data['create']['servers_info'] = $_POST['servers_info'];
  $data['create']['servers_slots'] = $_POST['servers_slots'];
  $data['create']['servers_type'] = $_POST['servers_type'];
  $data['create']['servers_stats'] = $_POST['servers_stats'];
  $data['create']['servers_class'] = $_POST['servers_class'];
  $data['create']['servers_query'] = $_POST['servers_query'];
  $data['create']['servers_order'] = $_POST['servers_order'];

  if(empty($data['create']['servers_name'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_name'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_ip'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_ip'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_port'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_port'] . cs_html_br(1);
  }
  if(empty($data['create']['games_id'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_game'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_type'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_type'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_class'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_class'] . cs_html_br(1);
  }
  if(empty($data['create']['servers_query'])) {
    $servers_error++;
    $errormsg .= $cs_lang['no_query'] . cs_html_br(1);
  }
// Create new Entry
} 
else {
  $data['create']['servers_name'] = '';
  $data['create']['servers_ip'] = '';
  $data['create']['servers_port'] = '';
  $data['create']['games_id'] = '';
  $data['create']['servers_info'] = $cs_lang['server_infos_no_stats'];
  $data['create']['servers_slots'] = '';
  $data['create']['servers_stats'] = '';
  $data['create']['servers_type'] = '';
  $data['create']['servers_class'] = '';
  $data['create']['servers_query'] = '';
  $data['create']['servers_order'] = '';

}
if(!isset($_POST['submit'])) {
  $data['body']['create'] = $cs_lang['body_create'];
}
elseif(!empty($servers_error)) {
  $data['body']['create'] = $errormsg;
}

if(!empty($servers_error) OR !isset($_POST['submit'])) {
	$data['games'] = cs_sql_select(__FILE__,'games','games_name, games_id',0,0,0,0);
	
	$server_stats = array(
    array('name' => $cs_lang['no'], 'value' => '0'),
    array('name' => $cs_lang['yes'], 'value' => '1')
	);
	$run=0;
	foreach($server_stats AS $stats) {
		$selected = ($stats['value'] == $data['create']['servers_stats']) ? 'selected="selected"' : '';
		$data['stats'][$run]['name'] = $stats['name'];
		$data['stats'][$run]['value'] = $stats['value'];
		$data['stats'][$run]['selected'] = $selected;
		$run++;
	}

  $server_array = array(
    array('name' => '(kein)', 'servers_class' => '1'),
    array('name' => 'Americans Army', 'servers_class' => 'aa'),
    array('name' => 'Armagetronad', 'servers_class' => 'atron'),
    array('name' => 'Battlefield', 'servers_class' => 'bf'),  
    array('name' => 'Battlefield 2', 'servers_class' => 'bf2'),  
    array('name' => 'Battlefield 2142', 'servers_class' => 'bf2142'),  
    array('name' => 'Battlefield Vietnam', 'servers_class' => 'bfv'),
    array('name' => 'C&C Renegade', 'servers_class' => 'renegade'),  
    array('name' => 'Call of Duty', 'servers_class' => 'cod'),  
    array('name' => 'Call of Duty 2', 'servers_class' => 'cod2'),  
    array('name' => 'Call of Duty 4', 'servers_class' => 'cod4'),      
    array('name' => 'Doom 3', 'servers_class' => 'd3'),   
    array('name' => 'Descent 3', 'servers_class' => 'descent3'),   
    array('name' => 'Descent 3 Gamespy', 'servers_class' => 'des3gs'), 
    array('name' => 'Elite Force', 'servers_class' => 'ef'),
    array('name' => 'Enemy Territory', 'servers_class' => 'et'),   
    array('name' => 'Enemy Territory Quake Wars', 'servers_class' => 'etqw'), 
    array('name' => 'Fear', 'servers_class' => 'fear'),
    array('name' => 'Halo', 'servers_class' => 'halo'),   
    array('name' => 'Hiddem & Dangerous 2', 'servers_class' => 'hd2'),
    array('name' => 'Half-Life & Mods / Half-Life 2', 'servers_class' => 'hl'),
    array('name' => 'Half-Life Old', 'servers_class' => 'hl_old'),
    array('name' => 'Jedi Knight: Jedi Academy / Jedi Knight 2', 'servers_class' => 'jedi'),  
    array('name' => 'Medal of Honor', 'servers_class' => 'mohaa'),
    array('name' => 'No One Lives Forever', 'servers_class' => 'nolf'),
    array('name' => 'Painkiller', 'servers_class' => 'pk'),
    array('name' => 'Quake 1 / Quakeworld', 'servers_class' => 'q1'),
    array('name' => 'Quake 2', 'servers_class' => 'q2'),
    array('name' => 'Quake 3 Arena', 'servers_class' => 'q3a'),  
    array('name' => 'Quake 4', 'servers_class' => 'q4'),
    array('name' => 'Return to Castle Wolfenstein', 'servers_class' => 'rtcw'),  
    array('name' => 'Rune', 'servers_class' => 'rune'),
    array('name' => 'Soldier of Fortune 2', 'servers_class' => 'sof2'),
    array('name' => 'S.W.A.T.', 'servers_class' => 'swat'),
    array('name' => 'TeamSpeak 2', 'servers_class' => 'ts'),
    array('name' => 'Unreal Tournament', 'servers_class' => 'ut'),
    array('name' => 'Unreal Tournament 2003 & 2004 / Red Orchestra', 'servers_class' => 'ut2004'),  
    array('name' => 'Unreal Tournament 3', 'servers_class' => 'ut3'),      
    array('name' => 'Warsor', 'servers_class' => 'warsow')
  );
  $run = 0;
  foreach($server_array AS $class) {
    $select = $class['servers_class'] == $data['create']['servers_class'] ? $select = 'selected="selected"' : $select = '';
    $data['classes'][$run]['name'] = $class['name'];
    $data['classes'][$run]['class'] = $class['servers_class'];
    $data['classes'][$run]['select'] = $select;
    $run++;
  }

  $servers_type = array(
    array('gtype' => $cs_lang['clanserver'], 'type' => '1', 'selected' => ''),
    array('gtype' => $cs_lang['pubserver'], 'type' => '2', 'selected' => ''),
    array('gtype' => $cs_lang['voiceserver'], 'type' => '3', 'selected' => '')   
  );
  $run=0;
  foreach($servers_type AS $type) {
  	$selected = ($type['type'] == $data['create']['servers_type']) ? 'selected="selected"' : '';
  	$data['typ'][$run]['name'] = $type['gtype'];
  	$data['typ'][$run]['type'] = $type['type'];
  	$data['typ'][$run]['selected'] = $selected;
  	$run++; 
  }

} else {

  // Insert SQL Data
  $servers_cells = array_keys($data['create']);
  $servers_save = array_values($data['create']);
  cs_sql_insert(__FILE__,'servers',$servers_cells,$servers_save);
  
  // Include RSS Feed
  include_once('mods/servers/rss.php');

  // Create Finish    
  cs_redirect($cs_lang['create_done'],'servers');
}
echo cs_subtemplate(__FILE__,$data,'servers','create');
?>