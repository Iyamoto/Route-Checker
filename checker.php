<?php

/*
 * Project description
 */
$exec_time = microtime(true);
require_once 'config.php';
echo "\n[+] Started\n";

foreach ($targets as $name => $target) {
    $command = $traceroute . ' ' . $target;
    if ($debug) {
        $routes[$name] = str_to_array($test_results);
    }
    else
        $routes[$name] = get_tracert($command);
    $pre_hash = implode(' ',$route[$name]);
    $hashes[$name] = md5($pre_hash);
    
}

var_dump($routes);
var_dump($hashes);

//Save suspects to json
if (save_json($db_file, $routes))
    echo "[+] Routes saved\n";
if (save_json($hash_file, $hashes))
    echo "[+] Hashes saved\n";

$exec_time = round(microtime(true) - $exec_time, 2);
echo "[i] Execution time: $exec_time sec.\n";

function str2array($str){
    
}
?>
