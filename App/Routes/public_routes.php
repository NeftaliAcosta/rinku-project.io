<?php

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
