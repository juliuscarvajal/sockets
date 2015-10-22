#!/usr/bin/php
<?php

$socket = stream_socket_server("tcp://127.0.0.1:1337", $errno, $errstr);

if (!$socket) {
  echo "$errstr ($errno)<br />\n";
} 
else {
  $client = stream_socket_accept($socket);
  if ($client) {
    echo 'Connection accepted from ' . stream_socket_get_name($client, false) . "\n";
    for(;;) {
      fwrite($client, 'The local time is ' . date('n/j/Y g:i:s a') . "\n");
      sleep(2);
    }
    
    fclose($client);    
  }  
}
