<?php
include_once('header.php');

// Funkcija vstavi nov oglas v bazo. Preveri tudi, ali so podatki pravilno izpolnjeni. 
// Vrne false, če je prišlo do napake oz. true, če je oglas bil uspešno vstavljen.
function publish($title, $desc, $img, $categories)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title); //prečistimo
    $desc = mysqli_real_escape_string($conn, $desc); //prečistimo
    $user_id = $_SESSION["USER_ID"]; //rabimo uporabnika preberemo iz seje

    //Preberemo vsebino (byte array) slike
    $img_file = file_get_contents($img["tmp_name"]); //preberemo vsebino
    //Pripravimo byte array za pisanje v bazo (v polje tipa LONGBLOB)
    $img_file = mysqli_real_escape_string($conn, $img_file);

    // Dobimo id od kategorije ker vnašamo zabava, zivali potebujemo pa 2,3
    $categoryIDs = array();
    foreach ($categories as $category) {
        $categoryQuery = "SELECT id FROM category WHERE name = '$category'";
        $categoryResult = mysqli_query($conn, $categoryQuery);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryIDs[] = $categoryRow['id'];
    }

    $query = "INSERT INTO ads (title, description, user_id, image, created_at, views) 
              VALUES('$title', '$desc', '$user_id', '$img_file', NOW(), 0);"; //ko se ustvari oglas ima 0 ogledov

    if ($conn->query($query)) {
        $ad_id = mysqli_insert_id($conn);
        foreach ($categoryIDs as $categoryID) {
            $query = "INSERT INTO ad_category (ad_id, category_id) VALUES ('$ad_id', '$categoryID');";
            $conn->query($query);
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
    if (publish($_POST["title"], $_POST["description"], $_FILES["image"], $_POST['categories'])) {
        header("Location: index.php");
        die();
    } else {
        $error = "Prišlo je do našpake pri objavi oglasa.";
    }
}

?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Objavi oglas</h2>
                <form action="publish.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Naslov</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="categories">Kategorija</label>
                        <select name="categories[]" multiple class="form-control" id="categories">
                            <?php foreach (getKategorija() as $category): ?>
                                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Vsebina</label>
                        <textarea name="description" class="form-control" id="description" rows="10" cols="50"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Slika</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" name="submit" id="UpdateButttom" class="btn">Objavi</button>
                    <span class="text-danger ml-3"><?php echo $error; ?></span>
                </form>
            </div>
        </div>
    </div>
<?php
include_once('footer.php');
?>