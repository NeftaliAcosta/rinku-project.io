<?php

// Load class
use App\Controllers\EmployeesController;
use App\Enums\Roles;
use App\Libs\Tools;

// Load information to build the form dynamically
$code = Tools::EmployeeCode();
$roles = Roles::getPrettyRolesArray();

// Logic to save new register
if (!empty($_POST)) {
    $o_employee_controller = new EmployeesController();
    $a_response = $o_employee_controller->create($_POST);

    if (!$a_response['success']) {
        echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
    } else {
        echo "<div class='container alert alert-primary' role='alert'>Empleado creado correctamente.</div>";
        header("refresh:1;url=" . $_ENV['__PATH__']. 'employees/all');
    }
}

?>

<div class="container pt-md-2">
    <h1 class="text-center">Nuevo empleado</h1>
</div>

<div class="container pt-md-5">
    <div class="container mt-5">
        <form action="<?php echo $_ENV['__PATH__']. 'employees/new' ?>" method="post">
            <div class="form-group">
                <label for="code">Código</label>
                <input type="text" class="form-control" id="code" name="code" minlength="5" maxlength="5" value="<?php echo $code ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" minlength="5" maxlength="150" required>
            </div>
            <div class="form-group">
                <label for="enum_rol">Rol</label>
                <select class="form-control" id="enum_rol" name="enum_rol">
                    <?php foreach ($roles as $value => $label): ?>
                        <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
