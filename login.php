<?php
include_once('header.php');

function validate_login($username, $password){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$pass = sha1($password); //enaki algoritem kot pri registraciji
	$query = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
	$res = $conn->query($query);
	if($user_obj = $res->fetch_object()){ //ce imamo zadetek vrnemo id
		if($user_obj -> administrator == 1)
        {
            $_SESSION["administrator"] = 1;
        }
        else
        {
            $_SESSION["administrator"] = 0;
        }
        return $user_obj->id;
	}
	return -1;
}

$error="";
if(isset($_POST["submit"])){
	//Preveri prijavne podatke
	if(($user_id = validate_login($_POST["username"], $_POST["password"])) >= 0){ // ce najdemo uporabnika
		//Zapomni si prijavljenega uporabnika v seji in preusmeri na index.php
		$_SESSION["USER_ID"] = $user_id; //seja trajno hranijo spr.
		header("Location: index.php");
		die();
	} else{
		$error = "Prijava ni uspela.";
	}
}
?>
    <div class="container d-flex justify-content-center align-items-center vh-60">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Prijava</h2>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Uporabniško ime</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Geslo</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit"  name="submit" class="btn btn-primary btn-block">Pošlji</button>
                </form>
                <div class="text-center mt-3">
                    <label><?php echo $error; ?></label>
                </div>
            </div>
        </div>
    </div>
<?php
include_once('footer.php');
?>