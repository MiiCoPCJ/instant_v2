<?php
header("Content-type:text/html;charset=utf-8");
$config = require_once(__DIR__.'/env.php');
define('CONFIG',$config);
require_once(__DIR__.'/common/Database.php');
require_once(__DIR__.'/common/Controller.php');
require_once(__DIR__.'/common/Func.php');
