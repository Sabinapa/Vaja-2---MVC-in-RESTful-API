<?php

/*
    Tudi API za delovanje uporablja arhitekturo MVC.
    V primeru API-ja nimamo view-ov, saj API vrača strukturirane podatke v JSON formatu.
    Posledično akcije kontrolerja ne vključujejo datotek z view-i, ampak izpisujejo JSON nize.

    Akcije:
        index: izpiše vse oglase
        show: izpiše en oglas
        store: vstavi oglas v bazo
        update: posodobi obstoječi oglas v bazi
        delete: izbriše oglas iz baze
*/

//kontroler za delo z komentarji
class comments_controller
{

    public function index()
    {
        // Iz modela pidobimo vse oglase
        $com = comment::all();

        //izpišemo $ads v JSON formatu
        echo json_encode($com);
    }

    public function show($id)
    {
        $com = comment::all();
        $come = array();
        foreach ($com as $i)
        {
            if($i->ad_id==$id)
            {
                array_push($come, $i);
            }
        }
        echo json_encode($come);
    }

    public function store()
    {
        // Store se pokliče z POST, zato so podatki iz obrazca na voljo v $_POST
        $comment = comment::insert($_POST["ad_id"], $_POST["content"]);
        // Vrnemo vstavljen oglas
        echo json_encode($comment);
    }

    public function update($id)
    {
        // Update se pokliče z PUT, zato nima podatkov v formData ($_POST).
        // Namesto tega smo jih poslali v body-u HTTP zahtevka v JSON formatu.
        $data = file_get_contents('php://input'); //preberemo body iz zahtevka
        $data = json_decode($data, true); //dekodiramo JSON string v PHP array

        // Poiščemo in posodobimo oglas
        $ad = comment::findCommentAds($id);
        //$ad = $ad->update($data["title"], $data["description"], null);

        // Vrnemo posodobljen oglas
        echo json_encode($ad);
    }

    public function delete($id)
    {
        // Poiščemo in izbrišemo oglas
        $comment = comment::findComment($id);
        $comment->delete();
        // Vrnemo podatke iz izbrisanega oglasa
        echo json_encode($comment);
    }

}
