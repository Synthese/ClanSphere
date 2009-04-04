<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');
$key = preg_replace('/[^\w]/s','',$_GET['key']);
$uemail = preg_match('/^[a-zA-Z][a-zA-Z0-9._-]{3,40}\@[a-zA-Z][a-zA-Z0-9._-]+\.[a-zA-Z]{2,5}$/', $_GET['email']) ? $_GET['email'] : '';
$data = array();

$select = 'users_id';
$where = "users_regkey= '" . $key . "' AND users_email= '"  . $uemail . "' AND users_active= '0' ";
$cs_user = cs_sql_select(__FILE__,'users',$select,$where,0,0);
$users_count = count($cs_user);

if(empty($users_count)) {
  $data['head']['body_text'] = $cs_lang['no_activation'];
  $data['activate']['link'] = cs_url('users','login');
}
else {
  $users_cells = array('users_active');
  $users_save = array('1');
  cs_sql_update(__FILE__,'users', $users_cells,$users_save,$cs_user['users_id']);
  $data['head']['body_text'] = $cs_lang['account_activated'];
  $data['activate']['link'] = cs_url('users','home');
}

$data['head']['action'] = $cs_lang['activate_acc'];
echo cs_subtemplate(__FILE__,$data,'users','head');
echo cs_subtemplate(__FILE__,$data,'users','activate');

?>