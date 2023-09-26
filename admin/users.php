<?php
include('../helper/utils.php');
include('../helper/sql.php');

html_open();
head('Benutzerverwaltung');
navbar();
$pdo = newConnection();

if(isset($_GET['add'])){
    if(sendSQL($pdo, "INSERT INTO `staff` (`id`, `name`, `surname`, `birth`, `hidden`) VALUES (NULL, '".$_POST['name']."', '".$_POST['surname']."', '".$_POST['birth']."', '0');")){
        echo '
            <br />
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <h4 class="alert-heading">Benutzer hinzugefügt</h4>
              <p class="mb-0">Der Benutzer wurde erfolreich hinzugefügt.</p>
            </div>
            ';
    } else {
        echo '
            <br />
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <h4 class="alert-heading">Benutzer konnte nicht hinzugefügt werden!</h4>
              <p class="mb-0">Die Aktion ist fehlgeschlagen! E201</p>
            </div>
            ';
    }
}
?>
    <div class="container" style="margin-top: 50px;">
        <h1>Qualifikationsüberblick</h1>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="table-light">
                    <th scope="col">id</th>
                    <th scope="col">Nachname</th>
                    <th scope="col">Vorname</th>
                    <th scope="col">Geburtsdatum</th>
                    <th scope="col">Aktion</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach(getDataTable($pdo, 'SELECT * FROM `staff` ORDER BY name,surname') as $data){ ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['surname']; ?></td>
                        <td><?php echo date_format(date_create($data['birth']), 'd.m.Y'); ?></td>
                        <td><a href="staff.php?id=<?php echo $data['id']; ?>">Ansehen</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <br /><br />
        <h1>Personal hinzufügen</h1>
        <form action="?add=1" , method="post">
            <div class="form-group">
                <label class="form-label mt-4">Vorname</label>
                <input type="text" class="form-control" name="surname" placeholder="Vorname" required>
                <label class="form-label mt-4">Nachname</label>
                <input type="text" class="form-control" name="name" placeholder="Nachname" required>
                <label class="form-label mt-4">Geburtsdatum</label>
                <input type="date" class="form-control" name="birth" required>
                <br />
                <button type="submit" class="btn btn-primary">Hinzufügen</button>
            </div>
        </form>
    </div>

<?php html_close(); ?>