<?php
session_start();
if((isset($_SESSION['Username']) && isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 2)){
    
}else{
    $name = $_SESSION['Username'];
    $groupid = $_SESSION['GroupID'];
    $id = $_SESSION['UserId'];
    
}
include 'connect.php';
    include 'includes/functions/function.php';
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adress</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/all.css">
    <link rel="stylesheet" href="layout/css/animate.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link rel="icon" href="layout/imgs/logo.png">
    <link rel="stylesheet" href="layout/font/css/all.min.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
</head>
<body>
    
<!-- Start section header -->
    
<header>
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php';?>
    <!-- End Navbar -->
</header>
    
<!-- End section header -->
<!---start section contant---->
<section class="contant_address">
    <div class="heading">
       <h1> الاعلانات </h1>
     </div>
   <div class="container">
     <div class="row">
       <div class="col-sm-4">
          <div class="address animated bounceInRight">
             <div class="title">
               <h3>رحله القاهرة </h3> 
              </div>
              <hr class="style17">
              <div class="details">
                   <p>تعلن المدرسه عن قيام رحله الي مدينه القاهرة وذلك لزياره الامكان السياحيه وذلك يوم الاحد الموافق <span>12/12/2012</span> من يرغب بالاشتراك يتقدم الي مكتب المشرف العام </p>
                 </div>
           </div>
         </div>
         <div class="col-sm-4">
          <div class="address animated bounceInDown ">
             <div class="title">
               <h3>رحله القاهرة </h3> 
              </div>
              <hr class="style17">
              <div class="details">
                   <p>تعلن المدرسه عن قيام رحله الي مدينه القاهرة وذلك لزياره الامكان السياحيه وذلك يوم الاحد الموافق <span>12/12/2012</span> من يرغب بالاشتراك يتقدم الي مكتب المشرف العام </p>
                 </div>
           </div>
         </div>
         <div class="col-sm-4">
          <div class="address animated bounceInLeft">
             <div class="title">
               <h3>رحله القاهرة </h3> 
              </div>
              <hr class="style17">
              <div class="details">
                   <p>تعلن المدرسه عن قيام رحله الي مدينه القاهرة وذلك لزياره الامكان السياحيه وذلك يوم الاحد الموافق <span>12/12/2012</span> من يرغب بالاشتراك يتقدم الي مكتب المشرف العام </p>
                 </div>
           </div>
         </div>
         <div class="col-sm-4">
          <div class="address animated bounceInRight">
             <div class="title">
               <h3>رحله القاهرة </h3> 
              </div>
              <hr class="style17">
              <div class="details">
                   <p>تعلن المدرسه عن قيام رحله الي مدينه القاهرة وذلك لزياره الامكان السياحيه وذلك يوم الاحد الموافق <span>12/12/2012</span> من يرغب بالاشتراك يتقدم الي مكتب المشرف العام </p>
                 </div>
           </div>
         </div>
         <div class="col-sm-4">
          <div class="address animated bounceInUp">
             <div class="title">
               <h3>رحله القاهرة </h3> 
              </div>
              <hr class="style17">
              <div class="details">
                   <p>تعلن المدرسه عن قيام رحله الي مدينه القاهرة وذلك لزياره الامكان السياحيه وذلك يوم الاحد الموافق <span>12/12/2012</span> من يرغب بالاشتراك يتقدم الي مكتب المشرف العام </p>
                 </div>
           </div>
         </div>
         <div class="col-sm-4">
          <div class="address animated bounceInLeft">
             <div class="title">
               <h3>رحله القاهرة </h3> 
              </div>
              <hr class="style17">
              <div class="details">
                   <p>تعلن المدرسه عن قيام رحله الي مدينه القاهرة وذلك لزياره الامكان السياحيه وذلك يوم الاحد الموافق <span>12/12/2012</span> من يرغب بالاشتراك يتقدم الي مكتب المشرف العام </p>
                 </div>
           </div>
         </div>
       </div>
    
    </div> 
    
    </section>
    

    
<!-- Start Footer -->
    
<footer>
    <div class="row">
        <div class="col-md-4">
            <ul class="text-center list-unstyled links">
                <li><a href="#">عنا</a></li>
                <li><a href="#">الفعاليات</a></li>
                <li><a href="#">الملاحظات</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h4 class="text-center">تابعنا</h4>
            <ul class="text-center list-unstyled social-media">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
        <div class="col-md-4 text-center join">
            <p>اشترك لتصلك اخر الاخبار</p>
            <form>
                <input class="form-control" type="email" placeholder="ادخل بريدك الالكتروني">
                <input type="submit" class="btn btn-success" value="اشترك">
            </form>
        </div>
    </div>
    <hr>
    <div class="copy-right text-center">
        جميع الحقوق &copy; محفوظة لموقع ليبر
    </div>
</footer>

<!-- End Footer -->

    
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>