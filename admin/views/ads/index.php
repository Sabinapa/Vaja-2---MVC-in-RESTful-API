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
                    <a href='?controller=users&action=delete&id=<?php echo $user->id; ?>' class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Izbriši
                    </a>
                </td>
            </tr>
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