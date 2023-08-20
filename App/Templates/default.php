<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.1.1">
        <title>Rinku Dashboard</title>

        <link rel="stylesheet" href="<?php echo $_ENV['__PATH__'].'/resources/css/mystyle.css' ?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <style>

        </style>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <div class="my-0 mr-md-auto font-weight-normal">
            <img src="<?php echo $_ENV['__PATH__'].'/resources/img/rinku_logo.png' ?>" alt="Logo" width="200px">
        </div>
        <nav class="my-2 my-md-0 mr-md-3 d-flex align-items-center">
            <a class="p-2 text-dark" href="<?php echo $_ENV['__PATH__'] ?>">Inicio</a>
            <div class="ml-3 dropdown">
                <a class="p-2 text-dark dropdown-toggle" href="#" id="empleadosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Empleados
                </a>
                <div class="dropdown-menu" aria-labelledby="empleadosDropdown">
                    <a class="dropdown-item" href="<?php echo $_ENV['__PATH__'] ?>employees/new">Nuevo</a>
                    <a class="dropdown-item" href="<?php echo $_ENV['__PATH__'] ?>employees/all">Listar todos</a>
                </div>
            </div>
            <div class="ml-3 dropdown">
                <a class="p-2 text-dark dropdown-toggle" href="#" id="registrosMensualesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Registros mensuales
                </a>
                <div class="dropdown-menu" aria-labelledby="registrosMensualesDropdown">
                    <a class="dropdown-item" href="<?php echo $_ENV['__PATH__'] ?>monthly-movements/new">Nuevo</a>
                    <a class="dropdown-item" href="<?php echo $_ENV['__PATH__'] ?>monthly-movements/all">Listar todos</a>
                </div>
            </div>
        </nav>


        <a class="btn btn-outline-primary" href="#">Log out</a>
    </div>

    <div class="container-fluid">
        <?php
            // Routes
            self::pages();
        ?>
    </div>

    <footer class="container pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 text-center">
                <small class="d-block mb-3 text-muted">&copy; <?php echo date("Y") ?> by Neftalí Marciano Acosta</small>
            </div>
        </div>
    </footer>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="<?php echo  $_ENV['__PATH__'] . 'resources/js/myjs.js' ?>" ></script>

</body>
</html>
