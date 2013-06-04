<?php
header("content-type:text/html; charset=utf-8");
require_once("sceneTemplate.php");
session_start();
session_destroy();

if($isIPhone)
   header("Location:./index_sp.php");
else
   header("Location:./index_pc.php");
