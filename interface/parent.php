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
    <title>Login</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/font/css/all.min.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/imgs/logo.png">
</head>
<body>
<header class="parent_header">
    <!-- Start Upper-bar -->
    <?php 
    include 'includes/templates/navbar.php';
    ?>
      
</header>
<?php
    $child = selectData('*','parent','parentId='.$_SESSION['UserId1'],1);
    if($child == false){
        header('Location: logout.php');
        exit();
    }
    foreach($child as $c){
        $student = selectData('name,id,regdate','user','id='.$c['studentId']);
        ?>
        <section class="child center-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="right">
                            <div class="img">
                                <img src="layout/imgs/profile.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="left text-center">
                         <div class="contant">
                            <p>
                                <span><?php echo $student['name'];?></span>
                                <br>
                                <?php printClass(date('Y')-$student['regdate']+1);?>
                             </p>
                         </div>
                          <div class="show">
                            <form action="absence.php"  method="post">
                                <input type="hidden" name="studentid" value="<?php echo $c['studentId'];?>">
                                <button class="btn" type="submit" name="showStudent">عرض</button>
                            </form>
                          </div>
                        </div>              
                  </div>
                </div>
            </div>

        </section> 
    <?php
    }
    ?>

    
    
    <!--- end child section ---->     
    
    
    

    <!------- end absence --------------->
    
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
    
    








<script src="layout/js/jquery-3.3.1.min.js"></script>
<script src="layout/js/popper.min.js"></script>
<script src="layout/js/bootstrap.min.js"></script>
<script src="layout/js/main.js"></script>    
</body>
</html>