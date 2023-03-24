<h3>Seznam vseh uporabnikov</h3>
<a href="?controller=users&action=create">
    <button>Dodaj</button>
</a>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Name</th>
        <th>Lastname</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    <!-- tukaj se sprehodimo čez array uporabnikov in izpisujemo vrstico posameznega uporabnika-->
    <?php foreach ($users as $user) { ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->username; ?></td>
            <td><?php echo $user->name; ?></td>
            <td><?php echo $user->lastname; ?></td>
            <td><?php echo $user->email; ?></td>
            <td>
                <!-- pri vsakem oglasu dodamo povezavo na akcije show, edit in delete, z idjem oglasa. Uporabnik lahko tako proži novo akcijo s pritiskom na gumb.-->
                <a href='?controller=users&action=show&id=<?php echo $user->id; ?>'>
                    <button>Prikaži</button>
                </a>
                <a href='?controller=users&action=edit&id=<?php echo $user->id; ?>'>
                    <button>Uredi</button>
                </a>
                <a href='?controller=users&action=delete&id=<?php echo $user->id; ?>'>
                    <button>Izbriši</button>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>