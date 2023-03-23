<?php
include_once('header.php'); #glava

// Funkcija preveri, ali v bazi obstaja uporabnik z določenim imenom in vrne true, če obstaja.
function username_exists($username){
	global $conn; //navesti moramo da je global
	$username = mysqli_real_escape_string($conn, $username); // varovanje da odstrani posebne znake
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query); //conn v header kjer povezemo s bazo
	return mysqli_num_rows($res) > 0; //st > 0 uporabnisko ime že obstaja
}

// Funkcija ustvari uporabnika v tabeli users. Poskrbi tudi za ustrezno šifriranje uporabniškega gesla.
function register_user($username, $password, $name, $lastname, $email, $address, $postal_number, $tel){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username); //prečistimo
	$pass = sha1($password); //zasifriramo geslo
	/* 
		Tukaj za hashiranje gesla uporabljamo sha1 funkcijo. V praksi se priporočajo naprednejše metode, ki k geslu dodajo naključne znake (salt).
		Več informacij: 
		http://php.net/manual/en/faq.passwords.php#faq.passwords 
		https://crackstation.net/hashing-security.htm
	*/
	$query = "INSERT INTO users (username, password, name, lastname, email, address, postal_number, tel) 
                       VALUES ('$username', '$pass', '$name', '$lastname', '$email', '$address', '$postal_number', '$tel');";
	if($conn->query($query)){
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

$error = "";
if(isset($_POST["submit"])){
	/*
		VALIDACIJA: preveriti moramo, ali je uporabnik pravilno vnesel podatke (unikatno uporabniško ime, dolžina gesla,...)
		Validacijo vnesenih podatkov VEDNO izvajamo na strežniški strani. Validacija, ki se izvede na strani odjemalca (recimo Javascript), 
		služi za bolj prijazne uporabniške vmesnike, saj uporabnika sproti obvešča o napakah. Validacija na strani odjemalca ne zagotavlja
		nobene varnosti, saj jo lahko uporabnik enostavno zaobide (developer tools,...).
	*/
	//Preveri če se gesli ujemata
	if($_POST["password"] != $_POST["repeat_password"]){
		$error = "Gesli se ne ujemata.";
	}
	//Preveri ali uporabniško ime obstaja
	else if(username_exists($_POST["username"])){
		$error = "Uporabniško ime je že zasedeno.";
	}
	//Podatki so pravilno izpolnjeni, registriraj uporabnika
	else if(register_user($_POST["username"], $_POST["password"], $_POST["name"], $_POST["lastname"],
        $_POST["email"], $_POST["address"], $_POST["postal_number"],$_POST["tel"] ))
    {
		header("Location: login.php"); //PREUSMERIMO na login.php
		die(); //ustvari izvajanje php sprikte
	}
	//Prišlo je do napake pri registraciji
	else{
		$error = "Prišlo je do napake med registracijo uporabnika.";
	}
}

?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Registracija</h2>
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label>Uporabniško ime *</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Ime *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Priimek *</label>
                        <input type="text" class="form-control" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail *</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Naslov</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="form-group">
                        <label>Pošta</label>
                        <input type="number"  value="0" class="form-control" name="postal_number">
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="text" class="form-control" name="tel">
                    </div>
                    <div class="form-group">
                        <label>Geslo *</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Ponovi geslo *</label>
                        <input type="password" class="form-control" name="repeat_password" required>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Pošlji">
                    <br>
                    <label><?php echo $error; ?></label>
                </form>
            </div>
        </div>
    </div>
<?php
include_once('footer.php');
?>