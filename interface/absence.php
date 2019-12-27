<?php
session_start();
include 'connect.php';
include 'includes/functions/function.php';
if(!(isset($_SESSION['Username1']) && isset($_SESSION['GroupID1']) && $_SESSION['GroupID1'] == 3 && $_SERVER['REQUEST_METHOD'] && $_POST['studentid'])){
    header('Location: parent.php');
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
    <link rel="stylesheet" href="layout/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/img/logo.png">
</head>
<body>
<header class="std_header">
    <!-- Start Navbar -->
    <?php include 'includes/templates/navbar.php';?>
      <div class="ground">
        <div class="overlay">
          <img src="layout/img/books-1281581_1920.jpg">
       </div>
     </div>
        <section class="child_nav">
            <div class="sub-menu">
                <ul>
                    <li><a href="#absence" class="pro-act nav-link active " id="absences">الغياب</a></li>
                    <li><a href="#degree" id="degrees">الدرجات </a></li>
                    
                </ul>
            </div>
       </section>
</header>
<!-------------start absence------------------------->
    <!-----start days------------->
<section class="absence_days">
    <div class="title text-center">
        <h3>الايام</h3> 
    </div>
    <div class="container">
        
            <?php
            $academic = selectData('*','academic_year','1 order by aid desc limit 1');
            if ($academic != false){
                $absence = selectData('*','absence,absence_day','aadid=adid and adacademicYear='.$academic['aid'].' and abstudentId='.$_POST['studentid'],1);
                if($absence != false){
                ?>
        <div class="row">    
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th>رقم</th>
                    <th>اليوم</th>
                    <th>التاريخ</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $c = 1;
                    foreach($absence as $a){
                        echo '<tr>';
                            echo '<td>'.$c.'</td>';
                            echo '<td>'.$a['day'].'</td>';
                            echo '<td>'.day(date('D', strtotime($a['day'])),0).'</td>';
                        echo '</tr>';
                        $c++;
                    }
                    ?>
                </tbody>
           </table>
            </div>
            <?php
                }else
                    echo '<h4 class="text-center alert alert-info">لا يوجد غياب مسجل الان</h4>';
            }else
                echo '<h4 class="text-center alert alert-warning">لا يوجد بيانات مسجلة الان</h4>';
            ?>
           
      
  </div>

    
</section>    

    
       <!-----end days--------->
    <!------- end absence --------------->
   <!--------start degree --------------->
<section class="degree" id="degree">
    <div class="title text-center">
        <h3>الدرجات</h3> 
    </div>
    <div class="container">
        <?php
        if($academic != false){
            $degree = selectData('*','degreetype,degree,course','dtacademicYear='.$academic['aid'].' and dstudentId='.$_POST['studentid'].' and dtype=dtid and dtcourseId=cid order by cid');
            if($degree != false){
        ?>
        <div class="row">    
           <table class="table table-hover">
                <thead>
                  <tr>
                    <th>رقم</th>
                    <th>الماده </th>
                    <th>رقم الاختبار</th>
                    <th>الاختبار </th>
                    <th>الدرجة</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $c = 1;
                    $check = false;
                    $p = 0;
                    foreach($degree as $d){
                        echo '<tr>';
                        if($check == false) $v = 1;
                        else $v++;
                            echo '<td>'.$c.'</td>';
                            echo '<td>'.$d['cname'].'</td>';
                            echo '<td>'.$v.'</td>';
                            echo '<td>'.$d['dtname'].'</td>';
                            echo '<td>'.$d['degree'].'</td>';
                        echo '</tr>';
                        if($p == $d['cid']) $check = true;
                        else $check = false;
                        $p = $d['cid'];
                        $c++;
                    }
                    ?>
                </tbody>
           </table>
      </div>
        <?php
            }else
                echo '<h4 class="text-center alert alert-info">لا يوجد درجات مسجلة الي الان</h4>';
        }else
            echo '<h4 class="text-center alert alert-warning">لا يوجد بيانات مسجلة الان</h4>';
        ?>
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






<script src="layout/js/jquery-3.3.1.min.js"></script>
<script src="layout/js/popper.min.js"></script>
<script src="layout/js/bootstrap.min.js"></script>
<script src="layout/js/index.js"></script>
<script src="layout/js/main.js"></script>    
</body>
</html>