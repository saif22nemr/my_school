



<?php
session_start();
$noNavbar ='';
include 'init.php';
if(isset($_SESSION['Username1'])){
   header('Location: index.php'); 
    exit();
}
   
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $pass = sha1($_POST['password']);
    $stmt = $con->prepare("select * from user where username=? and password=?");
    $stmt->execute(array($username,$pass));
    $row = $stmt->fetch();
    $rowCount = $stmt->rowCount();
    if($rowCount>0){
        $_SESSION['Username'] = $username;
        $_SESSION['GroupID'] = $row['groupid'];
        $_SESSION['id'] = $row['id'];
        header('Location: index.php');
        exit();
    }else{
        header('Location: index.php');
        exit();
    }
}
?>
<section class="register text-center">
    <div class="container">
        <form class="login" action="login.php" method="POST">
            <h1 class="text-center">تسجيل الدخول</h1>
            <input type="text" name="username" required placeholder="اسم المستخدم">
            <input type="password" name="password" required placeholder="كلمة المرور">
            <input type="submit" class="btn btn-primary" value="تسجيل الدخول">
        </form>
    </div>
</section>    
<?php
include $tpl.'footer.php';
?>