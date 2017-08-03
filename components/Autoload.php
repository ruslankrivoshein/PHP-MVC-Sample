<?php

spl_autoload_register(function ($className) {
    $arrayPaths = array(
        '/models/',
        '/components/'
    );

    foreach ($arrayPaths as $path) {
        $path = ROOT . $path . $className . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
});
