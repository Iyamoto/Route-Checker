<?php

/*
 * Project description
 */
$exec_time = microtime(true);
require_once 'config.php';
echo "\n[+] Started\n";

//Read routes
$routes = read_db_from_file($db_file);
if ($routes) {
    $routes_size = sizeof($routes);
    echo "[+] Read $routes_size routes from $db_file\n";
} else {
    echo "[-] Problem with $db_file file\n";
    unset($routes);
}
//FIXME add helper function
//Read hashes
$hashes = read_db_from_file($hash_file);
if ($hashes) {
    $hashes_size = sizeof($hashes);
    echo "[+] Read $hashes_size hashes from $hash_file\n";
} else {
    echo "[-] Problem with $hash_file file\n";
    unset($hashes);
}


foreach ($targets as $name => $target) {
    $command = $traceroute . ' ' . $target;
    if ($debug) {
        $new_routes[$name] = str_to_array($test_results);
    }
    else
        $new_routes[$name] = get_tracert($command);
    $pre_hash = implode(' ', $new_routes[$name]);
    $hash = md5($pre_hash);
    if (isset($hashes[$name])) {
        if ($hashes[$name] == $hash)
            echo "[+] Route $name is stable\n";
        else {
            echo "[-] Route $name is changed\n";
            echo "[i] Old route:\n";
            $old_route = implode("\n", $routes[$name]);
            echo "$old_route\n";
            echo "[i] New route:\n";
            $new_route = implode("\n", $new_routes[$name]);
            echo "$new_route\n";

            if (!$debug) {
                $body ="Old route: \n$old_route\n\nNew route:$new_route\n";
                action($emails, $name, $body);
            }

            $hashes[$name] = $hash;
            $routes[$name] = $new_routes[$name];
        }
    } else {    //add new hash and route to db
        echo "[+] Added route to $name\n";
        $hashes[$name] = $hash;
        $routes[$name] = $new_routes[$name];
    }
}


//Save suspects to json
if (save_json($db_file, $routes))
    echo "[+] Routes saved\n";
if (save_json($hash_file, $hashes))
    echo "[+] Hashes saved\n";

$exec_time = round(microtime(true) - $exec_time, 2);
echo "[i] Execution time: $exec_time sec.\n";
?>
