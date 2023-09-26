<?php

if($_SERVER['REQUEST_METHOD'] !== "POST"){
    exit("POST request method required");
}

include('helper/sql.php');
include('helper/utils.php');


$pdo = newConnection();

$surname = explode(' ', $_POST['staff'])[0];
$name = explode(' ', $_POST['staff'])[1];
$type = $_POST['type'];
$created = $_POST['created'];
$expiration = $_POST['expiration'];

if(isset($_POST['customnamef']) && $_POST['customnamef'] != ""){
    if($type == "sonstige externe Ausbildung (HiOrg)"){
        sendSQL($pdo, "INSERT INTO `atn_allowed` (`id`, `name`, `dlrgid`, `section`, `sort`) VALUES (NULL, '".$_POST['customnamef']."', '', 'z externe Ausbildung', '2001');");
    } else {
        sendSQL($pdo, "INSERT INTO `atn_allowed` (`id`, `name`, `dlrgid`, `section`, `sort`) VALUES (NULL, '".$_POST['customnamef']."', '', 'sonstige', '1001');");
    }
    $type = $_POST['customnamef'];
}


$upload_path = __DIR__.'/certs/'.$name.'_'.$surname.'_'.str_replace(' ', '_', $type).'_'.basename($_FILES['file']['tmp_name'].'.pdf');

if(file_exists($upload_path)){
    die('ERROR: Probiere es nochmal. (E100)');
}



if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)){

    $staffid = getData($pdo, "SELECT id FROM `staff` WHERE `name` LIKE '".$name."' AND `surname` LIKE '".$surname."'")['id'];
    $atnid = getData($pdo, "SELECT id FROM `atn_allowed` WHERE `name` LIKE '".$type."'")['id'];
    $filna = $name."_".$surname."_".str_replace(' ', '_', $type)."_".basename($_FILES['file']['tmp_name'].".pdf");

    if(sendSQL($pdo, "INSERT INTO `certificates` (`id`, `staff_id`, `atn_id`, `recieved`, `expiration`, `path`) VALUES (NULL, '".$staffid."', '".$atnid."', '".$created."', '".$expiration."', '".$name."_".$surname."_".str_replace(' ', '_', $type)."_".basename($_FILES['file']['tmp_name'].".pdf')"))){
        
        // It is mandatory to set the content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers. From is required, rest other headers are optional
        $headers .= 'From: <atn@dlrg-anrath.de>' . "\r\n";

        mail("atn@dlrg-anrath.de","Neuer ATN Eintrag! von ".$name.", ".$surname, $name.", ".$surname." hat die ATN ".$type." hochgeladen! (http://atn.dlrg-anrath.de/certs/".$filna.")",$headers);
        
        echo '<meta http-equiv="refresh" content="0; URL=index.php">';
    } else {
        echo 'E102';
    }
} else {
    echo 'E101 ';
}

?>
