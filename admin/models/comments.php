<?php
/*
    Model za oglas. Vsebuje lastnosti, ki definirajo strukturo oglasa in sovpadajo s stolpci v bazi.
    Nekatere metode so statične, ker niso vezane na posamezen oglas: poišči vse oglase, vstavi nov oglas, ...
    Druge so statične, ker so vezane na posamezen oglas: posodobi oglas, izbriši oglas, ...

    V modelu moramo definirati tudi relacije oz. povezane entitete/modele. V primeru oglasa je to $user, ki
    povezuje oglas z uporabnikom, ki je oglas objavil. Relacija nam poskrbi za nalaganje podatkov o uporabniku,
    da nimamo samo user_id, ampak tudi username, ...
*/

require_once 'users.php'; // Vključimo model za uporabnike

class comment
{
    public $id;
    public $user_id;
    public $ad_id;
    public $content;

    // Konstruktor
    public function __construct($id, $user_id, $ad_id, $content)
    {
        $this->id = $id;
        $this->user = User::find($user_id); //naložimo podatke o uporabniku
        $this->ad_id = $ad_id;
        $this->content = $content;

    }

    // Metoda, ki iz baze vrne vse komentarje
    public static function all()
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $query = "SELECT * FROM comments;"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $comments = array();
        while ($comments = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $ads
            array_push($comments, new comment($comment->id, $comment->user_id, $comment->ad_id, $comment->content));
        }
        return $comments;
    }

    // Metoda, ki vrne en komentar z specifičnim id-jem iz baze
    public static function findComment($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM comments WHERE comments.id = '$id';";
        $res = $db->query($query);
        if ($comment = $res->fetch_object()) {
            return new comment($comment->id, $comment->user_id, $comment->ad_id, $comment->content);
        }
        return null;
    }

    public static function findCommentAds($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM comments WHERE comments.id = '$id';";
        $res = $db->query($query);
        $comments = array();
        if ($comment = $res->fetch_object()) {
            array_push($comments, new comment($comment->id,$comment->user_id, $comment->ad_id, $comment->content));
        }
        return $comments;
    }


    // Metoda, ki doda nov komentar v bazo
    public static function insert($ad_id, $content)
    {
        $db = Db::getInstance();
        $ad_id = mysqli_real_escape_string($db, $ad_id);
        $content = mysqli_real_escape_string($db, $content);

        $user_id = $_SESSION["USER_ID"]->id; // user_id vzamemo iz seje (prijavljen uporabnik)

        $query = "INSERT INTO comments (user_id, ad_id, content) VALUES('$user_id', '$ad_id', '$content');";
        if ($db->query($query)) {
            $id = mysqli_insert_id($db); // preberemo id, ki ga je dobil vstavljen oglas
            return comment::findCommentAds($id); // preberemo nov oglas iz baze in ga vrnemo controllerju
        } else {
            return null; // v primeru napake vrnemo null
        }
    }

    // Metoda, ki izbriše oglas iz baze
    public function delete()
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $this->id);
        $query = "DELETE FROM comments WHERE id = '$id'";
        if ($db->query($query)) {
            return true;
        } else {
            return false;
        }
    }
}
