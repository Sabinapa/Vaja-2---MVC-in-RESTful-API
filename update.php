<?php
include_once('header.php');
function change($title, $desc, $img, $categories, $id)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title); //prečistimo
    $desc = mysqli_real_escape_string($conn, $desc); //prečistimo
    $user_id = $_SESSION["USER_ID"]; //rabimo uporabnika preberemo iz seje

    //Dobimo idje
    $categoryIDs = array();
    foreach ($categories as $category) {
        $categoryQuery = "SELECT id FROM category WHERE name = '$category'";
        $categoryResult = mysqli_query($conn, $categoryQuery);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryIDs[] = $categoryRow['id'];
    }

    //Preberemo vsebino (byte array) slike
    $img_file = file_get_contents($img["tmp_name"]); //preberemo vsebino
    //Pripravimo byte array za pisanje v bazo (v polje tipa LONGBLOB)
    $img_file = mysqli_real_escape_string($conn, $img_file);

    $query = "UPDATE ads SET title='$title', description='$desc', user_id='$user_id', image='$img_file', created_at=NOW()
               WHERE id='$id'";

    if ($conn->query($query)) {
        //pobrisemo obstajajoče kategorije
        mysqli_query($conn, "DELETE FROM ad_category WHERE ad_id = '$id'");
        //vstavimo novo kategoriji za oglas
        foreach ($categoryIDs as $categoryID) {
           //echo "id, $id";
            //echo "kategorija, $categoryID";
            mysqli_query($conn,"INSERT INTO ad_category (ad_id, category_id) VALUES ('$id', '$categoryID')");
        }
        return true;
    } else {
        //Izpis MYSQL napake z: echo mysqli_error($conn);
        return false;
    }

}

function getKategorija()
{
    global $conn;
    $sql = "SELECT name FROM category";
    $result = mysqli_query($conn, $sql);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['name'];
    }

    return $categories;
}


$error = "";
if (isset($_POST["submit"]))
{
    if (change($_POST["title"], $_POST["description"], $_FILES["image"], $_POST['categories'],  $_POST['id'])) {
        header("Location: index.php");
        die();
    } else {
        $error = "Prišlo je do našpake pri objavi oglasa.";
    }
}

if (isset($_GET['id'])) {
    global $conn;
    $ad_id = $_GET['id'];
    // Preberemo podatke o oglasu iz baze in jih shranimo v spremenljivke
    $query = "SELECT * FROM ads WHERE id=$ad_id";
    $result = mysqli_query($conn, $query);
    $ad = mysqli_fetch_assoc($result);
    $title = $ad['title'];
    $user_id = $ad['user_id'];
    $description = $ad['description'];

    // Poiscemo id v tabeli ad_category
    $category_query = "SELECT ad_category.category_id AS id FROM ad_category JOIN ads ON ad_category.ad_id=ads.id WHERE ad_category.ad_id = '$ad_id'";
    $category_result = mysqli_query($conn, $category_query);
    $category_id = array();
    while ($row = mysqli_fetch_assoc($category_result)) {
        $category_id[] = $row['id'];
    }

    #echo $ad_id;
    #echo '<br>';
    #echo implode(',', $category_id);
}

?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="my-4">Objavi oglas</h2>
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="id" hidden="hidden" value="<?php echo $ad_id; ?>"/>
                    <div class="form-group">
                        <label>Naslov</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $title; ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Kategorija</label>
                        <select class="form-control" name="categories[]" multiple>
                            <?php foreach (getKategorija() as $category): ?>
                                <?php if (in_array($category, $category_id)): ?>
                                    <option value="<?php echo $category; ?>" selected><?php echo $category; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vsebina</label>
                        <textarea name="description" rows="10" cols="50" class="form-control"><?php echo $description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Slika</label>
                        <input type="file" name="image" class="form-control-file"/>
                    </div>
                    <input type="submit" name="submit" value="Update"  id="UpdateButttom" class="btn"/>
                    <label><?php echo $error; ?></label>
                </form>
            </div>
        </div>
    </div>
<?php

include_once('footer.php');
?>