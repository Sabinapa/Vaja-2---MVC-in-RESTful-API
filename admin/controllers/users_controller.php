<?php
/*
    Controller za oglase. Vključuje naslednje standardne akcije:
        index: izpiše vse oglase
        show: izpiše posamezen oglas
        create: izpiše obrazec za vstavljanje oglasa
        store: vstavi obrazec v bazo
        edit: izpiše vmesnik za urejanje oglasa
        update: posodobi oglas v bazi
        delete: izbriše oglas iz baze
*/

class users_controller
{
    public function index()
    {
        //s pomočjo statične metode modela, dobimo seznam vseh UPORABNIKOV
        //$ads bo na voljo v pogledu za vse oglase index.php
        $users = User::all();

        //pogled bo oblikoval seznam vseh UPORABNIKOV v html kodo
        require_once('views/ads/index.php');
    }

    public function show()
    {
        //preverimo, če je uporabnik podal informacijo, o UPORABNIKU, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo UPORABNIK in ga prikažemo
        $user = User::find($_GET['id']);
        require_once('views/ads/show.php');
    }

    public function create()
    {
        // Izpišemo pogled z obrazcem za vstavljanje UPORABNIKOV
        require_once('views/ads/create.php');
    }

    public function store()
    {
        // Obdelamo podatke iz obrazca (views/ads/create.php), akcija pričakuje da so podatki v $_POST
        // Tukaj bi morali podatke še validirati, preden jih dodamo v bazo

        // Pokličemo metodo za ustvarjanje novega UPORABNIKA
        $user = User::insert($_POST["username"], $_POST["password"], $_POST["name"], $_POST["lastname"], $_POST["email"],
                             $_POST["address"], $_POST["postal_number"],$_POST["tel"], $_POST["administrator"] );

        //ko je UPORABNIK dodan, imamo v $USER podatke o tem novem oglasu
        //uporabniku lahko pokažemo pogled, ki ga bo obvestil o uspešnosti oddaje UPORABNIKA
        require_once('views/ads/createSuccess.php');
    }

    public function edit()
    {
        // Ob klicu akcije se v URL poda GET parameter z ID-jem UPORABNIKA, ki ga urejamo
        // Od modela pridobimo podatke o oglasu, da lahko predizpolnimo vnosna polja v obrazcu
        if (!isset($_GET['id'])) {
            return call('pages', 'error');
        }
        $user = User::find($_GET['id']);
        require_once('views/ads/edit.php');
    }

    public function update()
    {
        // Obdelamo podatke iz obrazca (views/ads/edit.php), ki pridejo v $_POST.
        // Pričakujemo, da je v $_POST podan tudi ID UPORABNIKA, ki ga posodabljamo.
        if (!isset($_POST['id'])) {
            return call('pages', 'error');
        }
        // Naložimo UPORABNIKA
        $user = User::find($_POST['id']);
        // Pokličemo metodo, ki posodobi obstoječi UPORABNIKA v bazi
        $user = $user->update($_POST["username"], $_POST["name"], $_POST["lastname"], $_POST["email"],
                             $_POST["address"], $_POST["postal_number"],$_POST["tel"], $_POST["administrator"] );
        // Izpišemo pogled s sporočilom o uspehu
        require_once('views/ads/editSuccess.php');
    }

    public function delete()
    {
        // Obdelamo zahtevo za brisanje UPORABNIKA. Akcija pričakuje, da je v URL-ju podan ID UPORABNIKA.
        if (!isset($_GET['id'])) {
            return call('pages', 'error');
        }
        // Poiščemo UPORABNIKA
        $user = User::find($_GET['id']);
        // Kličemo metodo za izbris UPORABNIKA iz baze.
        $user->delete();
        // Izpišemo sporočilo o uspehu
        require_once('views/ads/deleteSuccess.php');
    }
}
