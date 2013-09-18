<?php

/*
 * Example config file for the project
 * Rename to config.php
 */
require_once 'functions.php';
//$emails and $netflow_base_dir must be set 
$emails[] = 'name@domain.zone'; //Whom to report
$web_dir = '/var/www/routechecker';
$db_dir = '/tmp/routechecker';
$tpl_dir = 'tpl';
$traceroute = '/usr/sbin/traceroute';//which traceroute

$today = date("Y-m-d");
if (!is_dir($db_dir))
    mkdir($db_dir);
$db_file = $db_dir . DIRECTORY_SEPARATOR . 'data.gz';

//What are we looking for?
$targets['server1'] = '10.10.10.10';
$targets['router1'] = '10.10.10.1';

$debug = false;
?>