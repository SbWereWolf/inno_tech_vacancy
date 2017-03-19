<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        "MongoDB" => APP_PATH . 'vendor/mongodb/mongodb/src/',
        "MongoDB\\Operation" => APP_PATH . 'vendor/mongodb/mongodb/src/Operation/',
        "MongoDB\\Model" => APP_PATH . 'vendor/mongodb/mongodb/src/Model/',
        "MongoDB\\GridFS" => APP_PATH . 'vendor/mongodb/mongodb/src/GridFS/',
        "MongoDB\\Exception" => APP_PATH . 'vendor/mongodb/mongodb/src/Exception/',
        "MongoDB\\Exception\\RuntimeException" => APP_PATH . 'vendor/mongodb/mongodb/src/GridFS/Exception/',
    ]
)->register();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerDirs([
    APP_PATH . $config->application->controllersDir,
    APP_PATH . $config->application->pluginsDir,
    APP_PATH . $config->application->libraryDir,
    APP_PATH . $config->application->modelsDir,
    APP_PATH . $config->application->formsDir,
])->register();

$loader->registerClasses([
    'Services' => APP_PATH . 'app/Services.php'
]);

