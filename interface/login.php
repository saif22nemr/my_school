<?php
include 'connect.php';
session_start();
include 'includes/functions/function.php';
#print_r($_SESSION);
  
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $username = $_POST['Username'];
  $pass = sha1($_POST['Password']);
    if(is_numeric($username))
        $stmt = $con->prepare('select * from user where id='.$username.' and password="'.$pass.'"');
    else
        $stmt = $con->prepare('select * from user where username="'.$username.'" and password="'.$pass.'"');
  $stmt->execute();
  $row = $stmt->fetch();
  $count = $stmt->rowCount();
  /*
        - Take care about group id : 
            - 1 is student
            - 2 is teacher 
            - 3 is parent
  */
  if($count > 0){
    $name = explode(' ',$row['name']);
    $_SESSION['Username1'] = $name[0];
    $_SESSION['GroupID1'] = $row['groupid'];
    $_SESSION['UserId1'] = $row['id'];
    if($row['groupid'] == 1)
        header('Location: student.php');
      else if($row['groupid'] == 2)
          header('Location: teacher.php');
      else if($row['groupid'] == 3)
          header('Location: parent.php');
      else
          header('Location: index.php');
    exit();
  }else{
    # This User Not inside this database
      $_SESSION['check'] = false;
      header('Location: login.php');
      exit();
  }
}
if(isset($_SESSION['Username1'])){
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/fontawesome/css/all.css">
    <link rel="stylesheet" href="layout/css/login.css">
<!--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">-->
<!--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<!--
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
-->
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/imgs/logo.png">
</head>
<body>
    <section class="regster text-center ">
      <div class="overlay">  
        <div class="col-sm-12">
        <div class="box row">
          <div class="head">
             <h2>تسجيل الدخول</h2>
              <hr>
            </div>
            <div class="hidden-info text-center">
                <?php
                    if(isset($_SESSION['check']) && $_SESSION['check'] == false){
                        echo '<div class="wrong"> هناك خطاء في اسم المستخدم او كلمة المرور</div>';
                    }else
                        echo '<div class="normal">قم بادخال بيانتك</div>';
                ?>
            </div>
          <div class="right">
            <form class="form" action="login.php" method="POST">
               <div class="form-group text">
                <input  type="text" name="Username" class="input form-control input-lg" placeholder="اسم المستخدم ..">
                   
                </div>
               <div class="form-group text">
                <input class="input form-control input-lg" name="Password" type="password" placeholder="كلمة المرور ..">
               </div>
              
<!--
               <div class="">
                   <div class="remmber">
                       <a href="login.php">هل نسيت الرقم السري ؟</a>
                   </div>
                    <div class="check-box">
                      <input type="checkbox" class="custom-control-input" id="defaultChecked2"  checked>
                      <label class="custom-control-label check" for="defaultChecked2"> تذكرني </label>
                    </div>
                </div>
-->             
                <div class="forget">
                    <div class="remmber">
                        <a href="login.php">هل نسيت كلمة المرور؟</a>
                    </div>
                    <div class="form-check">
                        <label for="blankCheckbox">تذكرني</label>
                        <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="..." checked>
                    </div>
                </div>
                  <input type="submit" class="btn btn-primary btn-3" value="تسجيل دخول"> 
              </form>
            </div>
              
        </div>
          </div>
        
    
        </div>
    </section>  
<script src="layout/js/jquery-3.3.1.min.js"></script>
<script src="layout/js/popper.min.js"></script>
<script src="layout/js/bootstrap.min.js"></script>
<script src="layout/js/login.js"></script>    
</body>
</html>
