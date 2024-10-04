<?php

require_once __DIR__ . '/../env.php';
$Classes = getPhpFiles(__DIR__ . '/Classes');

foreach ($Classes as $Class) {
    require_once $Class;
}

$controllers = getPhpFiles(ROOT_ROUTES);   

foreach ($controllers as $controller) {
    require_once $controller;
}
$models = getPhpFiles(ROOT_MODELS);

foreach ($models as $model) {
    require_once $model;
}
?>