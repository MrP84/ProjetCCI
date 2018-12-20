<?php
session_start();
include('config/config.php');
include('lib/files.fct.php');
//ini_set('display_errors',1);
$title = "Demi tour !";
$path = '..';
$vue = $path . '/tpl/index.phtml';
$vue = 'error404.phtml';


include('./tpl/layout.phtml');
