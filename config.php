<?php
$db_host = 'localhost';
$db_user = 'root';
$db_name = 'spk_susu';
$db_password='';

$web_host='http://localhost/spk_musyawirin/';

$link=mysql_connect($db_host,$db_user,$db_password);
mysql_select_db($db_name,$link);

?>