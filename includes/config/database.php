<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'bienes_raices', '3306');
    $db->set_charset('utf8');

    if(!$db) {
        echo "no se Conectó";
        exit;
    }

    return $db;
}