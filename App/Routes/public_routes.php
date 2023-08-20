<?php

use App\Controllers\EmployeesController;
use Buki\Router\Router;

$this->route->get('/', function() {
    include_once __DIR__ . '/../Views/pages/inicio.php';
});

// EmployeesController routes

$this->route->get('/employees/all', function() {
    include_once __DIR__ . '/../Views/pages/employees_all.php';
});

$this->route->add('GET|POST', '/employees/new', function() {
    include_once __DIR__ . '/../Views/pages/employees_new.php';
});

$this->route->add('GET|POST', '/employees/view/:id', function($employee_id) {
    include_once __DIR__ . '/../Views/pages/employees_view.php';
});

$this->route->get('/employees/delete/:id', function($employee_id) {
    include_once __DIR__ . '/../Views/pages/employees_delete.php';
});

