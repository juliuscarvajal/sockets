#!/usr/bin/php
<?php

require './vendor/autoload.php';

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

date_default_timezone_set('UTC');

$eio = new Client(new Version1X('http://127.0.0.1:7331'));

$connected = false;
while (!$connected) {
  try {
    $eio->initialize();
    $connected = true;
  }
  catch(Exception $e) {
    echo "Server down...\n\n";
    sleep(2);
  }  
}

if ($connected) {
  echo "Sending message...\n\n";
  $eio->emit('broadcast', [
    'data' => 'The local time is ' . date('n/j/Y g:i:s a')
  ]);
  $eio->close();  
}
