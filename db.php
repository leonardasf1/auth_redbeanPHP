<?php

require 'libs/rb.php';
R::setup( 'mysql:host=localhost;dbname=test_blog',
  'login', 'password' );

try{
  $db = new PDO('mysql:host=localhost;dbname=test_blog','login','password');
} catch(PDOException $e){
  echo $e->getmessage();
}

session_start();
// R::close();
?>