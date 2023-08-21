<?php

// Load class
use App\Controllers\EmployeesController;
use App\Controllers\MonthlyMovementsController;
use App\Enums\Roles;
use App\Libs\Tools;

// Load information to build the form dynamically
$code = Tools::EmployeeCode();
$roles = Roles::getPrettyRolesArray();
$months = Tools::months();

$o_employee_controller = new EmployeesController();
$a_all_employees = $o_employee_controller->getAll();

// Logic to save new register
if (!empty($_POST)) {
    $o_monthly_movements_controller = new MonthlyMovementsController();
    $a_response = $o_monthly_movements_controller->update($_POST);

    if (!$a_response['success']) {
        echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
    } else {
        echo "<div class='container alert alert-primary' role='alert'>Registro actualizado correctamente.</div>";
        header("refresh:1;url=" . $_ENV['__PATH__']. 'monthly-movements/all');
        die();
    }
}

/** @var INT $monthly_movements_id */
$o_monthly_movements_controller = new MonthlyMovementsController();
$a_response = $o_monthly_movements_controller->view($monthly_movements_id);

// View message error if exist any exception
if (!$a_response['success']){
    echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
    die();
}
?>

<div class="container pt-md-2">
    <h1 class="text-center">Ver registro mensual</h1>
</div>

<div class="container pt-md-5">
    <div class="container mt-5">
        <form action="<?php echo $_ENV['__PATH__']. 'monthly-movements/view/' . $monthly_movements_id ?>" method="post">
            <input type="hidden" name="monthly_movements_id" value="<?php echo $monthly_movements_id ?>">
            <div class="form-group">
                <label for="employee_id">Empleado</label>
                <select class="form-control" id="employee_id" name="employee_id">
                    <?php foreach ($a_all_employees as $key => $value): ?>
                        <?php if(isset($a_response['data']['employee_id']) && $a_response['data']['employee_id'] == $value['id']) : ?>
                            <option value="<?php echo $value['id']; ?>" selected><?php echo $value['name']; ?></option>
                        <?php else : ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>
                    <select class="form-control" name="month">
                        <option selected="true" disabled="disabled">Seleccione un mes</option>
                        <?php
                        $current_month = date('n');
                        // Create select option component
                        foreach ($months as $num_month => $month_name) {
                            echo '<option value="' . $num_month . '"';
                            if ($num_month ==$a_response['data']['month']){
                                echo "selected";
                            }
                            echo '>' . $month_name . '</option>';

                            // List months up to current month
                            if ($num_month == Tools::getCurrentMonth()) {
                                break;
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>
            <div class="form-group">
                <label for="deliveries">Entregas</label>
                <input type="number" class="form-control" id="deliveries" name="deliveries" value="<?php echo $a_response['data']['deliveries'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>
