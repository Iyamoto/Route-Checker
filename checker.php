<?php

/*
 * Project description
 */
$exec_time = microtime(true);
require_once 'config.php';
echo "\n[+] Started\n";

foreach ($targets as $name=>$target) {
    $command = $traceroute.' '.$target;
    $route[$name] = shell_exec($command);  
}

var_dump($route);

//Save suspects to json
if (save_json($db_file, $route))
    echo "[+] Saved\n";

$exec_time = round(microtime(true) - $exec_time, 2);
echo "[i] Execution time: $exec_time sec.\n";
?>
