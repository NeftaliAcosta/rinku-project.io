<?php

// Get all information from controller
use App\Controllers\EmployeesController;

$o_employees_controller =  new EmployeesController();
$data = $o_employees_controller->getAll();

?>

<div class="container pt-md-2">
    <h1 class="text-center">Empleados</h1>
</div>

<div class="container pt-md-5">
    <table class="table table-respive table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Código</th>
            <th scope="col">Empleado</th>
            <th scope="col">Rol</th>
            <th scope="col">Salario base</th>
            <th scope="col">Fecha de creacion</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $key=>$value): ?>
        <tr>
            <td><?= $value['id']; ?></td>
            <td><?= $value['code']; ?></td>
            <td><?= $value['name']; ?></td>
            <td><?= $value['enum_rol']; ?></td>
            <td><?= $value['base_salary']; ?></td>
            <td><?= $value['creation_date']; ?></td>
            <td>
                <a href="<?php echo $_ENV['__PATH__']. 'employees/view/' . $value['id'] ?>" class="btn btn-primary mb-1">Ver</a>
                <br>
                <a href="<?php echo $_ENV['__PATH__']. 'employees/delete/' . $value['id'] ?>" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
