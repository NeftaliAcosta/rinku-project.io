<?php

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone
date_default_timezone_set('America/Mexico_City');

/**
 * Load composer
 */
require __DIR__.'/../vendor/autoload.php';

// Load route controller
use App\Core\Environment;
Use App\Core\Route;

// Load environment here
Environment::load();

// Start Route system
$init = new Route();
$init->start();
