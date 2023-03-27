<!DOCTYPE html>
<head>
    <title>Vaja 2</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class=container-fluid"">
        <div class="navbar-header">
            <a id="header" class="navbar-brand" href="../admin/index.php"> Oglasnik - administracija</a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Domov</a>
                </li>
                <?php if (isset($_SESSION["USER_ID"])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../publish.php">Objavi oglas</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../admin/index.php">Administracija</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/index.php?controller=pages&action=api">Uporaba API</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Odjava</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../login.php">Prijava</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../register.php">Registracija</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<!-- tukaj se bo vključevala koda pogledov, ki jih bodo nalagali kontrolerji -->
<!-- klic akcije iz routes bo na tem mestu zgeneriral html kodo, ki bo zalepnjena v našo predlogo -->
<?php require_once('routes.php'); ?>

</body>
</html>