<?php
// Load class
use App\Controllers\MonthlyMovementsController;

// Logic to delete register
/** @var INT $monthly_movements_id */
$o_monthly_movements_controller =  new MonthlyMovementsController();
$a_response = $o_monthly_movements_controller->delete($monthly_movements_id);

if (!$a_response['success']) {
    echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
} else {
    echo "<div class='container alert alert-primary' role='alert'>Registro eliminado correctamente.</div>";
    header("refresh:1;url=" . $_ENV['__PATH__']. 'monthly-movements/all');
}
?>

<div class="container pt-md-2">
    <h1 class="text-center">Eliminar movimiento mensual</h1>
</div>

