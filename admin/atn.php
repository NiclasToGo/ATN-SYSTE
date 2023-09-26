<?php
include('../helper/utils.php');
include('../helper/sql.php');

html_open();
head('Benutzerverwaltung');
navbar();
$pdo = newConnection();

if(isset($_GET['add'])){
    if(sendSQL($pdo, "INSERT INTO `atn_allowed` (`id`, `name`, `dlrgid`, `section`, `sort`) VALUES (NULL, '".$_POST['name']."', '".$_POST['dlrgid']."', '".$_POST['section']."', '".$_POST['sort']."');")){
        echo '
            <br />
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <h4 class="alert-heading">ATN hinzugefügt</h4>
              <p class="mb-0">Die ATN wurde erfolreich hinzugefügt.</p>
            </div>
            ';
    } else {
        echo '
            <br />
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <h4 class="alert-heading">ATN konnte nicht hinzugefügt werden!</h4>
              <p class="mb-0">Die Aktion ist fehlgeschlagen! E201</p>
            </div>
            ';
    }
}
?>
    <div class="container" style="margin-top: 50px;">
        <h1>Ausbildungen</h1>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="table-light">
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Modul</th>
                    <th scope="col">Fachbereich</th>
                    <th scope="col">Sortierung</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach(getDataTable($pdo, 'SELECT * FROM `atn_allowed` ORDER BY section,sort') as $data){ ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['dlrgid']; ?></td>
                        <td><?php echo $data['section']; ?></td>
                        <td><?php echo $data['sort']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <br /><br />
        <h1>Ausbildung hinzufügen</h1>
        <form action="?add=1" , method="post">
            <div class="form-group">
                <label class="form-label mt-4">Name</label>
                <input type="text" class="form-control" name="name" required>
                <label class="form-label mt-4">Modulid</label>
                <input type="text" class="form-control" name="dlrgid">
                <label class="form-label mt-4">Fachbereich</label>
                <select class="form-select" name="section" required>
                    <option disabled selected value> -- Fachbereich auswählen --</option>
                    <option>Wasserrettung</option>
                    <option>Medizin</option>
                    <option>KatS</option>
                    <option>Schwimmabzeichen</option>
                    <option>Fahrerlaubnis</option>
                    <option>IUK</option>
                    <option>sonstige</option>
                </select>
                <label class="form-label mt-4">Sortierung</label>
                <input type="number" class="form-control" name="sort" value="0" required>
                <br />
                <button type="submit" class="btn btn-primary">Hinzufügen</button>
            </div>
        </form>
    </div>

<?php html_close(); ?>