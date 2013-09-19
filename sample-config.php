<?php

/*
 * Example config file for the project
 * Rename to config.php
 */
require_once 'functions.php';
//INIT 
$emails[] = 'root@localhost'; //Whom to report
$db_dir = '/tmp/routechecker';
$traceroute = '/usr/sbin/traceroute'; //which traceroute

$today = date("Y-m-d");
if (!is_dir($db_dir))
    mkdir($db_dir);
$db_file = $db_dir . DIRECTORY_SEPARATOR . 'data.gz';
$hash_file = $db_dir . DIRECTORY_SEPARATOR . 'hashes.gz';

//What are we looking for?
$targets['server1'] = '10.10.10.10';
$targets['router1'] = '10.10.10.1';

$debug = false;
$skip_first_host = true;

$test_results = '';
?>