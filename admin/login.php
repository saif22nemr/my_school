<?php
session_start();
$noNavbar ='';
include 'init.php';
//print_r($_SESSION);
unset($_SESSION['rowCount']);
if(isset($_SESSION['Username'])){
   header('Location: index.php'); 
    exit();
}
   
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $pass = sha1($_POST['password']);
    if(is_numeric($username))
        $stmt = $con->prepare('select * from user where groupid=2 and id='.$username.' and password="'.$pass.'"');
    else
        $stmt = $con->prepare('select * from user where groupid=2 and username="'.$username.'" and password="'.$pass.'"');
    $stmt->execute();
    $row = $stmt->fetch();
    $rowCount = $stmt->rowCount();

    if($rowCount>0){
        $_SESSION['rowCount'] = 'count: '.$rowCount;
        
        $v = explode(' ',$row['name']);
        $_SESSION['Username'] = $v[0];
        $_SESSION['GroupID'] = $row['groupid'];
        $_SESSION['id'] = $row['id'];
        
        header('Location: index.php');
        exit();
    }else{
        $_SESSION['else'] = 'none';
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liber</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="layout/css/index.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/img/logo.png">
</head>
<body>
    <section class="regster text-center ">
      <div class="overlay">  
        <div class="col-sm-12">
            <div class="box row">
              <div class="head">
                 <h2>قم بادخال بيانتك </h2>
                  <hr>
                </div>
                <div class="form ff">
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                       <div class="form-group text">
                        <input  type="text" class="input form-control input-lg" name="username" placeholder="الاسم">

                        </div>
                       <div class="form-group text">
                        <input class="input form-control input-lg " type="password" name="password" placeholder="الرقم السري">
                       </div>
                        <div class="remmber text-center">
                         هل نسيت الرقم السري ؟
                       </div>
                        <div class="form-group text">
                        <input type="submit" class="btn btn-primary btn-3" value="تسجيل دخول"> 
                       </div>
                    </form>
                </div>
             </div>
          </div>
        </div>
    </section>
    
    
    <script src="layout/js/jquery-3.3.1.min.js"></script>
    <script src="layout/js/popper.min.js"></script>
    <script src="layout/js/bootstrap.min.js"></script>
    <script src="layout/js/main.js"></script>
</body>
</html>    




