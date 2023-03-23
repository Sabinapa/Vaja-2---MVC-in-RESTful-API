<?php

// Model za uporabnika
/*
    Model z uporabniki.
    Čeprav nimamo users_controller-ja, ta model potrebujemo pri oglasih, 
    saj oglas vsebuje podatke o uporabniku, ki je oglas objavil.
    Razred implementira metodo find, ki jo uporablja Ads model zato, da 
    user_id zamenja z instanco objekta User z vsemi podatki o uporabniku.
*/

class User
{
    public $id;
    public $username;
    public $password;
    public $name;
    public $lastname;
    public $email;
    public $address;
    public $postal_number;
    public $tel;
    public $administrator;


    // Konstruktor
    public function __construct($id, $username, $password, $name, $lastname, $email, $address, $postal_number, $tel, $administrator)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->address = $address;
        $this->postal_number = $postal_number;
        $this->tel = $tel;
        $this->administrator = $administrator;

    }

    // Metoda, ki vrne uporabnika z določenim ID-jem iz baze
    public static function find($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM users WHERE id = '$id';";
        $res = $db->query($query);
        if ($user = $res->fetch_object()) {
            return new User($user->id, $user->username, $user->password, $user->name, $user->lastname, $user->email, $user->address, $user->postal_number, $user->tel, $user->administrator);
        }
        return null;
    }

}
