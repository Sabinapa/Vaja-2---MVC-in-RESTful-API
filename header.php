<?php
	session_start();
	
	//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
	if(isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800){
		session_regenerate_id(true);
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
	//Poveži se z bazo
	$conn = new mysqli('localhost', 'root', '', 'vaja1'); //conn globalna spr.
	//Nastavi kodiranje znakov, ki se uporablja pri komunikaciji z bazo
	$conn->set_charset("UTF8"); //kodiranje znakov
?>
<html>
<html lang="slo">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Oglasnik</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css" />
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="navbar-header">
                <a id="header" class="navbar-brand" href="index.php"> OGLASNIK</a>
            </div>

            <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Domov</a>
                </li>
                <?php
                if(isset($_SESSION["USER_ID"])){
                    ?>
                    <li class="nav-item"><a class="nav-link" href="publish.php">Objavi oglas</a></li>
                    <li class="nav-item"><a class="nav-link" href="myad.php">Moji oglasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Odjava</a></li>
                    <?php
                } else{
                    ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Prijava</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Registracija</a></li>
                    <?php
                }
                ?>
            </ul>
            </div>
        </div>
    </nav>
</body>