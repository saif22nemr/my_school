<?php
session_start();
if(isset($_SESSION['Username1']) && isset($_SESSION['GroupID1'])){
    $name = $_SESSION['Username1'];
    $groupid = $_SESSION['GroupID1'];
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
    
<header>
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php';?>
    <!-- End Navbar -->
    <!-- Start Content -->
    <div class="content text-center">
        <div class="container">
            <h3>انضم الى مدرسة ليبر واحصل على افضل تعليم مدرسي في الشرق الاوسط</h3>
            <a href="contanet.php">انضم الينا</a>
            <?php if(!isset($name)) echo '<a href="login.php">تسجيل الدخول  </a>';?>
        </div>
    </div>
    <!-- End Content -->
</header>
    
<!-- End section header -->
    
<!-- Start team -->
<section class="team" id="team">
  <div class="container">
    <div class="row">
      <div class="heading text-center">
         <h2>فريق العمل </h2>
          <p>يتميز فريق عمل مدرسه ليبر بالكفاءة العاليه والمستوي العلمي والاخلاقي العالي .ايضا يتميز بالعمل بروح الفريق وذلك من اجل النهوض بالتعليم والمركز الثقافي للمدرسه . </p>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-2 member">
          <div class="img_teacher">
            <img class="img-responsive" src="layout/imgs/Teacher%20(1).jpg">
            </div>
          <div class="teacher_details">
            <div class="arrow-bottom"></div>
              <h3>ا/سليمان خليل </h3>
              <p>مدير المدرسه
              <br>
                كليه اداب قسم دراسات اجتماعيه جامعه الزقازيق
              </p> 
          </div>    
         </div>
        <!------->
        <div class="col-sm-4 col-md-4 col-lg-2 member">
          <div class="teacher_details">
            <div class="arrow-top"></div>
              <h3>ا/سليمان خليل </h3>
              <p>مدير المدرسه
              <br>
                كليه اداب قسم دراسات اجتماعيه جامعه الزقازيق
              </p> 
          </div> 
            <div class="img_teacher">
            <img class="img-responsive" src="layout/imgs/Teacher%20(2).jpg">
            </div>
         </div>
        <!------->
        <div class="col-sm-4 col-md-4 col-lg-2 member">
          <div class="img_teacher">
            <img class="img-responsive" src="layout/imgs/Teacher%20(1).jpg">
            </div>
          <div class="teacher_details">
            <div class="arrow-bottom"></div>
              <h3>ا/سليمان خليل </h3>
              <p>مدير المدرسه
              <br>
                كليه اداب قسم دراسات اجتماعيه جامعه الزقازيق
              </p> 
          </div>    
         </div>
        <!------->
        <div class="col-sm-4 col-md-4 col-lg-2 member">
          <div class="teacher_details">
            <div class="arrow-top"></div>
              <h3>ا/سليمان خليل </h3>
              <p>مدير المدرسه
              <br>
                كليه اداب قسم دراسات اجتماعيه جامعه الزقازيق
              </p> 
          </div> 
            <div class="img_teacher">
            <img class="img-responsive" src="layout/imgs/Teacher%20(2).jpg">
            </div>
         </div>
        <!------->
        <div class="col-sm-4 col-md-4 col-lg-2 member">
          <div class="img_teacher">
            <img class="img-responsive" src="layout/imgs/Teacher%20(1).jpg">
            </div>
          <div class="teacher_details">
            <div class="arrow-bottom"></div>
              <h3>ا/سليمان خليل </h3>
              <p>مدير المدرسه
              <br>
                كليه اداب قسم دراسات اجتماعيه جامعه الزقازيق
              </p> 
          </div>    
         </div>
        <!------->
        <div class="col-sm-4 col-md-4 col-lg-2 member">
          <div class="teacher_details">
            <div class="arrow-top"></div>
              <h3>ا/سليمان خليل </h3>
              <p>مدير المدرسه
              <br>
                كليه اداب قسم دراسات اجتماعيه جامعه الزقازيق
              </p> 
          </div> 
            <div class="img_teacher">
            <img class="img-responsive" src="layout/imgs/Teacher%20(2).jpg">
            </div>
         </div>
      </div>
    </div>
    
    
    </section>
    
<!-- End team -->
    

<!-- Start Events -->    

<section class="events text-center" id="events">
   <div class="heading">
       <h2>الفعاليات </h2>
        <p>تقوم المدرسه بالكثير من الفعاليات ولذلك من منطلق التخفيف عن الطلاب من حمل الدراسه </p>
    </div>
    <div class="container">
      <div class="row">
       <div class="col-sm-4">     
        <div class="gallery">
         <div class="head">
            <h3><span>معرض</span> الصور</h3>
             <hr>
            </div>    
         <div class="line1">
          <div class="row">     
          <div class="col-sm-4">
            <div class="img">
              <img src="layout/imgs/8.jpg">
              </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/11.jpg">
                </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/5.jpg">
                </div>
            </div>
          </div>
            </div>
             <div class="line1">
          <div class="row">     
          <div class="col-sm-4">
            <div class="img">
              <img src="layout/imgs/2.jpg">
              </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/1.jpg">
                </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/4.jpg">
                </div>
            </div>
          </div>
            </div>
             <div class="line1">
          <div class="row">     
          <div class="col-sm-4">
            <div class="img">
              <img src="layout/imgs/6.jpg">
              </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/3.jpg">
                </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/5.jpg">
                </div>
            </div>
          </div>
            </div>
             <div class="line1">
          <div class="row">     
          <div class="col-sm-4">
            <div class="img">
              <img src="layout/imgs/7.jpg">
              </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/11.jpg">
                </div>
            </div>
            <div class="col-sm-4">
             <div class="img">
                <img src="layout/imgs/10.jpg">
                </div>
            </div>
          </div>
            </div>
           </div>
         </div>
          <!----- end gallery---->
        <div class="col-sm-4">   
          <div class="video">
              <div class="head">
            <h3><span>معرض </span>الفديوهات </h3>
             <hr>
            </div> 
            <video class="video-fluid z-depth-1"  loop controls muted>
               <source src="layout/imgs/%D9%81%D8%B9%D8%A7%D9%84%D9%8A%D8%A9%20%D9%85%D8%AF%D8%B1%D8%B3%D8%A9%20%D8%B1%D9%81%D8%AD%20%D8%A7%D9%84%D8%A7%D8%A8%D8%AA%D8%AF%D8%A7%D8%A6%D9%8A%D8%A9.mp4" type="video/mp4" />
              </video>
              <div class="prag">
               <p>تعد الرحلات المدرسية أسلوباً ذكياً من الأساليب التشويقية التي ينتهجها بعض الأساتذة وتعتبر ذات طابعٍ ممتعٍ ومنعشٍ للطلاب، وتأخذهم ولو بشكلٍ مؤقتٍ من جانب الدراسة الجدي بواجباته وامتحاناته ومواعيده إلى أجواء أكثر فرحاً وإشراقاً، فالرتابة والروتين هما من أكثر ما يكره الطلاب بخصوص المدرسة   
                  </p>
              </div>
            </div>
          </div> 
          <!-----end video---->
          <div class="col-sm-4">
            <div class="time">
              <div class="head">
                <h3><span>جدول </span>المواعيد</h3>
                  <hr>
                </div>
                <div class="one">
                  <div class="date">
                    07
                      <br>
                      JAN,2019
                    </div>
                    <div class="desc">
                       <h5> رحله الي مكتبه الاسكندريه.....</h5>
                       <p> تعلن المدرسه عن ذهاب الرحله الي مكتبه....</p>
                        <p>5:30am-5:30pm</p>    
                    </div>
                    </div>
                <hr>
                  <div class="one">
                  <div class="date">
                    07
                      <br>
                      JAN,2019
                    </div>
                    <div class="desc">
                       <h5> رحله الي مكتبه الاسكندريه.....</h5>
                       <p> تعلن المدرسه عن ذهاب الرحله الي مكتبه....</p>
                        <p>5:30am-5:30pm</p>    
                    </div>
                    </div>
                <hr>
                  <div class="one">
                  <div class="date">
                    07
                      <br>
                      JAN,2019
                    </div>
                    <div class="desc">
                       <h5> رحله الي مكتبه الاسكندريه.....</h5>
                       <p> تعلن المدرسه عن ذهاب الرحله الي مكتبه....</p>
                        <p>5:30am-5:30pm</p>    
                    </div>
                    </div>
              </div>
          </div>
       </div> 
      </div>
</section>

<!-- Start Events -->        
    
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