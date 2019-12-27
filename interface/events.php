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
    <title>Events</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/font/css/all.css">
    <link rel="stylesheet" href="layout/css/hover-min.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/imgs/logo.png">
</head>
<body>
    <header>
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php';?>
        <!------ end nav -------------->
        <div class="header_contant text-center">
        <div class="container">
            <h3>الفعاليات </h3>
            
        </div>
    </div>
</header>
<!---------- End heaer ---------->
    
<!---------- Start Content page ---------->
    
<main>
    <div class="row">
        <!-- Satrt Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <h2>الاحداث السابقة</h2>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span>2018<i class="fas fa-arrow-alt-circle-down"></i></span>
                        <div class="months">
                            <a href="event_reg.php">يناير</a>
                            <a href="#">فبراير</a>
                            <a href="#">مارس</a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <span>2017<i class="fas fa-arrow-alt-circle-down"></i></span>
                        <div class="months">
                            <a href="#">يناير</a>
                            <a href="#">فبراير</a>
                            <a href="#">مارس</a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <span>2016<i class="fas fa-arrow-alt-circle-down"></i></span>
                        <div class="months">
                            <a href="#">يناير</a>
                            <a href="#">فبراير</a>
                            <a href="#">مارس</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Sidebar -->
        <!-- Satrt Events -->
        <div class="col-md-9">
            <div class="event_parts">
                <h2>الفعاليات الحالية</h2>
                <div class="parts">
                    <div class="part">
                        <div class="row">
                            <div class="col-md-3 date">7/5/2018</div>
                            <div class="col-md-6">
                            <div class="desc">
                                <h3>رحله الي مكتبه الاسكندرية</h3>
                                <p>تعلن المدرسه عن ذهاب الرحله الي مكتبه ...</p>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#"data-toggle="modal" data-target="#modalRegisterForm">تسجيل</a>
                            </div>
                        </div>
                    </div>
                    <div class="part">
                        <div class="row">
                            <div class="col-md-3 date">7/5/2018</div>
                            <div class="col-md-6">
                            <div class="desc">
                                <h3>رحله الي مكتبه الاسكندرية</h3>
                                <p>تعلن المدرسه عن ذهاب الرحله الي مكتبه ...</p>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#"data-toggle="modal" data-target="#modalRegisterForm">تسجيل</a>
                            </div>
                        </div>
                    </div>
                    <div class="part">
                        <div class="row">
                            <div class="col-md-3 date">7/5/2018</div>
                            <div class="col-md-6">
                            <div class="desc">
                                <h3>رحله الي مكتبه الاسكندرية</h3>
                                <p>تعلن المدرسه عن ذهاب الرحله الي مكتبه ...</p>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#"data-toggle="modal" data-target="#modalRegisterForm">تسجيل</a>
                            </div>
                        </div>
                    </div>
                    <div class="part">
                        <div class="row">
                            <div class="col-md-3 date">7/5/2018</div>
                            <div class="col-md-6">
                            <div class="desc">
                                <h3>رحله الي مكتبه الاسكندرية</h3>
                                <p>تعلن المدرسه عن ذهاب الرحله الي مكتبه ...</p>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#"data-toggle="modal" data-target="#modalRegisterForm">تسجيل</a>
                            </div>
                        </div>
                    </div>
                    <div class="part">
                        <div class="row">
                            <div class="col-md-3 date">7/5/2018</div>
                            <div class="col-md-6">
                            <div class="desc">
                                <h3>رحله الي مكتبه الاسكندرية</h3>
                                <p>تعلن المدرسه عن ذهاب الرحله الي مكتبه ...</p>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#"data-toggle="modal" data-target="#modalRegisterForm">تسجيل</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Events -->
    </div>
</main>
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">تسجيل </h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body mx-3">
                <div class="md-form mb-5">
                  <i class="fas fa-user prefix grey-text"></i>
                  <input type="text" id="orangeForm-name" class="form-control validate" placeholder="الاسم">
                </div>
                <div class="md-form mb-5">
                  <i class="fas fa-envelope prefix grey-text"></i>
                  <input type="email" id="orangeForm-email" class="form-control validate" placeholder="الايميل">
                </div>

                <div class="md-form mb-4">
                  <i class="fas fa-lock prefix grey-text"></i>
                  <input type="password" id="orangeForm-pass" class="form-control validate" placeholder="الرقم السري">
                </div>

              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-deep-orange">تسجيل</button>
              </div>
            </div>
  </div>
</div>    
<!---------- End Content page ---------->
    
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