<?php

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone
date_default_timezone_set('America/Mexico_City');

/**
 * Load config system
 */
require_once "config.php";

/**
 * Load composer
 */
require __DIR__.'/../vendor/autoload.php';

// Load route controller
Use App\Core\Route;
$init = new Route();
$init->start();
