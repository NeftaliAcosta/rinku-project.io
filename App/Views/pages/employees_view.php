<?php
// Load class
use App\Controllers\EmployeesController;
use App\Enums\Roles;

// Load information to build the form dynamically
$roles = Roles::getPrettyRolesArray();

// Logic to save new register
if (!empty($_POST)) {
    $o_employee_controller = new EmployeesController();
    $a_response = $o_employee_controller->update($_POST);

    if (!$a_response['success']) {
        echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
    } else {
        echo "<div class='container alert alert-primary' role='alert'>Empleado actualizado correctamente.</div>";
        header("refresh:1;url=" . $_ENV['__PATH__']. 'employees/all');
    }
}

/** @var INT $employee_id */
$o_employee_controller = new EmployeesController();
$a_response = $o_employee_controller->view($employee_id);

// View message error if exist any exception
if (!$a_response['success']){
    echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
    die();
}
?>

<div class="container pt-md-2">
    <h1 class="text-center">Ver empleado</h1>
</div>

<div class="container pt-md-5">
    <div class="container mt-5">
        <form action="<?php echo $_ENV['__PATH__']. 'employees/view/' . $employee_id ?>" method="post">
            <input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">
            <div class="form-group">
                <label for="code">Código</label>
                <input type="text" class="form-control" id="code" name="code" minlength="5" maxlength="5" value="<?php echo $a_response['data']['code'] ?? '' ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" minlength="5" maxlength="150" value="<?php echo $a_response['data']['name'] ?? '' ?>" required>
            </div>
            <div class="form-group">
                <label for="enum_rol">Rol</label>
                <select class="form-control" id="enum_rol" name="enum_rol">
                    <?php foreach ($roles as $value => $label): ?>
                        <?php if(isset($a_response['data']['enum_rol']) && $a_response['data']['enum_rol'] == $value) : ?>
                            <option value="<?php echo $value; ?>" selected><?php echo $label; ?></option>
                        <?php else : ?>
                            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>
