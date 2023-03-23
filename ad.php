<?php 
include_once('header.php');

//Funkcija izbere oglas s podanim ID-jem. Doda tudi uporabnika, ki je objavil oglas.
function get_ad($id){
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT ads.*, users.username FROM ads LEFT JOIN users ON users.id = ads.user_id WHERE ads.id = $id;";
	$res = $conn->query($query);
	if($obj = $res->fetch_object()){
		return $obj;
	}
	return null;
}

if(!isset($_GET["id"])){
	echo "Manjkajoči parametri.";
	die();
}

if (!isset($_SESSION['viewed_ads'])) {
    $_SESSION['viewed_ads'] = array(); //seja za shranjevanje ogledov za vsakega posameznega obiskovalca
}


$id = $_GET["id"];
$ad = get_ad($id);
if($ad == null){
	echo "Oglas ne obstaja.";
	die();
}

global $conn;
if (!in_array($id, $_SESSION['viewed_ads'])) { //preveri če obiskovalec že pogledo oglas
    $_SESSION['viewed_ads'][] = $id; // če ta id == obiskovalec se ni ogledo se doda v sejo ta id

    //Povečamo stevilo ogledov na oglas glede na obiskovalce
    $query = "UPDATE ads SET views = views + 1 WHERE id = $id";
    mysqli_query($conn, $query);
}


//Base64 koda za sliko (hexadecimalni zapis byte-ov iz datoteke) v string
$img_data = base64_encode($ad->image)
?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card my-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="data:image/jpg;base64, <?php echo $img_data;?>" class="card-img" alt="<?php echo $ad->title;?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $ad->title;?></h5>
                            <p class="card-text"><?php echo $ad->description;?></p>
                            <p class="card-text"><small class="text-muted">Objavil: <?php echo $ad->username; ?></small></p>
                            <p class="card-text"><small class="text-muted">Datum objave: <?php echo $ad->created_at; ?></small></p>
                            <p class="card-text"><small class="text-muted">Ogledov: <?php echo $ad->views; ?></small></p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" id="ReadMoreButtom" class="btn btn-primary">Nazaj</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include_once('footer.php');
?>