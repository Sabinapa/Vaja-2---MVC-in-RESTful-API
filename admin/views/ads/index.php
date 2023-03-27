<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div id="Users">
    <h3>Seznam vseh uporabnikov</h3>
    <a href="?controller=users&action=create" class="btn btn-primary mb-2" id="ButtomAdd">Dodaj</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Akcije</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->lastname; ?></td>
                <td><?php echo $user->email; ?></td>
                <td>
                    <a href='?controller=users&action=show&id=<?php echo $user->id; ?>' class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Prikaži
                    </a>
                    <a href='?controller=users&action=edit&id=<?php echo $user->id; ?>' class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Uredi
                    </a>
                    <button class="btn btn-primary" data-toggle="modal" data-target='#<?php echo $user->id ?>'>Izbriši</button>
                   <!-- <a href='?controller=users&action=delete&id=<?//php echo $user->id; ?>' class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Izbriši
                    </a>-->
                </td>
            </tr>

            <div class="modal fade" id='<?php echo $user->id ?>' role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Potrditev brisanja uporabnika</h5>
                        </div>
                        <div class="modal-body">
                            Ali ste prepričani, da želite izbrisati uporabnika?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Prekliči</button>
                            <a href='?controller=users&action=delete&id=<?php echo $user->id; ?>'><button type="button" class="btn btn-default">Izbriši</button></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </tbody>
    </table>
</div>



<style>
    #Users {
        padding-left: 20px;
    }

    #ButtomAdd
    {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>