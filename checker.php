<?php

/*
 * Checks trace routes and report changes to email
 */
$exec_time = microtime(true);
echo "\n[+] Started\n";

if (file_exists('config.php'))
    require_once 'config.php';
else
    exit("[-] Rename sample-config.php to config.php\n");

//Read routes
$routes = read_db_from_file($db_file);
if ($routes) {
    $routes_size = sizeof($routes);
    echo "[+] Read $routes_size routes from $db_file\n";
} else {
    echo "[-] Problem with $db_file file\n";
    unset($routes);
}
//FIXME replace this crap with a helper function?
//Read hashes
$hashes = read_db_from_file($hash_file);
if ($hashes) {
    $hashes_size = sizeof($hashes);
    echo "[+] Read $hashes_size hashes from $hash_file\n";
} else {
    echo "[-] Problem with $hash_file file\n";
    unset($hashes);
}

//Cycle throw targets ip
foreach ($targets as $name => $target) {
    $command = $traceroute . ' ' . $target;
    if ($debug)
        $new_routes[$name] = str_to_array($test_results);
    else
        $new_routes[$name] = get_tracert($command);
    if ($skip_first_host) {
        $tmp = array_slice($new_routes[$name], 1);
        $pre_hash = implode('', $tmp);
    }
    else
        $pre_hash = implode('', $new_routes[$name]);
    
    $pre_hash = preg_replace('|\*+|', '*', $pre_hash);
    $hash = md5($pre_hash);

    if (isset($hashes[$name])) { //Got route in the db?
        if ($hashes[$name] == $hash) //Compare route from the db with new route
            echo "[+] Route to $name is stable\n";
        else {
            echo "[-] Route to $name is changed\n";
            echo "[i] Old route:\n";
            $old_route = implode("\n", $routes[$name]);
            echo "$old_route\n";
            echo "[i] New route:\n";
            $new_route = implode("\n", $new_routes[$name]);
            echo "$new_route\n";

            $ping_result = check_availability($target, $ping);

            if (!$debug) {
                $body = "Old route:\n$old_route\n
New route:\n$new_route\n
$ping_result";
                action($emails, $name, $body);//send mail
            }
            else
                var_dump($body);

            $hashes[$name] = $hash;
            $routes[$name] = $new_routes[$name];
        }
    } else {    //add new hash and route to db
        echo "[+] Added route to $name\n";
        $hashes[$name] = $hash;
        $routes[$name] = $new_routes[$name];
    }
}

//Save data to json
if (save_json($db_file, $routes))
    echo "[+] Routes saved\n";
if (save_json($hash_file, $hashes))
    echo "[+] Hashes saved\n";

$exec_time = round(microtime(true) - $exec_time, 2);
echo "[i] Execution time: $exec_time sec.\n";
?>