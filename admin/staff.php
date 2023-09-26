<?php
include('../helper/utils.php');
include('../helper/sql.php');
html_open();
head('Startseite');
navbar();

$pdo = newConnection();
$staff = getData($pdo, 'SELECT * FROM `staff` WHERE `id` = '.$_GET['id']);
?>

    <section style="background-color: #1f5b83;">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Überblick</a></li>
                            <li class="breadcrumb-item"><a href="#">Personal</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $staff['surname'].' '.$staff['name']; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?php echo $staff['surname'].' '.$staff['name']; ?></h5>
                            <p class="text-muted mb-1"></p>
                            <p class="text-muted mb-4">XXX</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Voller Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $staff['surname'].' '.$staff['name']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Benutzername</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $staff['surname'].'.'.$staff['name']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Geburtsdatum</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $staff['birth']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">ID</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $staff['id']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Ortsgruppe</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">DLRG OG Anrath-Willich e.V.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Fachbereich</th>
                                    <th scope="col">Erwerb</th>
                                    <th scope="col">Gültigkeit</th>
                                    <th scope="col">Aktion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach (getDataTable($pdo, 'SELECT * FROM `certificates` JOIN `atn_allowed` ON certificates.atn_id=atn_allowed.id WHERE `staff_id`='.$_GET['id'].' ORDER BY section,sort,name,expiration;') as $object){
                                    $date1 = date_create($object['recieved']);
                                    $date2 = date_create($object['expiration']);
                                    echo '
                                    <tr>
                                        <td>'.$object['name'].'</td>
                                        <td>'.$object['section'].'</td>
                                        <td>'.date_format($date1, 'd.m.Y').'</td>
                                        <td>'.date_format($date2, 'd.m.Y').'</td>
                                        <td><a href="../certs/'.$object['path'].'">Öffnen</a></td>
                                    </tr>
                                    ';
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php html_close(); ?>