#!/usr/bin/php
<?php

function query($url, $postData = null, $timeout = 25) //self::DEFAULT_REQUEST_TIMEOUT)
{
  $curl_handle = curl_init();

  curl_setopt($curl_handle, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($curl_handle, CURLOPT_URL, $url);
  curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
  if(!is_null($postData))
  {
    curl_setopt($curl_handle, CURLOPT_POST, true);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $postData);
  }

  $response = curl_exec($curl_handle);
  //self::$previousRequestTotalTime = curl_getinfo($curl_handle, CURLINFO_TOTAL_TIME);
  $error = curl_error($curl_handle);
  if ($error) // curl transport error 
  {
    $message = "Query curl request '$url' failed with error: $error ";
    //throw new SwitchboardException($message, $url, $postData);
  }

  $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
  curl_close($curl_handle);
  if ($httpCode >= 400) 
  {
    $message = sprintf('Upstream returned an error %d with response %s', $httpCode, $response);
    //throw new SwitchboardException($message, $url, $postData);
  }

  return $response;
}


$url = 'http://localhost:7331/sb';

$urls = [
  'http://nba.com',
  'http://www.html5rocks.com',
  'http://info.cern.ch/'
];


foreach ($urls as $url2play) {  
  $fields = [
    'url' => urlencode($url2play)
  ];

  $postData = '';

  //url-ify the data for the POST
  foreach($fields as $key=>$value) { $postData .= $key.'='.$value.'&'; }
  rtrim($postData, '&');

  $response = query($url, $postData);
  print_r($response);
  
  sleep(10);  
}

echo "\n";
