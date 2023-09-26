<?php
include('../helper/utils.php');
include('../helper/sql.php');

html_open();
head('Overview');
navbar();

$pdo = newConnection();

?>
    <div class="container-fluid" style="margin-top: 50px;">
        <h1>Qualifikationsüberblick</h1>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="table-light">
                    <th scope="col">Personal</th>

                    <?php
                        foreach (getDataTable($pdo, 'SELECT * FROM `atn_allowed` WHERE NOT `section`="sonstige" AND NOT `section`="z externe Ausbildung" ORDER BY `section`,`sort`;') as $data) {
                            echo '<th class="table-' . getSectionColor($data['section']) . '" scope="col">'.$data['name'].' ('.$data['dlrgid'].')</th>';
                        }
                    ?>



                </tr>
                </thead>
                <tbody>
                <?php
                    $counter = array_fill(0,100, 0);
                    $current = 0;
                    foreach (getDataTable($pdo, 'SELECT * FROM `staff` ORDER BY `name`') as $data) {
                        echo '<tr>';
                        $now = new DateTime();
                        $birth = date_create($data['birth']);
                        $alter = $birth->diff($now)->format('%y');
                        echo '<td><a href="staff.php?id=' . $data['id'] . '">' . $data['name'] . ', ' . $data['surname'] . ' (' . $alter . ')</a></td>';
                            foreach (getDataTable($pdo, 'SELECT * FROM `atn_allowed` WHERE NOT `section`="sonstige" AND NOT `section`="z externe Ausbildung" ORDER BY `section`,`sort`;') as $certcol){
                                $cert = getData($pdo, 'SELECT * FROM `certificates` WHERE `staff_id` = ' . $data['id'] . ' AND `atn_id` = ' . $certcol['id'] . ' ORDER BY `expiration` DESC LIMIT 1;');
                                if($cert){
                                    $now = new DateTime();
                                    $exp = date_create($cert['expiration']);
                                    $lifetime = date_create( '2099-01-01');

                                    if($exp > $now){
                                        if($exp >= $lifetime){
                                            echo '<td class="table-success">vorhanden</td>';
                                        } else {
                                            echo '<td class="table-success">vorhanden (' . date_format($exp, 'd.m.Y') . ')</td>';
                                        }
                                        $counter[$current]++;
                                    } else {
                                        echo '<td class="table-danger">abgelaufen</td>';
                                    }
                                } else {
                                    echo '<td>-</td>';
                                }
                                $current++;
                            }
                        echo '<tr>';
                } ?>
                </tbody>
            </table>
        </div>
    </div>

<?php html_close(); ?>