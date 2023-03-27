<?php
include_once('header.php');

//Funkcija izbere oglas s podanim ID-jem. Doda tudi uporabnika, ki je objavil oglas.
function get_ad($id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT ads.*, users.username FROM ads LEFT JOIN users ON users.id = ads.user_id WHERE ads.id = $id;";
    $res = $conn->query($query);
    if ($obj = $res->fetch_object()) {
        return $obj;
    }
    return null;
}

if (!isset($_GET["id"])) {
    echo "Manjkajoči parametri.";
    die();
}

if (!isset($_SESSION['viewed_ads'])) {
    $_SESSION['viewed_ads'] = array(); //seja za shranjevanje ogledov za vsakega posameznega obiskovalca
}


$id = $_GET["id"];
$ad = get_ad($id);
if ($ad == null) {
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

$comments = array(); // inicializacija spremenljivke $comments

//Base64 koda za sliko (hexadecimalni zapis byte-ov iz datoteke) v string
$img_data = base64_encode($ad->image)
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card my-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="data:image/jpg;base64, <?php echo $img_data; ?>" class="card-img"
                             alt="<?php echo $ad->title; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $ad->title; ?></h5>
                            <p class="card-text"><?php echo $ad->description; ?></p>
                            <p class="card-text"><small class="text-muted">Objavil: <?php echo $ad->username; ?></small>
                            </p>
                            <p class="card-text"><small class="text-muted">Datum
                                    objave: <?php echo $ad->created_at; ?></small></p>
                            <p class="card-text"><small class="text-muted">Ogledov: <?php echo $ad->views; ?></small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" id="ReadMoreButtom" class="btn btn-primary">Nazaj</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($_SESSION['USER_ID'])) { ?> <!-- Samo če uporabnik prijavljen lahko komentira -->
                <div id="comment_field">
                    <h4>Komentarji:</h4>
                    <div id="comments"></div> <!-- Tukaj prikazejo komentarji -->
                    <div class="form-group mt-3">
                        <label for="commentInput">Vnesi komentar:</label>
                        <input type="text" class="form-control" id="commentInput">
                    </div>
                    <button type="button" class="btn btn-primary" id="publish">Objavi</button>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        var id = <?php echo $_SESSION["USER_ID"]; ?>; //pridobimo prijavljeni id od user
        var userId = <?php echo $ad->user_id; ?>; //pridobimo od oglasa user id

        $(document).ready(async function () { // stran v celoti naloži.
            await loadComments(); //ta vrstica kliče funkcijo loadComments(), ki bo asinhrono naložila vse komentarje in jih prikazala na strani.
            $("#publish").click(createComment) // ta vrstica določa, da se funkcija createComment() kliče, ko uporabnik klikne gumb "Objavi" s podatki, ki jih vnese v obrazec za komentarje
            $(".delete_ad_btn").click(deleteClickHandler); // ta vrstica določa, da se funkcija deleteClickHandler() kliče, ko uporabnik klikne gumb "Izbriši" pri oglasu, ki ga želi izbrisati.

        });

        async function loadComments() { //nalozi komentarje
            await $.get("api/index.php/comments/<?php echo $ad->id ?>", renderComments);
            //pri oglasu ovcka prikazali komentarji samo za ta oglas
        }

        function renderComments(comments) {
            $("#comments").empty();

            comments.forEach(function(comment) {
                //novi div z razredoma card in id (komentar oblika + id)
                var commentCard = $("<div>").addClass("card").attr("id", "comment-" + comment.id);

                var cardBody = $("<div>").addClass("card-body");
                var cardTitle = $("<h5>").addClass("card-title").text(comment.user.username); //username lastnika komentara oz ki je komentiro
                var cardText = $("<p>").addClass("card-text").text(comment.content); //vsebina tega komentara

                cardBody.append(cardTitle).append(cardText); //zdruzitev kartic v eno

                commentCard.append(cardBody);
                //console.log(comment.user.id);
                //console.log(id);

                if (comment.user.id == id || userId == id) { //prijavljeni uporabnik == uporabnik komentara || prijavljeni uporabnik == lastnik oglasa
                    var deleteBtn = $("<button>").addClass("btn btn-danger delete_ad_btn float-end").text("Izbriši");
                    var deleteCell = $("<div>").addClass("d-flex justify-content-end mb-3").append(deleteBtn);
                    commentCard.append(deleteCell);
                }

                $("#comments").append(commentCard); //doda se kartica v div
            });
        }

        function createComment() {
            // Pridobi vsebino iz polja za komentae
            var content = $("#commentInput").val();

            // Ustvarjnen objekt ki bo poslan na streznik
            var comment = {
                ad_id: <?php echo $ad->id ?>, // id oglasa na katerem vpisemo komentar
                user_id : <?php echo $_SESSION["USER_ID"]; ?>,
                content: content // vsebina komentarja
            };

            //poslejmo podatke s POST
            $.post('api/index.php/comments/', comment, function (data) {
                loadComments() //NALOZI novi komentar avtomasko polek
                // Clear the input field after the comment has been added
                $("#commentInput").val(""); //počisti polje za vnos
            });
        }

        function deleteClickHandler() {
            var row = $(this).closest("tr"); //dobimo vrstico kjer klikno uporabnik brisi
            var id = row.attr("id").substr(8); // odstranimo predpono "comment-"
            deleteComment(id); //klicemo funkcijo
            row.remove(); //toto vrrstico zbrisemo
        }

        function deleteComment(id) //sprejme id
        {
            console.log(id);
            $.ajax({
                url: 'api/index.php/comments/' + id,
                method: 'DELETE'
            });
        }

    </script>

<?php
include_once('footer.php');
?>