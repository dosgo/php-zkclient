<?php
include "zkclient.php";
$zkc=new zkClient("192.168.1.99");
$conf=$zkc->get('/test/test');
var_dump($conf);