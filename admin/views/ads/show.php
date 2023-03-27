<div class="container my-5">
        <div class="col-md-6 offset-md-3">
            <h4>Ime in priimek: <?php echo $user->name . " " . $user->lastname; ?></h4>
            <p>Email: <?php echo $user->email; ?></p>
            <p>Naslov: <?php echo $user->address . ", " . $user->postal_number; ?></p>
            <p>Uporabniško ime: <?php echo $user->username; ?></p>
            <a href="index.php" class="btn btn-primary">Nazaj</a>
        </div>
</div>

<style>

</style>