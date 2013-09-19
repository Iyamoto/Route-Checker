<?php

/*
 * Example config file for the project
 * Rename to config.php
 *  Must be edit variables:
 *  $emails
 *  $targets
 */

//Manual config
$emails[] = 'root@localhost'; //Whom to report
$db_dir = '/tmp/routechecker';//Where to put data files
$traceroute = '/usr/sbin/traceroute'; //which traceroute
$ping = '/bin/ping';//which ping

//Targets for traceroute
$targets['server1'] = '10.10.10.10';
$targets['router1'] = '10.10.10.1';

//Internal configuration
require_once 'functions.php';

if (!is_dir($db_dir))
    mkdir($db_dir);
$db_file = $db_dir . DIRECTORY_SEPARATOR . 'data.gz';
$hash_file = $db_dir . DIRECTORY_SEPARATOR . 'hashes.gz';

$debug = false;
$skip_first_host = true;

$test_results = '';
?>