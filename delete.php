<?php
include_once('header.php'); //vkljucimo glavo

// Preveri, ali je uporabnik prijavljen
#session_start();
if (!isset($_SESSION['USER_ID'])) {
    header('Location: login.php');
    exit();
}

// Preveri, ali je GET parameter id nastavljen
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['USER_ID'];

    global $conn;
    // Izbrisi oglas iz baze, ce pripada trenutno prijavljenemu uporabniku
    $query = "DELETE FROM ads WHERE id = $id AND user_id = $user_id";
    if($conn->query($query)){
        ?>
        <div id="pdelete">
        <p>
            <?php echo "Oglas je bil uspešno izbrisan."; ?>
        </p>
        </div>
     <?php
        include_once('myad.php');
    }
    else{
        ?>
        <div id="pdelete">
            <p>
                echo "Napaka pri brisanju oglasa: " . mysqli_error($conn); ?>
            </p>
        </div>
        <?php
    }
}

include_once('footer.php'); //vkljucimo nogo
?>