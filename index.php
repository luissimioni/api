<?php

require 'Autoloader.php';
Autoloader::load();

use app\route\Router;

Router::route($_SERVER['REQUEST_URI']);
