<?php

function html_open() {
    echo '<html lang="de">';
}

function html_close() {
    echo '<script src="https://atn.niclaswrld.cloud/js/bootstrap.js"></script></html>';
}

function head($title){
    echo '
    <head>
        <title>'.$title.' - OG Anrath</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="ATN-System der DLRG OG Anrath-Willich" />
        <meta name="keywords" content="dlrg, atn, og, anrath" />
        <meta name="author" content="Niclas Reinecke"/>
        <meta charset="utf-8">

        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,300,600,400italic,700" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="http://atn.dlrg-anrath.de/css/bootstrap.css">
        <script src="https://kit.fontawesome.com/f6cf2c3d86.js" crossorigin="anonymous"></script>
    </head>
    ';
}

function navbar(){
    echo '
    <header>
        <nav class="navbar navbar-expand-lg bg-light" data-bs-theme="light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">ATN System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor03">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Startseite
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="overview.php">Überblick</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../upload">Hochladen</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administration</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="atn.php">ATN Übersicht</a>
                                <a class="dropdown-item" href="users.php">Personal</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Do not press</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    ';
}

function generateFileName()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 14; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

function getSectionColor($section){
    switch ($section){
        case 'Wasserrettung':
            return 'danger';
            break;
        case 'Medizin':
            return 'info';
            break;
        case 'Schwimmabzeichen':
            return 'secondary';
            break;
        case 'KatS':
            return 'warning';
            break;
        case 'Fahrerlaubnis':
            return 'dark';
            break;
        case 'IUK':
            return 'primary';
            break;
        default:
            return 'light';
            break;
    }
}

?>