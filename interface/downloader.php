<?php // block any attempt to the filesystem
if (isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) {
$filename = $_GET['file'];
    include 'connect.php';
    include 'includes/functions/function.php';
    echo '<link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/font/css/all.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">';
} else {
$filename = NULL;
    redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','','default');
}
?>
<?php
if (!$filename) {
// if variable $filename is NULL or false display the message
echo $err;
} else {
$fileData = selectData('*','upload','name="'.$filename.'"');
if($fileData == false)
    redirectHome('هذا الملف غير موجود','','default');
$path = $fileData['path'].$filename;
// check that file exists and is readable
if (file_exists($path) && is_readable($path)) {
// get the file size and send the http headers
$size = filesize($path);
header('Content-Type: application/octet-stream');
header('Content-Length: '.$size);
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
// open the file in binary read-only mode
// display the error messages if the file can´t be opened
$file = @ fopen($path, 'rb');
if ($file) {
// stream the file and exit the script when complete
fpassthru($file);
exit;
} else {
    redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','','default');
}
} else {
    redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','','default');
}
}
?>