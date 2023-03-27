<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Objavi oglas</h2>
            <form action="?controller=users&action=store" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Uporabniško ime *</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label>Ime *</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label>Priimek *</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="form-group">
                    <label>E-mail *</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Naslov</label>
                    <input type="text" class="form-control" name="address">
                </div>
                <div class="form-group">
                    <label>Pošta</label>
                    <input type="number" value="0" class="form-control" name="postal_number">
                </div>
                <div class="form-group">
                    <label>Telefon</label>
                    <input type="text" class="form-control" name="tel">
                </div>
                <div class="form-group">
                    <label>Administrator</label>
                    <input type="text" class="form-control" name="administrator">
                </div>
                <div class="form-group">
                    <label>Geslo *</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label>Ponovi geslo *</label>
                    <input type="password" class="form-control" name="repeat_password" required>
                </div>
                <input type="submit" class="btn btn-primary" name="submit" value="Pošlji">
                <br>
            </form>
        </div>
    </div>
</div>