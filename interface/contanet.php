<?php
session_start();
if(!(isset($_SESSION['Username']) && isset($_SESSION['GroupID']))){
    
}else{
    $name = $_SESSION['Username'];
    $groupid = $_SESSION['GroupID'];
    $id = $_SESSION['UserId'];
    include 'connect.php';
    include 'includes/functions/function.php';
    
}
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBER</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/normaliz.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link rel="icon" href="layout/imgs/logo.png">
    <link rel="stylesheet" href="layout/font/css/all.min.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
</head>
<body>
    <!-- Start section header -->
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact'])){
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        $stmt = $con->prepare('insert into contact (coname,cocity,cocountry,coacademicYear,cophone,comessage,codate) values (?,?,?,?,?,?,?)');
        $stmt->execute(array($_POST['name'],$_POST['city'],$_POST['country'],$academic[0],$_POST['phone'],$_POST['message'],date('Y-m-d')));
        if($stmt->rowCount() == 0)
            redirectHome('لم يتم ارسال ارسالة .. يرجي المحاولة مرة اخري','','default');
        else{
            $msg = '<div class="text-center">تم ارسال الرسالة بنجاح</div>';
            redirectHome($msg,'index.php','');
        }
    }
    ?>
<header>
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php'?>
    </header>
    <!-- End Navbar -->
    <!-----start contact info ----->
<section class="contact_info">
    <div class="contact_head">
          <h1> اتصل بنا  </h1>
           <p>يسعدنا انضمامك لمدرسه ليبر . هذه المعلومات لسهوله التواصل معنا .</p>
         </div>
    <div class="container">
       <div class="row">
         <div class="col-sm-4">
          <div class="adderss text-center">    
            <h3>العنوان</h3>
             <p>
                 3 شارع صفية زغلول من شارع القصر العيني القاهرة .

                 12 شارع الفلكي من شارع المبتديان القصر العيني القاهرة .
              </p>
            </div>
           </div>
           <div class="col-sm-4">
          <div class="adderss text-center">    
            <h3>التليفون </h3>
             <p>
              رقم التليفون : 27946145
               <br>
                رقم الفاكس : 27953102 
                 <br>
                 رقم الموبايل : 0102769389
              </p>
            </div>
           </div>
           <div class="col-sm-4">
          <div class="adderss text-center">    
            <h3>الموقع</h3>
              <p>
              جوجل : www.liber@gmail.com
               <br>
                فيسبوك : www.facebook/iber.com  
                 <br>
                 تويتر  :  www.liber.com
              </p>
            </div>
           </div>
        </div>
      </div>
    
    </section>    
    <!-------end contact_info ------------->
    <!-------start contact_map------>
    <section class="contact_map">
      <div class="row contact-map">
            <!-- IFRAME: GET YOUR LOCATION FROM GOOGLE MAP -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13660.430211186318!2d33.779705250000006!3d31.134527699999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14fc2b55e44738eb%3A0x23fff7d24dd8eb55!2z2YXYr9ix2LPZhyDYudin2YrYtCDYp9mE2KfYs9mF2LEg2KjYrdmKINin2YTYs9mF2LHYp9mG!5e0!3m2!1sar!2seg!4v1554932045295!5m2!1sar!2seg" allowfullscreen></iframe>
            <div class="container">
                <div class="overlay-contact footer-part part-form">
                    <div class="map-head">
                        <p>اتصل بنا الان </p>
                        <h2>التسجيل هنا </h2> 
                    </div>
                    <!-- ENQUIRY FORM -->
                    <form id="contact_form" name="contact_form" action="contanet.php" method="post">
                        <ul>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="text" id="f1" value="" name="name" placeholder="Name" required> </li>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="text" id="f2" value="" name="phone" placeholder="Phone" required> </li>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="text" id="f3" value="" name="city" placeholder="City" required> </li>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="text" id="f4" value="" name="country" placeholder="Country" required> </li>
                            <li class="col-md-12 col-sm-12 col-xs-12 contact-input-spac">
                                <textarea id="f5" name="message" required=""></textarea>
                            </li>
                            <li class="col-md-6">
                                <input type="submit" name="contact" value="تسجيل"> </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
 </section>
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
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>