<?php
session_start();
if(!(isset($_SESSION['Username']) && isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 1)){
    header('Location: index.php');
}else{
    $name = $_SESSION['Username'];
    $groupid = $_SESSION['GroupID'];
    $id = $_SESSION['UserId'];
    include 'connect.php';
    include 'includes/functions/function.php';
    $self = selectData('*','user','id='.$id);
}
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liber</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/all.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link rel="stylesheet" href="layout/font/css/all.min.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/imgs/logo.png">
</head>
<body>
  <header class="std_header">
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php'?>
      <div class="ground">
    <div class="overlay">
    <img src="layout/imgs/books-1281581_1920.jpg">
 </div>
</div> 
    <!-------- strat std_nav -------->
 <section class="std_nav">
  <div class="pro-menu" id="pro-menu">
        <ul>
            <li><a href="#home" class="pro-act" id="timetable">الرئيسيه</a></li>
            <li><a href="#degree" id="degreeTable">الدرجات</a></li>
            <li><a href="#absence" id="absenceTable">الغياب</a></li>
            <li><a href="#lectur" id="lectur">المحاضرات </a></li>
            <li><a href="#homework" id="homework">الواجب المنزلي  </a></li>
            
        </ul>
      </div>
    
    </section>
</header>
    <!-----end std_nav------>
    <!------start std_pro ------->
<section class="std_pro">
    <div class="stu-db">
      <div class="container pg-inn">
       <div class="row">      
       <div class="col-md-3">
        <div class="pro-user">
         <img src="layout/imgs/profile.jpg" alt="user">
        </div>
         <div class="pro-user-bio">
          <ul>
            <li class="std_id"><span>الاسم : </span><span><?php echo $name;?></span></li><br>
            <li class="std_id "><span>رقم الهوية : </span><span><?php echo $id;?></span></li><br>
            <li class="std_id "><span>الصف : </span><span><?php printClass(date('Y')-$self['regdate']+1);?></span></li>
          </ul>
        </div>
         </div>
                 
      <!---- end profil --->
<div class="col-md-9">
     <!----start timetable ----->
   <div class="desc_sec week_calender">
        <h4>الجدول الاسبوعي </h4>
    <div class="timeline" id="timetable">
      <div class="container">
        <div class="parts">
            <!-- Part 1 -->
            <?php
                $academic = selectData('*','academic_year','1 order by aid desc limit 1');
                if($academic != false){
                    $teacherDay = selectData('DISTINCT sday','schedule_name,reg_course,schedule','courseId=scourseId and ssnid=snid and sntype="دراسي" and academicYear='.$academic['aid'].' and studentId='.$id,1);
                    if($teacherDay != false){
                        foreach($teacherDay as $day){
                            ?>
                            <div class="part">
                                <div class="row">
                                    <div class="col-md-1">
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <!-- Date -->
                                    <div class="col-md-2">
                                        <p><?php echo day('',$day[0]);?></p>
                                    </div>
                                    <!-- Courses -->
                                    <div class="col-md-9">
                                        <!-- Course 1 -->
                                        <?php
                                        $courseDate = selectData('cname,clevel,stime,cid','reg_course,course,schedule_name,schedule','ssnid=snid and scourseId=cid and scourseId=courseId and studentId='.$id.' and snacademicYear='.$academic['aid'].' and sday='.$day[0],1);
                                        foreach($courseDate as $c){
                                            $teacher = selectData('name','reg_teacher,user','id=rtteacherId and rtcourseId='.$c['cid'].' and rtacademicYear='.$academic['aid']);
                                            if ($teacher != false)
                                                $teacher = explode(' ',$teacher['name']);
                                            echo '
                                                <div class="course row">
                                                    <div class="col-md-3">
                                                        <p>'.$c['stime'].'</p>

                                                    </div>
                                                    <div class="col-md-6 course-name">
                                                        <p>'.$c['cname'].'</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="lecturer">';
                                                            echo $teacher[0].' '.$teacher[1];
                                                        echo '</p>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>    
                <hr>
                            <?php
                        }
                    }
                    else{
                        echo '<h4 class="text-center alert alert-warning">لا توجد جداول متاح الان1</h4>';
                    }
                }else{
                    echo '<h4 class="text-center alert alert-warning">لا توجد جداول متاح الان</h4>';
                }
                ?>
            </div>
    </div>
</div>         
              
              
              </div>
              
    <!------end time table ------->
    
   <div class="desc_sec lecture_div">
        <div class="lectur" id="lectur">
            <h2 class="text-center">محاضرات المواد </h2>
            <?php
               $course1 = selectData('*','course,reg_course','courseId=cid and studentId='.$id,1);
                if($course1 != false){
                    ?>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <?php
                                $d= 1;
                                foreach($course1 as $c){
                                    if ($d==1) $active = 'active';
                                    else $active = '';
                                    $d++;
                                    echo '<a class="nav-item nav-link '.$active.'" id="nav-subject-'.$c['cid'].'" data-toggle="tab" href="#subject-'.$c['cid'].'" role="tab" aria-controls="subject-'.$c['cid'].'" aria-selected="true">'.$c['cname'].'</a>';
                                }
                                ?>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <!-- Start Subject 1 -->
                            <?php
                            $d = 1;
                            foreach($course1 as $c){
                                $count = 1;
                                if ($d==1) $active = 'active';
                                else $active = '';
                                $d++;
                                $downloadFile = selectData('*','upload','type=3 and ucourseId='.$c['cid'],1);
                                ?>
                            <div class="tab-pane fade show <?php echo $active;?>" id="subject-<?php echo $c['cid'];?>" role="tabpanel" aria-labelledby="nav-subject-<?php echo $c['cid'];?>">
                                <?php
                                if($downloadFile != false){
                                    ?>
                                <table class="table text-center">
                                    <thead  class="thead-dark">
                                        <tr>
                                            <th scope="col">الرقم </th>
                                            <th scope="col">الاسم</th>
                                            <th scope="col">نوع الملف</th>
                                            <th scope="col">التاريخ</th>
                                            <th scope="col">تحميل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($downloadFile as $df){
                                            echo '<tr>
                                                <th scope="row">'.$count.'</th>
                                                <td>'.$df['title'].'</td>
                                                <td>'.$df['extension'].'</td>
                                                <td>'.$df['date'].'</td>';
                                                echo '<td><a href="downloader.php?file='.$df['name'].'" class="btn btn-success">تحميل <i class="fas fa-chevron-down"></i></a></td>
                                            </tr>';
                                            $count++;
                                            if($count > count($downloadFile)) echo '<hr>';
                                        }
                                        
                                            ?>
                                    </tbody>
                                </table>
                                <?php
                                }else
                                    echo '<h4 class="text-center alert alert-info">لا يوجد ملفات لهذه المادة</h4>';
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                            </div>
                    <?php
                }else
                    echo '<h4 class="text-center alert alert-warning">لا يوجد مواد الي هذا الطالب</h4>';
            ?>
            
        </div>
    </div>

              <!---------end section lecture--------->
<!-- Start section Assignment -->

<div class="desc_sec home_work_div">
        <div class="assignment" id="assignment">
            <h2 class="text-center">الواجب المنزلي</h2>
            <?php
               $course1 = selectData('*','course,reg_course','courseId=cid and studentId='.$id,1);
                if($course1 != false){
                    ?>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <?php
                                $d= 1;
                                foreach($course1 as $c){
                                    if ($d==1) $active = 'active';
                                    else $active = '';
                                    $d++;
                                    $v = $c['cid']+$d;
                                    echo '<a class="nav-item nav-link '.$active.'" id="nav-subject-'.$v.'" data-toggle="tab" href="#subject-'.$v.'" role="tab" aria-controls="subject-'.$v.'" aria-selected="true">'.$c['cname'].'</a>';
                                }
                                ?>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <!-- Start Subject 1 -->
                            <?php
                            $d = 1;
                            foreach($course1 as $c){
                                $count = 1;
                                if ($d==1) $active = 'active';
                                else $active = '';
                                $d++;
                                $downloadFile = selectData('*','upload','type=1 and ucourseId='.$c['cid'],1);
                                $dd = $c['cid']+$d;
                                ?>
                            <div class="tab-pane fade show <?php echo $active;?>" id="subject-<?php echo $dd;?>" role="tabpanel" aria-labelledby="nav-subject-<?php echo $dd;?>">
                                <?php
                                if($downloadFile != false){
                                    ?>
                                <table class="table text-center">
                                    <thead  class="thead-dark">
                                        <tr>
                                            <th scope="col">الرقم </th>
                                            <th scope="col">الاسم</th>
                                            <th scope="col">نوع الملف</th>
                                            <th scope="col">التاريخ</th>
                                            <th scope="col">تحميل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($downloadFile as $df){
                                            echo '<tr>
                                                <th scope="row">'.$count.'</th>
                                                <td>'.$df['title'].'</td>
                                                <td>'.$df['extension'].'</td>
                                                <td>'.$df['date'].'</td>';
                                                echo '<td><a href="downloader.php?file='.$df['name'].'" class="btn btn-success">تحميل <i class="fas fa-chevron-down"></i></a></td>
                                            </tr>';
                                            $count++;
                                            if($count > count($downloadFile)) echo '<hr>';
                                        }
                                        
                                            ?>
                                    </tbody>
                                </table>
                                <?php
                                }else
                                    echo '<h4 class="text-center alert alert-info">لا يوجد ملفات لهذه المادة</h4>';
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                            </div>
                    <?php
                }else
                    echo '<h4 class="text-center alert alert-warning">لا يوجد مواد الي هذا الطالب</h4>';
            ?>
            
        </div>
    </div>

<div class="desc_sec degree_table">
     <h1 class="text-center">الدرجات</h1>   
    <div class="body sub23">
        <?php
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if($academic != false){
            $level = date('Y')-$self['regdate']+1;
            $degree = selectData('dtid,cid,cname,dtname,dtmaxDegree,dtexamDate','degreetype,course','dtcourseId=cid and clevel='.$level.' and dtacademicYear='.$academic['aid'].' order by cid',1);
            if($degree != false){
                $c = 1;
                echo '<table class="table">';
                    echo '<thead class="color">';
                            echo '<th>رقم</th>';
                            echo '<th>المادة</th>';
                            echo '<th>الاسم</th>';
                            echo '<th>العدد</th>';
                            echo '<th>التاريخ</th>';
                            echo '<th>الدرجة</th>';
                            echo '<th>الدرجة القصوي</th>';
                    echo '</thead>';
                    echo '<tbody>';
                        $pre = 0;
                        foreach($degree as $d){
                            echo '<tr ';
                            if($c%2 == 0) echo 'class="even"';
                            echo '>';
                            $checkAbsence = selectData('*','absence,absence_day','aadid=adid and day='.$d['dtexamDate'].' and abstudentId='.$id);
                            $deg = selectData('degree','degree','dtype='.$d['dtid'].' and dstudentId='.$id);
                            if ($pre == $d['cid'])
                                $f++;
                            else
                                $f = 1;
                                echo '<td>'.$c.'</td>';
                                echo '<td>'.$d['cname'].'</td>';
                                echo '<td>'.$d['dtname'].'</td>';
                                echo '<td>'.$f.'</td>';
                                echo '<td>'.$d['dtexamDate'].'</td>';
                                echo '<td>';
                                if ($deg != false) echo $deg['degree'] ;
                                else if($checkAbsence == false && $deg != false) echo $deg['degree'];
                                else echo 'غ';
                                echo '</td>';
                                echo '<td>'.$d['dtmaxDegree'].'</td>';
                            $c++;
                            $pre = $d['cid'];
                            echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table>';
            }else 
                echo '<h4 class="text-center alert alert-info">لا توجد درجات مسجلة الان</h4>';
        }else
            echo '<h4 class="text-center alert alert-success">لا توجد درجات مسجلة الان</h4>';
        ?>
    </div>
</div>
<div class="desc_sec absence_table">
     <h1 class="text-center">الغياب</h1>   
    <div class="absenceAlert">
        <?php
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if ($academic == false) $persent = 0;
        else{
            $absence = selectData('*','absence,absence_day','adid=aadid and adacademicYear='.$academic['aid'].' and abstudentId='.$id.' order by day desc',1);
            $alert = 0;
            if (count($absence) >= 10 && count($absence) <= 15) $alert = 2;
            else if (count($absence) > 15 && count($absence) <= 20) $alert = 3;
            else if (count($absence) > 20) $alert = 4;
            
        }
        ?>
        <span>عدد الايام : <span><?php echo count($absence);?></span></span>
        <span>الانذار رقم : <span><?php echo $alert;?></span></span>
    </div>
    <div class="body sub23">
        <?php
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if($academic != false){
            $absence = selectData('*','absence,absence_day','adid=aadid and adacademicYear='.$academic['aid'].' and abstudentId='.$id.' order by day desc',1);
            if($absence != false){
                $c = 1;
                echo '<table class="table">';
                    echo '<thead class="color text-center">';
                            echo '<th>رقم</th>';
                            echo '<th>اليوم</th>';
                            echo '<th>التاريخ</th>';
                    echo '</thead>';
                    echo '<tbody class="text-center">';
                        foreach($absence as $b){
                            echo '<tr ';
                            if($c%2 == 0) echo 'class="even"';
                            echo '>';
                                echo '<td>'.$c.'</td>';
                                echo '<td>'.day(date('D', strtotime($b['day'])),0).'</td>';
                                echo '<td>'.$b['day'].'</td>';
                            $c++;
                            echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table>';
            }else 
                echo '<h4 class="text-center alert alert-info">لا توجد درجات مسجلة الان</h4>';
        }else
            echo '<h4 class="text-center alert alert-success">لا توجد درجات مسجلة الان</h4>';
        ?>
    </div>  
</div>
    
<!-- end section Assignment -->
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