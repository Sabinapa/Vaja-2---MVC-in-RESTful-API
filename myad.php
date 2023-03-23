<?php
include_once('header.php'); //vkljucimo glavo

// Funkcija prebere oglase iz baze in vrne polje objektov
function get_user_ads(){
    global $conn;
    $userId = $_SESSION['USER_ID'];
    $query = "SELECT * FROM ads WHERE user_id='$userId';";
    $res = $conn->query($query);
    $ads = array();
    while($ad = $res->fetch_object()){
        array_push($ads, $ad);
    }
    return $ads;
}

//Preberi oglase iz baze za prijavljenea trenutno uporavnika
$ads = get_user_ads();

//Izpiši oglase za prijavljenega uporanika
 foreach($ads as $ad): ?>
    <div class="card my-3">
        <div class="card-body">
            <h4 class="card-title"><?php echo $ad->title;?></h4>
            <p class="card-text"><?php echo $ad->description;?></p>
            <a href="ad.php?id=<?php echo $ad->id;?>" id="ReadMoreButtom" class="btn mr-2">Preberi več</a>
            <a href="delete.php?id=<?php echo $ad->id;?>" id="DeleteButtom" class="btn mr-2">Briši</a>
            <a href="update.php?id=<?php echo $ad->id;?>" id="UpdateButttom" class="btn">Uredi</a>
        </div>
    </div>
<?php endforeach;

include_once('footer.php'); //vkljucimo nogo
?>