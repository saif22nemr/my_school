<?php
if (isset($_GET['name'])) {
    $id = $_GET['name'];

    // fetch file to download from database
    $sql = "SELECT * FROM upload WHERE name=?";
    $stmt = $con->prepare($sql);
    $stmt->execute(array($id));
    $file = $stmt->fetch();
    $filepath = 'upload/' . $file['name'];
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['name']));
        readfile('uploads/' . $file['name']);        
        exit();
    }
?>