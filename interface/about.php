<?php
session_start();
    include 'connect.php';
    include 'includes/functions/function.php';

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
    
<header>
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php'?>
    <!-- End Navbar -->
    <!-- Start Content -->
    <div class="content-about text-center">
        <div class="container">
            <h1>من نحن</h1>
        </div>
    </div>
    <!-- End Content -->
</header>
    
<!-- End section header -->
    
<!-- Start Info about -->
    
<section class="about-info">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    <h2>من نحن !</h2>
                    <h6>ملخص بسيط عنا وعن ما تقدمه مدرستنا</h6>
                    <p>تميز بأننا المقدم  الأول والأوحد للتعليم العالي الكندي في مصر منذ عام 2004 وذلك من خلال شراكتنا مع جامعة كيب بريتون. وتمتاز فروعنا في القاهرة الجديدة والشيخ زايد بأنهما المقر الرئيسي للطلاب المتطلعين إلى الحصول على شهادة  تخرج دولية إلى جانب الشهادة المصرية.
                    نمنحك شهادة بكالوريوس مزدوجة في مجال دراستك. شهادة البكالوريوس المصرية و هي شهادة معتمدة من وزارة التعليم العالي والمجلس الأعلى للجامعات. وشهادة أخرى كندية معتمدة من جامعة كيب بريتون و هذه الشهادة معترف بها دوليا.</p>
                </div>
                <div class="col-md-6">
                    <div class="img-container">
                        <img src="layout/imgs/img-about.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
<!-- End Info about -->
    
<!-- Start Section Goals --> 
    
<!--<section class="about-goals">
    <div class="container">
        <div class="content">
            <h2>هدفنا</h2>
            <ul>
                <li>ترسيخ وترويج مفهوم التعلم مدى الحياة. </li>
                <li>تحصين الطالب حضاريا وثقافيا وتنمية روح الثقة بالنفس والمجتمع والحضارة المنتمي إليها. </li>
                <li> تأمين أعلى مستويات التعليم للطلاب في أماكن أقامتهم بوساطة الشبكة العالمية للانترنت. </li>
                <li>تقديم مناهج إلكترونية متنوعة في مستويات التعليم المختلفة.</li>
            </ul>
        </div>
        <div class="content">
            <h2>مساعينا</h2>
            <ul>
                <li>تقدم خدمات متميزه للطلاب في مختلف المجالات العلمية والتربويه والثقافيه</li>
                <li>إعداد طلاب المدرسه ليكونوا صالحين وفاعلين في المجتمع</li>
                <li> تعزيز القدرات العلمية للطلاب وخاصه المجالات اللغويه والتكنولوجيه</li>
                <li>تنميه مواهب الطلبه وتشجيعهم علي الابتكار والإبداع من خلال الأنشطة اللا منهجية وممارسه التعلم الذاتي</li>
                <li>التعاون بين إدارة المدرسه وأولياء الأمور لتطوير العمليه والتعليمه</li>
            </ul>
        </div>
        <div class="content">
            <h2>رؤيتنا</h2>
            <ul>
                <li>تتطلع المدرسة الي تنشئة جيل مبدع وواع فكريا ومتميز أخلاقيا وعلميا ومؤمن بقضايا المجتمع ومتفاعل معه.</li>
                <li> تخريج طالب قادر على التفاعل مع متطلبات العصر من خلال بيئة تربوية فعالة من المجتمع و للمجتمع</li>
                <li>إتاحة تعليم متميز فى ضوء الجودة الشاملة وفى ظل مشاركة مجتمعية</li>
            </ul>
        </div>

    
    
        <hr>
    </div>
</section>--->
<section class="about_details">
 <div class="container-fluid">    
  <div class="row">
   <div class="col-md-4 col-sm-12">      
    <div class="goals">
     <div class="titel center text-center">
        <div class="icon">
           <i class="fas fa-user-graduate fa-stack"></i>
          </div>
         <h3>هدفنا </h3>
      </div>
        <div class="body">
          <ul>
                <li>ترسيخ وترويج مفهوم التعلم مدى الحياة. </li>
                <li>تحصين الطالب حضاريا وثقافيا وتنمية روح الثقة بالنفس والمجتمع والحضارة المنتمي إليها. </li>
                <li> تأمين أعلى مستويات التعليم للطلاب في أماكن أقامتهم بوساطة الشبكة العالمية للانترنت. </li>
                <li>تقديم مناهج إلكترونية متنوعة في مستويات التعليم المختلفة.</li>
            </ul>
         </div>
      </div>
      </div>
      <div class="col-md-4 col-sm-12 ">      
    <div class="goals">
     <div class="titel">
        <div class="icon">
           <i class="fas fa-comment-alt fa-stack"></i>
          </div>
         <h3>رسالتنا  </h3>
      </div>
        <div class="body">
          <ul>
                <li>ترسيخ وترويج مفهوم التعلم مدى الحياة. </li>
                <li>تحصين الطالب حضاريا وثقافيا وتنمية روح الثقة بالنفس والمجتمع والحضارة المنتمي إليها. </li>
                <li> تأمين أعلى مستويات التعليم للطلاب في أماكن أقامتهم بوساطة الشبكة العالمية للانترنت. </li>
                <li>تقديم مناهج إلكترونية متنوعة في مستويات التعليم المختلفة.</li>
            </ul>
         </div>
      </div>
      </div>
      <div class="col-md-4 col-sm-12">      
    <div class="goals">
     <div class="titel">
        <div class="icon">
           <i class="far fa-eye fa-stack"></i>
          </div>
         <h3>رؤيتنا </h3>
      </div>
        <div class="body">
          <ul>
                <li>ترسيخ وترويج مفهوم التعلم مدى الحياة. </li>
                <li>تحصين الطالب حضاريا وثقافيا وتنمية روح الثقة بالنفس والمجتمع والحضارة المنتمي إليها. </li>
                <li> تأمين أعلى مستويات التعليم للطلاب في أماكن أقامتهم بوساطة الشبكة العالمية للانترنت. </li>
                <li>تقديم مناهج إلكترونية متنوعة في مستويات التعليم المختلفة.</li>
            </ul>
         </div>
      </div>
      </div>
    </div>
    </div>
    </section>
    
<!-- End Section Goals --> 
    
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

    
<script src="layout/js/jquery-3.3.1.min.js"></script>
<script src="layout/js/popper.min.js"></script>
<script src="layout/js/bootstrap.min.js"></script>
<script src="layout/js/main.js"></script>

</body>
</html>