<?php

/*
 * Functions for Route-Checker project
 */
mb_internal_encoding("UTF-8");

//Sends mail
function action($emails, $name, $body) {
    $subject = "Route changed: $name";
    foreach ($emails as $email) {
        $results[] = mail($email, $subject, $body);
    }
    return $results;
}

//Wrapper for traceroute
function get_tracert($command) {
    $results = trim(shell_exec($command)); //exeCute 
    $data = str_to_array($results);
    return $data;
}

//Helper function, converts traceroute output to array
function str_to_array($str) {
    $str = trim($str);
    $lines = explode("\r\n", $str);
    if (sizeof($lines) == 1)
        $lines = explode("\n", $str);
    for ($i = 1; $i < sizeof($lines); $i++) {
        $tmp = explode(" ", trim($lines[$i]));
        $elements[] = trim($tmp[2]);
    }
    if (sizeof($elements) > 0)
        return $elements;
    else
        return false;
}

//Compress and save json data to file
function save_json($fn, $data) {
    $json = json_encode($data);
    $gz = gzcompress($json);
    return file_put_contents($fn, $gz);
}

//Load and decompress from file to json array
function load_json($fn) {
    $gz = file_get_contents($fn);
    if ($gz) {
        $json = gzuncompress($gz);
        $data = json_decode($json, true);
        return $data;
    } else {
        echo "[-] Cant load file $fn\n";
        return false;
    }
}

//Helper, load data from file
function read_db_from_file($filename) {
    if (file_exists($filename)) {
        $json = load_json($filename);
        if ($json)
            return $json;
        else
            return false;
    } else {
        echo "[-] $filename not found\n";
        return false;
    }
}

//Ping (send 4 icmp type 8 packets) IP and return result
//TODO check result for % loss
function check_availability($ip, $ping) {
    $command = $ping . '  -c 4 ' . $ip;
    $result = shell_exec($command);
    return $result;
}

?>
