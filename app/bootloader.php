<?php

//load config
require_once 'config/config.php'; 

//Load Composer's autoloader
require 'vendor/autoload.php';

//session helper
require_once 'helpers/SessionHelper.php';
//load helpers
require_once 'helpers/URL_Helper.php';
//load env helper
require_once 'helpers/ENV_helper.php';

// Load the .env file
loadEnv(__DIR__ . '/../.env');

//load libraries
require_once 'libraries/Database.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Core.php';
?> 