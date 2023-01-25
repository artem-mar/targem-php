<?php

define('DB_HOST', 'targem-php');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'targem');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!$connection) {
  echo 'error';
}
