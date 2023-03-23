<?php
include_once('header.php'); //vkljucimo glavo

// Funkcija prebere oglase iz baze in vrne polje objektov
function get_ads(){
    global $conn;
    $query = "SELECT * FROM ads ORDER BY created_at DESC;";
    $res = $conn->query($query);
    $ads = array();
    while($ad = $res->fetch_object()){
        array_push($ads, $ad);
    }
    return $ads;
}

//Preberi oglase iz baze
$ads = get_ads();

?>
    <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="text-center">OGLASI</h1>
                <?php foreach($ads as $ad):
                    $img_data = base64_encode($ad->image) ?>
                    <div class="card my-5">
                        <div class="row no-gutters">
                            <div class="col-md-5">
                                <img src="data:image/jpg;base64, <?php echo $img_data;?>" class="card-img" alt="<?php echo $ad->title;?>">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $ad->title;?></h4>

                                    <h5 class="card-subtitle mb-2 text-muted">
                                        <?php
                                        $ad_id = $ad->id; #id od oglasa
                                        $query = "SELECT category_id FROM ad_category WHERE ad_id=$ad_id"; #dobimo od kategorije id
                                        global $conn;
                                        $result = mysqli_query($conn, $query);
                                        $categories = array();
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $category_id = $row['category_id'];
                                            $query2 = "SELECT name FROM category WHERE id=$category_id"; # z category id dobivamo ime kategorije
                                            $result2 = mysqli_query($conn, $query2);
                                            $category = mysqli_fetch_assoc($result2);
                                            array_push($categories, $category['name']); #polnimo array
                                        }
                                        echo "Kategorije: ",implode(", ", $categories); #izpis npr. živali, mačka
                                        ?>
                                    </h5>
                                    <p class="card-text"><?php echo $ad->description;?></p>
                                    <div class="card-footer text-center">
                                        <a href="ad.php?id=<?php echo $ad->id;?>" class="btn btn-primary" id="ReadMoreButtom">Preberi več o oglasu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </body>

</html>

<?php
include_once('footer.php'); //vkljucimo nogo
?>