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
                    <div id="comments"></div>
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
        var id = <?php echo $_SESSION["USER_ID"]; ?>;
        var userId = <?php echo $ad->user_id; ?>;

        $(document).ready(async function () {
            await loadComments();
            $("#publish").click(createComment)
            $(".delete_ad_btn").click(deleteClickHandler);

        });

        async function loadComments() {
            await $.get("api/index.php/comments/<?php echo $ad->id ?>", renderComments);
            //pri oglasu ovcka prikazali komentarji samo za ta oglas
        }

        function renderComments(comments) {
            $("#comments").empty();

            comments.forEach(function(comment) {
                var row = $("<tr>").attr("id", "comment-" + comment.id);

                // Create table cells for the comment content and user ID
                var contentCell = $("<td>").text(comment.content);
                var userCell = $("<td>").text(comment.user.username);

                row.append(contentCell).append(userCell);
                //console.log(comment.user.id);
                //console.log(id);

                if (comment.user.id == id) {
                    var deleteBtn = $("<button>").addClass("delete_ad_btn").text("Izbriši");
                    var deleteCell = $("<td>").append(deleteBtn);
                    row.append(deleteCell);
                } else {
                    row.append("<td></td>");
                }

                row.append(deleteCell);

                $("#comments").append(row);
            });
        }

        function createComment() {
            // Retrieve the comment content from the input field
            var content = $("#commentInput").val();

            // Create the comment object to be sent to the server
            var comment = {
                ad_id: <?php echo $ad->id ?>, // set the ID of the ad for which the comment is being posted
                user_id : <?php echo $_SESSION["USER_ID"]; ?>,
                content: content // set the content of the comment
            };

            $.post('api/index.php/comments/', comment, function (data) {
                //renderComments(data)
                loadComments()
                // Clear the input field after the comment has been added
                $("#commentInput").val("");
            });
        }

        function deleteClickHandler() {
            var row = $(this).closest("tr");
            var id = row.attr("id").substr(8); // odstranimo predpono "comment-"
            deleteComment(id);
            row.remove();
        }

        function deleteComment(id)
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