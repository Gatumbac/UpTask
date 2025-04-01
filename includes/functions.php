<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// HTML scape
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function verify($variable, $location) {
    if (!$variable) {
        redirect($location);
    }
}

function redirect($location) {
    header('Location: ' . $location);
    exit;
}

function isAuth() {
    if (!isset($_SESSION['login'])) {
        header('Location: /');
        exit;
    }
}

function isAdmin() {
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
        exit;
    }
}
