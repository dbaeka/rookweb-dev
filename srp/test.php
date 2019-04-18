<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require './srp.php';

$srp = new srp();
$server_vars = array();
$client_vars = array();

//1. generate s, v (client generated, stored by server)
$client_vars["username"] = "alice";
$client_vars["password"] = "password123";

$s = $srp->getRandomSeed();
$s = base64_decode("NGY2MjJlN2E5M2E3MDBmYmFkMDQzY2FmZmM3MDgwNDY5YWYyMzNmZDUwYTRhY2I0NDNlYmY1ZmU0ZDZkZjU2ZGQ1MTJjNWJlNjMwMjYyZTg0OTUzYzQzNTMzNmFjZGY0NDIwZGNjZjFjNWMxN2Q1NWRjMzZkOWU2YzcxNWY3ZjM=");
//echo "Salt: ". $s . "\n";
$x = $srp->generateX($s, $client_vars["username"], $client_vars["password"]);
$client_vars["x"] = $x;
$server_vars["s"] = $s;
$v = $srp->generateV($x);
$v = base64_decode("MjdiODljZTVmODIyYjk3MzRmM2Q0YzNkOTNkYjk4ZGUzMTNlZmRiMjYyZGZjMTRhMTAxOTc1MWQ2ZjI5NmI2NTFiZWQwYzQ2ZjVjOWU5YmMzYTUxMmNhY2U3ZmZjMTJiNjVjNDAxYjU1ZmY3Y2IzNTRiNzMwZDY3MjcwNTg0MDRhOTQ3ODdlMjUxMmU0NTAwNzNhZjFjOTcxOTJmMzBiMjYwNWIyOGMxOGIzMGNkMzIzYWI3NDJkN2EzNjMwZmIxYTRjMDg0ZTQ0NWVkNDlhYzk4YjA5ZDdhNDRhNjBkZTA5NTc1YzViODI5ZmM0MWQzYWVhZGUyOGFjYzdkZDEzYTEzZTRkNTM0NjU3NWNjZDkzNTRhNmNmM2E1NmZiMGZiN2Q1NDJmNjNkZWQ5MjBlNTFhNTEzYjYxMjNmYTgwNjBiMjFhZGIxMmUwODVjYWEwNTQyOGM5OTliYTJjNDIzN2M5NmJjYTRkMzU3ZjU4YjJjNWU1NmRjYzllZDkwMGMxMDk4MTE2MTlmNDMyMzVlZjdmMGUyNWEyODUyYzg1OTYzZDZjYmE4NGY5ODIzYTFhYTZiZDkzNTEyMzc4ZjU2ZjhlODA0YjQwZjgzM2ZiYjcwYWM5OGNjMjUxOWMzZmNkYzQ2YWViNGNlZTMxNTBiNzMyMTJlZTE1YzExZjI2OTM=");
$server_vars["v"] = $v;
//echo "verifier: " . $server_vars["v"]. "\n";

//2.1 client generate a, A and send A, I (username) to server
$client_vars["a"] = $srp->getRandomSeed();
$client_vars["A"] = $srp->generateA($client_vars["a"]);
$client_vars["A"] = base64_decode("MTI4NmVjOWRkNDIwODE4N2JkYzYxZGQxMDUwNWYxMDQ4YjFmZDg1NmU5NGMxZmY0NWFiZjI4N2RkNDQxYjc1YjA3YzM2NTU5NDBjYTg4ZTUxY2JkM2MyYWI0ZTZjZjQ0YTc2NjkwNTE0ZjhmYzUxNTgzYjk4ZDc1ZjFjOTkwYTk0YzE3OTQ0ZjFmNzNlOTAyZmM1ZTg5MDRiOGEwYTU4YmI2NDBjZWI2OGU2YjI0NTgyYmRkY2ZjNzIyNWM0Zjc5YzNjMTRiMDYzYjhiYmVhNDE1MGFhMDlmMWU4Y2FjZDRhYjU1ZWU0MzQzYjQ0NGNhYjU2ZGQ3ZDQ3OTJjMDFmZjE2ODdjOGM2M2EwNzdlYmJkNDY1NTk3ZTFlNDRjNWI2NDg0YTFlZDVjNWExYTI4NWIzY2UxZWEzYzM2MjQxZWNiZjA1NTY0MTA3NTg3ZTU4ZjI1MGE0MjAyZTVhMWIyN2MxMDE2Mzk4ZGQ1NGJiYjY0YzdiODgwYjUxMTY0MTlhZTI2NGJjM2VlZjFkOGMyZjVkZTg4MWE2MDA3OGMwNDU5ZmFiMDdmNWVhMDE5ZmY4ZmM2OTIyZmFmMWIzYzRmYzE2NWYwYWFlMjIzOWZlODZmNmJkNzNlNTk2YTMxN2E1YzZkYTQ5OTZlNTFkMTIxZGYzYmI5MWU3NmQ1ZDE0YjU=");

//2.2 server reveive A, search s, v by I in DB, generate b and B, send s, B to client
$server_vars["A"] = $client_vars["A"];
$server_vars["b"] = $srp->getRandomSeed();
$server_vars["B"] = $srp->generateB($server_vars["b"], $server_vars["v"]);
echo "B for client:   " .base64_encode($server_vars["B"]) . "\n";

//3.1 client receive s, B; build M1 and send it to server
$client_vars["B"] = $server_vars["B"];
$client_vars["S1"] = $srp->generateS_Client($client_vars["A"], $client_vars["B"], $client_vars["a"], $x);
$client_vars["M1"] = $srp->generateM1($client_vars["A"], $client_vars["B"], $client_vars["S1"]);


//3.2 server receive M1, verify it, build k; send M2 back
$server_vars["M1_recive"] = $client_vars["M1"];
$server_vars["S2"] = $srp->generateS_Server($server_vars["A"], $server_vars["B"], $server_vars["b"], $server_vars["v"]);
$M1_check = $srp->generateM1($server_vars["A"], $server_vars["B"], $server_vars["S2"]);

if ($server_vars["M1_recive"] == $M1_check) {
    echo "Client verifikation complete. " . $srp->generateK($server_vars["S2"]);
    echo "<br/>";
}

$server_vars["M2"] = $srp->generateM2($server_vars["A"], $M1_check, $server_vars["S2"]);


//4. client verify M2, build k
$M2_check = $srp->generateM2($client_vars["A"], $client_vars["M1"], $client_vars["S1"]);

if ($M2_check == $server_vars["M2"]) {
    echo "Server verification complete. " . $srp->generateK($client_vars["S1"]);
}


?> 


