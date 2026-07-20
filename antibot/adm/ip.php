<?php
// облачная статистика по ip
if(!defined('ANTIBOT')) die('access denied');
$title = abTranslate('Whois and IP info.');
$get_ip = isset($_GET['ip']) ? trim(preg_replace("/[^0-9a-zA-Z\.\:]/","", $_GET['ip'])) : '';

if ($get_ip != '') {
$content .= '
<a href="?'.$abw.$abp.'=hits&search='.$get_ip.'&table=ip&status=&todate=&operator=equally">'.abTranslate('View log by IP').'</a><br />
<div id="result">Loading...</div>
<script src="https://'.$ab_config['main_url'].'/ip.php?ip='.$get_ip.'&lang='.$lang_code.'&h2='.md5('Antibot:'.$ab_config['email']).'&h1='.md5($ab_config['email'].$ab_config['pass'].$get_ip).'" async></script>';
} else {
$content .= '<div class="alert alert-danger" role="alert">'.abTranslate('IP address is not set.').'</div>';
}

