<?php

// Get all information from controller
use App\Controllers\MonthlyMovementsController;

if (!empty($_POST)) {
    $month_to_search = $_POST['month'];
} else {
    $month_to_search = null;
}

$o_monthly_movements_controller =  new MonthlyMovementsController();
$data = $o_monthly_movements_controller->getAll((int)$month_to_search);

// Array months
$months = array(
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
    4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
    7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
    10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
);

?>

<div class="container pt-md-2">
    <h1 class="text-center">Movimientos mensuales</h1>
</div>


<div class="container mt-5">
    <form class="form-inline" action="<?php echo $_ENV['__PATH__']. 'monthly-movements/all' ?>" method="post">
        <div class="form-group mr-2">
            <label>
                <select class="form-control" name="month">
                    <option selected="true" disabled="disabled">Seleccione un mes</option>
                    <?php
                    $current_month = date('n');
                    // Create select option component
                    foreach ($months as $num_month => $month_name) {
                        echo '<option value="' . $num_month . '"';
                        if ($num_month == $month_to_search) {
                            echo ' selected';
                        }
                        echo '>' . $month_name . '</option>';
                    }
                    ?>
                </select>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
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
            <th scope="col">Entregas</th>
            <th scope="col">Salario extra</th>
            <th scope="col">Impuestos</th>
            <th scope="col">Voucher</th>
            <th scope="col">Fecha de creacion</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $key=>$value): ?>
        <tr>
            <td><?= $value['id']; ?></td>
            <td><?= $value['employee_code']; ?></td>
            <td><?= $value['employee_name']; ?></td>
            <td><?= $value['employee_enum_rol']; ?></td>
            <td><?= $value['employee_salary_base']; ?></td>
            <td><?= $value['deliveries']; ?></td>
            <td><?= $value['extra_salary']; ?></td>
            <td><?= $value['taxes']; ?></td>
            <td><?= $value['grocery_vouchers']; ?></td>
            <td><?= $value['creation_date']; ?></td>
            <td>
                <a href="<?php echo $_ENV['__PATH__']. 'monthly-movements/view/' . $value['id'] ?>" class="btn btn-primary mb-1">Ver</a>
                <br>
                <a href="<?php echo $_ENV['__PATH__']. 'monthly-movements/delete/' . $value['id'] ?>" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
