<?php
// ClanSphere 2009 - www.clansphere.net
// Id: com_create.php (Tue Nov 18 10:04:53 CET 2008) fAY-pA!N

$cs_lang = cs_translate('articles');
$cs_post = cs_post('fid');
$cs_get = cs_get('id');

$fid = empty($cs_post['fid']) ? 0 : $cs_post['fid'];
$quote_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_articles = cs_sql_select(__FILE__,'articles','articles_com',"articles_id = '" . $fid . "'");

require_once('mods/comments/functions.php');
cs_commments_create($fid,'articles','view',$quote_id,$cs_lang['mod'],$cs_articles['articles_com']);
?>