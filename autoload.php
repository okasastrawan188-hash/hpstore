<?php

spl_autoload_register(function ($class) {

    // Hapus prefix "App\" dari namespace
    $class = str_replace("App\\", "", $class);

    // Ubah namespace jadi path folder
    $file = __DIR__ . "/app/" . str_replace("\\", "/", $class) . ".php";

    if (file_exists($file)) {
        require $file;
    }
});