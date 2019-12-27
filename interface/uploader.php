<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['uploaderOn'])){
    include 'connect.php';
    include 'includes/functions/function.php';
    echo '<link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/font/css/all.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">';
    $val = explode('.',$_FILES['data']['name']);
    $ext = $val[count($val)-1];
    //[type] = 1 => درسي
    //[type] = 2 => امتحان
    //[type] = 3 => محاضرة
    //[type] = 4 => اخري
    if(isset($_POST['url']))
        $url = $_POST['url'];
    else
        $url = 'index.php';
    if(isset($_POST['path'])) $path = $_POST['path'];
    else $path = '';
    if(isset($_POST['type'])) $type = $_POST['type'];
    else $type = 0;
    $allowedFileTypes  =  array("exe",  "mp4", "mkv" ,  "mp3");
    if  (in_array($_FILES['data']['type'],  $allowedFileTypes)) {
        redirectHome('لا يمكن رفع هذا الملف',$url,'default');
    } //  check  if  this  is  a  valid  upload
    if  (!is_uploaded_file($_FILES['data']['tmp_name']))
        redirectHome('لا يمكن رفع هذا الملف',$url,'default');
    $uploadDir  =  "upload/".$path.'/'; //  copy  the  uploaded  file  to  the  directory
    do{
        $v1 = rand();
        $v2 = rand();
        $v3 = rand();
        $fileName = $v1.$v2.$v3.'.'.$ext;
        $check = selectData('name','upload','name="'.$fileName.'"');
    }while($check != false);
    if(move_uploaded_file($_FILES['data']['tmp_name'],$uploadDir.$fileName)){
        $stmt = $con->prepare('insert into upload (title,name,path,extension,type,ucourseId,uacademicYear,date) values (?,?,?,?,?,?,?,?)');
        $stmt->execute(array($_POST['name'],$fileName,$uploadDir,$ext,$type,$_POST['cid'],$_POST['aid'],date('Y-m-d')));
        if($stmt->rowCount() == 0)
            redirectHome('يرجي المحاولة مرة اخري',$url,'default');
        else{
            $msg = '<div class="text-center">تم رفع الملف بنجاح</div>';
            redirectHome($msg,$url,'');
        }
    }else
       redirectHome('لا يمكن رفع هذا الملف',$url,'default');

}else{
    header('Location: index.php');
}

?>

