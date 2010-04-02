<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

//TODO
//add Access Name
//add mutiple users at once
//check for empty access_id
//check for own user_id

$cs_lang = cs_translate('access');

empty($_REQUEST['id']) ? $access_id = 0 : $access_id = $_REQUEST['id'];

$data = array();

$data['access']['id'] = $access_id;


if(isset($_POST['submit']) && isset($_POST['users_nick']) && isset($_REQUEST['id'])) {

  $select = 'users_id, access_id, users_nick, users_delete';
  $where = "users_delete = '0' AND users_nick = '" . $_POST['users_nick'] . "'";
  $cs_user = cs_sql_select(__FILE__,'users', $select, $where);
  
  $errormsg = '';
  
  if (count($cs_user) > 0)
  {
    if($cs_user['access_id'] != $access_id)
	{
      $cs_access_user['access_id'] = $access_id;
	  $users_id = $cs_user['users_id'];
	
	  $user_cells = array_keys($cs_access_user);
      $user_save = array_values($cs_access_user);
      cs_sql_update(__FILE__,'users',$user_cells,$user_save,$users_id);
	}
	else
	{
	  $errormsg .= $cs_lang['user_ingroup'];;
	}
  }
  else
  {
    $errormsg .= $cs_lang['user_notfound'];
  }
}

if(!isset($_POST['submit'])) {
  $data['head']['msg'] = $cs_lang['users_head'];;
}
elseif(!empty($errormsg)) {
  $data['head']['msg'] = $errormsg;
}
else {
  $data['head']['msg'] = $cs_lang['user_added'];
}

$select = 'users_id, access_id, users_nick, users_delete, users_active';
$where = "users_delete = '0' AND access_id = '" . $access_id . "'";
$sort = 'users_nick ASC';
$cs_access_users = cs_sql_select(__FILE__,'users', $select, $where, $sort, 0, 0);
$users_loop = count($cs_access_users);

if (empty($users_loop)) {
  $data['users'] = '';
}

for($run = 0; $run < $users_loop; $run++) {
  $data['users'][$run]['nick'] = cs_user($cs_access_users[$run]['users_id'], $cs_access_users[$run]['users_nick'], $cs_access_users[$run]['users_active'], $cs_access_users[$run]['users_delete']);
}

echo cs_subtemplate(__FILE__,$data,'access','users');