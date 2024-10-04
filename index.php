<?php
define('ROOT', __DIR__ . '/');
define('HTTP_ROOT', 'http://mgx_framework.test/');
define('ROOT_CONTROLLERS', ROOT . 'src/Controllers/');
define('ROOT_VIEWS', ROOT . 'src/Views/');
define('ROOT_ROUTES', ROOT . 'src/Routes/');
define('ROOT_MODELS', ROOT . 'src/Models/');
define('PROJECT_NAME','test');
define('ASSETS', ROOT . 'src/assets/');
require(__DIR__ . '/framework/Functions/index.php');
require(__DIR__ . '/framework/bootstrap.php' );

/* DO NOT REMOVE UP TO HERE */


Route::run();
