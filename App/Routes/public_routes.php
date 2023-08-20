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

$this->route->add('GET|POST', '/employees/view/:id', function($employee_id) {
    include_once __DIR__ . '/../Views/pages/employees_view.php';
});

$this->route->get('/employees/delete/:id', function($employee_id) {
    include_once __DIR__ . '/../Views/pages/employees_delete.php';
});

// MonthlyMovement routes
$this->route->add('GET|POST', '/monthly-movements/all', function() {
    include_once __DIR__ . '/../Views/pages/monthly_movements_all.php';
});

$this->route->add('GET|POST', '/monthly-movements/new', function() {
    include_once __DIR__ . '/../Views/pages/monthly_movements_new.php';
});

$this->route->add('GET|POST', '/monthly-movements/view/:id', function($employee_id) {
    include_once __DIR__ . '/../Views/pages/monthly_movements_view.php';
});

$this->route->get('/monthly-movements/delete/:id', function($monthly_movements_id) {
    include_once __DIR__ . '/../Views/pages/monthly_movements_delete.php';
});
