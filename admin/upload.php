<?php
include('../helper/utils.php');
include('../helper/sql.php');
html_open();
head('Einreichen');

navbar();


$pdo = newConnection();
?>
    <div class="container" style="margin-top: 50px; padding-bottom: 10px; padding-top: 10px;">

        <?php
        if(isset($_GET['success'])){
            echo '
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <h4 class="alert-heading">Urkunde eingereicht!</h4>
              <p class="mb-0">Du hast die Urkunde erfolgreich eingereicht.</p>
            </div>
            ';
        }
        ?>


        <h1>Einreichen von Urkunden</h1>
        <form action="../upload_dwarf.php" , method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label mt-4">Personal auswählen</label>
                <select class="form-select" id="staff" name="staff" required>
                    <option disabled selected value> -- Personal auswählen --</option>
                    <?php
                    foreach (getDataTable($pdo, 'SELECT * FROM `staff` ORDER BY `name`,surname;') as $staff){
                        echo '<option>'.$staff['surname'].' '. $staff['name'].'</option>';
                    }
                    ?>
                </select>

                <label class="form-label mt-4">Urkunde auswählen</label>
                <select class="form-select" id="type" name="type" required>
                    <option disabled selected value> -- Urkunde auswählen --</option>
                    <?php
                    foreach (getDataTable($pdo, 'SELECT * FROM `atn_allowed` ORDER BY `section`,`sort`;') as $cert){
                        echo '<option>'.$cert['name'].'</option>';
                    }
                    ?>
                </select>

                <label for="formFile" class="form-label mt-4">Ausstellungsdatum</label>
                <input type="date" class="form-control" id="created" name="created" required>

                <label for="formFile" class="form-label mt-4">Gültigkeit</label>
                <input type="date" class="form-control" id="expiration" name="expiration" required>
                <small class="form-text text-muted">Falls deine Urkunde nicht abläuft, gebe bitte den <b>01.01.2100</b> an!</small>
                 <br />
                <label for="formFile" class="form-label mt-4">Urkunde hochladen (pdf!)</label>
                <input class="form-control" type="file" id="file" name="file" accept="application/pdf" required>

                <br />
                <button type="submit" class="btn btn-primary">Einreichen</button>
            </div>
        </form>
    </div>

<?php html_close(); ?>