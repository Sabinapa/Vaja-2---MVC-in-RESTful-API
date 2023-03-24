<h2>Spremeni oglas oglas</h2>
<form action="?controller=users&action=update" method="POST" enctype="multipart/form-data">
    <!-- ID od oglasa, ki ga želimo urediti, pošljemo v POST s pomočjo avtomatsko izpolnjenega skritega vnosnega polja <input type='hidden'>
    <input type="hidden" name="id" value="  //php echo $ad->id; ?>" />-->
    <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $user->id;?>">
        <label>Uporabniško ime *</label>
        <input type="text" class="form-control" value="<?php echo $user->username; ?>" name="username" required>
    </div>
    <div class="form-group">
        <label>Ime *</label>
        <input type="text" class="form-control" value="<?php echo $user->name; ?>" name="name" required>
    </div>
    <div class="form-group">
        <label>Priimek *</label>
        <input type="text" class="form-control" value="<?php echo $user->lastname; ?>" name="lastname" required>
    </div>
    <div class="form-group">
        <label>E-mail *</label>
        <input type="text" class="form-control" value="<?php echo $user->email; ?>" name="email" required>
    </div>
    <div class="form-group">
        <label>Naslov</label>
        <input type="text" class="form-control" value="<?php echo $user->address; ?>" name="address">
    </div>
    <div class="form-group">
        <label>Pošta</label>
        <input type="number"  value="0" class="form-control" value="<?php echo $user->postal_number; ?>" name="postal_number">
    </div>
    <div class="form-group">
        <label>Telefon</label>
        <input type="text" class="form-control" value="<?php echo $user->tel; ?>" name="tel">
    </div>
    <div class="form-group">
        <label>Administrator</label>
        <input type="text" class="form-control" value="<?php echo $user->administrator; ?>" name="administrator">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Shrani">
    <br>
</form>