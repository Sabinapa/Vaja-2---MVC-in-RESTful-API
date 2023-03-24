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
    public static function all()
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $query = "SELECT * FROM users;"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $users = array();
        while ($user = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $ads
            array_push($users, new User($user->id, $user->username, $user->password, $user->name, $user->lastname, $user->email, $user->address, $user->postal_number, $user->tel, $user->administrator));
        }
        return $users;
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

    public static function insert($username, $password, $name, $lastname, $email, $address, $postal_number, $tel, $administrator)
    {
        $db = Db::getInstance();
        $username = mysqli_real_escape_string($db, $username);
        $password = mysqli_real_escape_string($db, $password);
        $name = mysqli_real_escape_string($db, $name);
        $lastname = mysqli_real_escape_string($db, $lastname);
        $email = mysqli_real_escape_string($db, $email);
        $address = mysqli_real_escape_string($db, $address);
        $postal_number = mysqli_real_escape_string($db, $postal_number);
        $tel = mysqli_real_escape_string($db, $tel);
        $administrator = mysqli_real_escape_string($db, $administrator);
        $user_id = $_SESSION["USER_ID"]; // user_id vzamemo iz seje (prijavljen uporabnik)

        $query = "INSERT INTO users (username, password, name, lastname, email,address, postal_number, tel, administrator) 
                  VALUES('$username', '$password', '$name', '$lastname', '$email', '$address', '$postal_number', '$tel', '$administrator');";
        if ($db->query($query)) {
            $id = mysqli_insert_id($db); // preberemo id, ki ga je dobil vstavljen oglas
            return User::find($id); // preberemo nov oglas iz baze in ga vrnemo controllerju
        } else {
            return null; // v primeru napake vrnemo null
        }
    }

    // Metoda, ki posodobi obstoječ oglas v bazi
    public function update($username, $name, $lastname, $email, $address, $postal_number, $tel, $administrator)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $this->id);
        $username = mysqli_real_escape_string($db, $username);
        $name = mysqli_real_escape_string($db, $name);
        $lastname = mysqli_real_escape_string($db, $lastname);
        $email = mysqli_real_escape_string($db, $email);
        $address = mysqli_real_escape_string($db, $address);
        $postal_number = mysqli_real_escape_string($db, $postal_number);
        $tel = mysqli_real_escape_string($db, $tel);
        $administrator = mysqli_real_escape_string($db, $administrator);

        $query = "UPDATE users SET username = '$username', name = '$name', lastname = '$lastname', 
                  email = '$email', address = '$address', postal_number = '$postal_number', tel = '$tel', administrator = '$administrator'
                  WHERE id = '$id'";

        if ($db->query($query)) {
            return User::find($id); //iz baze pridobimo posodobljen oglas in ga vrnemo controllerju
        } else {
            return null;
        }
    }

    // Metoda, ki izbriše oglas iz baze
    public function delete()
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $this->id);
        $query = "DELETE FROM users WHERE id = '$id'";
        if ($db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

}
