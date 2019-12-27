<?php
session_start();
if(!(isset($_SESSION['Username']) && isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 2)){
    header('Location: index.php');
}else{
    $name = $_SESSION['Username'];
    $groupid = $_SESSION['GroupID'];
    $id = $_SESSION['UserId'];
    include 'connect.php';
    include 'includes/functions/function.php';
    $info = selectData('*','user','id='.$id);
    $academic = selectData('*','academic_year','1 order by aid desc limit 1');
    //redirectHome('mesg','teacher.php','default',4);
    
}
?><!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Liber</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/font/css/all.css">
    <link rel="stylesheet" href="layout/css/main.css">
    <link href="layout/css/cairo.css" rel="stylesheet">
    <link href="layout/css/CairoCss.css" rel="stylesheet">
    <link rel="icon" href="layout/imgs/logo.png">
</head>
<body>
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['addDegree']) || isset($_POST['editDegree']) || isset($_POST['showDegree'])){
            $do = 'addDegree';
            $val = 'style="display:none;"';
        }else{
            $val = '';
        }
        if(isset($_POST['addDegreeFinal'])){
            $check = selectData('*','degreetype','dtcourseId='.$_POST['courseName'].' and dtname="'.$_POST['dtname'].'" and dtacademicYear='.$academic['aid']);
            if($check == false || $check == 0){// that for check if this info is exist before or not
                //here insert the information about this exam into database
                $stmt = $con->prepare('insert into degreeType (dtname,dtcourseId,dtacademicYear,dtmaxDegree,dtexamDate) values (?,?,?,?,?)');
                $stmt->execute(array($_POST['dtname'],$_POST['courseName'],$academic['aid'],$_POST['maxDegree'],$_POST['date']));
                if($stmt->rowCount() > 0){
                    $count =0;
                    $dtid = selectData('dtid','degreeType','1 order by dtid desc limit 1');
                    foreach($_POST as $key=>$value){
                        if(is_numeric($key)){
                            $stmt = $con->prepare('insert into degree (dtype,dstudentId,degree) values (?,?,?)');
                            $stmt->execute(array($dtid['dtid'],$key,$value));
                            if($stmt->rowCount() > 0)
                                $count++;
                        }
                    }
                    $msg = '<div class="text-center">تم لتسجيل الدرجات بنجاح</div>';
                    redirectHome($msg,'?do=manage_student','',1);
                }else{
                    redirectHome('حدث خطاء في اضافة الامتحان .. يرجي اعادة المحاولة','?do=add_degree','default');
                }
            }else{
                redirectHome('هذا الامتحان مسجل مسبقا','?do=add_degree','default',1);
            }
        }else if(isset($_POST['deleteDegree'])){
            $check = deleteData('degreetype','dtid='.$_POST['dtid']);
            if($check == false)
                redirectHome('لم يتم الحذف .. يرجي المحاولة مرة اخري','teacher.php','default');
            else{
                $msg = '<div class="text-center">تم العملية بنجاح</div>';
                redirectHome($msg,'teacher.php','');
            }
        }else if(isset($_POST['editDegreeFinal'])){
            $error = 0;
            $stmt = $con->prepare('update degreetype set dtname=?,dtcourseId=?,dtmaxDegree=?,dtexamDate=? where dtid=?');
            $stmt->execute(array($_POST['dtname'],$_POST['courseName'],$_POST['maxDegree'],$_POST['date'],$_POST['dtid']));
            foreach($_POST as $key=>$value){
                if(is_numeric($key)){
                    $stmt = $con->prepare('update degree set degree=? where dstudentId=?');
                    $stmt->execute(array($value,$key));
                    $check = isExist('degree','degree='.$value.' and dstudentId='.$key);
                    if($stmt->rowCount() == 0 and $check == false)
                        $error++;
                }
            }
            if($error != 0)
                redirectHome('لم يتم التعديل .. يرجي المحاولة مرة اخري','teacher.php','default');
            else{
                $msg = '<div class="text-center">تمت العملة التعديل بنجاح</div>';
                redirectHome($msg,'teacher.php','');
            }
        }
    }
    ?>
   <header class="std_header">
    <!-- Start Upper-bar -->
    <?php include 'includes/templates/navbar.php';?>
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
            <li><a href="#degree" id="degreeTable">الدرجات </a></li>
            <li><a href="#absence" id="absenceTable">الغياب </a></li>
            <li><a href="#add_lectur" id="lectur">المحاضرات </a></li>
            <li><a href="#add_homework" id="homework">الواجب المنزلي  </a></li>
            <li><a href="#add_quize" id="quize">الامتحانات </a></li>
        </ul>
      </div>
    
    </section>
</header>
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
            <li class="std_id "><span>التخصص : </span><span><?php echo $info['description'];?></span></li>
          </ul>
        </div>
         </div>
           <!--- end profile ----->
           <!----- tabels -------->
     <div class="col-md-9">
      <div class="desc_sec week_calender" <?php if(isset($do)) echo $val;?> >
          <!------- timetable ------>
        <div class="timetable">  
         <h4>الجدول الاسبوعي </h4>
          <div class="timeline" id="timetable">
           <div class="container">
            <div class="parts">
            <!-- Part 1 -->
                <?php
                $academic = selectData('*','academic_year','1 order by aid desc limit 1');
                if($academic != false){
                    $teacherDay = selectData('DISTINCT sday','schedule_name,reg_teacher,schedule','rtcourseId=scourseId and ssnid=snid and sntype="دراسي" and rtacademicYear='.$academic['aid'].' and rtteacherId='.$id,1);
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
                                        $courseDate = selectData('cname,clevel,stime','reg_teacher,course,schedule_name,schedule','ssnid=snid and scourseId=cid and scourseId=rtcourseId and rtteacherId='.$id.' and snacademicYear='.$academic['aid'].' and sday='.$day[0],1);
                                        foreach($courseDate as $c){
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
                                                            printClass($c['clevel']);
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
           </div>
            <!-----end time table ----->
         <div class="desc_sec add lecture_div" <?php if(isset($do)) echo $val;?>  id="add_lectur">
            <div class="content">
            <h1 class="text-center">اضافة محاضرة جديدة</h1>
            <form action="uploader.php" method="POST" enctype="multipart/form-data">
                <!-- Subject Name -->
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="اسم الملف" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-book"></i>
                    <select class="form-control" name="cid" required="required">
                        <?php
                        $course = selectData('cid,cname,clevel','reg_teacher,course','rtcourseId=cid and rtteacherId='.$id.' order by clevel',1);
                        if($course == false)
                            echo '<option value="0">لاتوجد مواد</option>';
                        else{
                            echo '<option value="0" selected disabled> اسم المادة </option>';
                            foreach($course as $c){
                                echo '<option value="'.$c['cid'].'">'.$c['cname'].' => ';
                                printclass($c['clevel']);
                                echo'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Class -->
                <!-- Profile Image -->
                <div class="form-group">
                    <i class="far fa-file"></i>
                    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                    <input type="hidden" name="aid" value="<?php echo $academic['aid']?>" />
                    <input type="hidden" name="path" value="lectrue">
                    <input type="hidden" name="url" value="teacher.php">
                    <input type="hidden" name="type" value="3">
                    <input type="hidden" name="uploaderOn" value="">
                    <input type="file" name="data" class="form-control" required="required">
                    
                </div>
                <!-- Start Submit Field -->
                <div class="form-group">
                    
                    <input type="submit" value="اضافة محاضرة " class="btn btn-primary form-control" />
                </div>
            </form>
        </div>
          
         
         </div>
         <div class="desc_sec add  home_work_div" <?php if(isset($do)) echo $val;?>  id="add_homework">
           <div class="content">
            <h1 class="text-center">اضافة واجب منزلي جديد</h1>
            <form action="uploader.php" method="POST" enctype="multipart/form-data">
                <!-- Subject Name -->
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="اسم الملف" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-book"></i>
                    <select class="form-control" name="cid" required="required">
                        <?php
                        $course = selectData('cid,cname,clevel','reg_teacher,course','rtcourseId=cid and rtteacherId='.$id.' order by clevel',1);
                        if($course == false)
                            echo '<option value="0">لاتوجد مواد</option>';
                        else{
                            echo '<option value="0" selected disabled> اسم المادة </option>';
                            foreach($course as $c){
                                echo '<option value="'.$c['cid'].'">'.$c['cname'].' => ';
                                printclass($c['clevel']);
                                echo'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Class -->
                <!-- Profile Image -->
                <div class="form-group">
                    <i class="far fa-file"></i>
                    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                    <input type="hidden" name="aid" value="<?php echo $academic['aid']?>" />
                    <input type="hidden" name="path" value="homework">
                    <input type="hidden" name="url" value="teacher.php">
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="uploaderOn" value="">
                    <input type="file" name="data" class="form-control" required="required">
                </div>
                <!-- Start Submit Field -->
                <div class="form-group">
                    
                    <input type="submit" value="اضافة واجب منزلي " class="btn btn-primary form-control" />
                </div>
            </form>
        </div>
          
         
         </div>
            <div class="desc_sec add home_assignment_div" <?php if(isset($do)) echo $val;?>  id="add_quize">
            <div class="content">
            <h1 class="text-center">اضافة اختبار جديد</h1>
            <form action="uploader.php" method="POST" enctype="multipart/form-data">
                <!-- Subject Name -->
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="اسم الملف" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-book"></i>
                    <select class="form-control" name="cid" required="required">
                        <?php
                        $course = selectData('cid,cname,clevel','reg_teacher,course','rtcourseId=cid and rtteacherId='.$id.' order by clevel',1);
                        if($course == false)
                            echo '<option value="0">لاتوجد مواد</option>';
                        else{
                            echo '<option value="0" selected disabled> اسم المادة </option>';
                            foreach($course as $c){
                                echo '<option value="'.$c['cid'].'">'.$c['cname'].' => ';
                                printclass($c['clevel']);
                                echo'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Class -->
                <!-- Profile Image -->
                <div class="form-group">
                    <i class="far fa-file"></i>
                    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                    <input type="hidden" name="aid" value="<?php echo $academic['aid']?>" />
                    <input type="hidden" name="path" value="exam">
                    <input type="hidden" name="url" value="teacher.php">
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="uploaderOn" value="">
                    <input type="file" name="data" class="form-control" required="required">
                </div>
                <!-- Start Submit Field -->
                <div class="form-group">
                    
                    <input type="submit" value="اضافة اختبار " class="btn btn-primary form-control" />
                </div>
            </form>
        </div>
        </div>
         <div class="desc_sec degree degree_table" <?php if(isset($do)) echo $val;?> id="degree" >
            <h1 class="text-center">الدرجات</h1>
             <?php
             $academic = selectData('*','academic_year','1 order by aid desc limit 1');
             if ($academic != false){
                 $nameDegree = selectData('*','reg_teacher,degreetype,course','rtteacherId='.$id.' and dtcourseId=rtcourseId and dtcourseId=cid order by cid',1);
                 if($nameDegree != false){
                 ?>
             <div class="filter degree row">
                 <form action="<?php echo $_SERVER['PHP_SELF']?>#add_degree" method="post" class="row">
                    <input type="search" name="searchStudent" class="form-control" placeholder="بحث بالاسم او رقم">
                    <input type="submit" name="addDegree" class="btn btn-primary fff" value="اضافة درجات">
                 </form>
            </div>
             <div class="listDegree">
                <table class="table">
                    <thead>
                        <th>رقم</th>
                        <th>المادة</th>
                        <th>الصف</th>
                        <th>اسم الامتحان</th>
                        <th>تاريخ</th>
                        <th>الدرجة القصوي</th>
                        <th>تعديل</th>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        foreach($nameDegree as $d){
                            echo '<tr>';
                                echo '<td>'.$c.'</td>';
                                echo '<td>'.$d['cname'].'</td>';
                                echo '<td>';
                                printClass($d['clevel']);
                                echo '</td>';
                                echo '<td>'.$d['dtname'].'</td>';
                                echo '<td>'.$d['dtexamDate'].'</td>';
                                echo '<td>'.$d['dtmaxDegree'].'</td>';
                                echo '<td>';
                                    echo '<form action="teacher.php#degreeTable" method="post" class="editButton">';
                                        echo '<input type="hidden" name="dtid" value="'.$d['dtid'].'">';
                                        echo '<input type="submit" name="showDegree" action="teacher.php#showDegree" value="عرض" class="btn btn-info">';
                                        echo '<input type="submit" name="editDegree" value="تعديل" class="btn btn-success">';
                                        echo '<input type="submit" name="deleteDegree" value="حذف" class="btn btn-danger">';
                                    echo '</form>';
                                echo '</td>';
                            echo '</tr>';
                            $c++;
                        }
                        ?>
                    </tbody>
                </table>
             </div>
             <?php
                 }else
                     echo '<h4 class="text-center alert-info">لا يوجد درجات مسجلة</h4>';
             }else
                 echo '<h4 class="text-center alert-warning">لا يوجد ترم مسجل</h4>';
             ?>
         </div>
            <div class="desc_sec absence_table" <?php if(isset($do)) echo $val;?> id="absence">
     <h1 class="text-center">الغياب</h1>   
    <div class="absenceAlert">
        <?php
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if ($academic == false) $persent = 0;
        else{
            $absence = selectData('*','absence,absence_day','adid=aadid and adacademicYear='.$academic['aid'].' and abstudentId='.$id.' order by day desc',1);
            $countAbsence = selectData('count(*)','absence_day','adacademicYear='.$academic['aid']);
            if(isset($absence[0][0])) $c = count($absence);
            else $c =0;
            $persent = ($c*100)/$countAbsence[0];
            $alert = 0;
            if ($persent >= 20 && $persent <= 30 && $countAbsence[0] > 10 && $countAbsence[0] < 30) $alert = 1;
            else if ($persent >= 30 && $persent <= 40 && $countAbsence[0] > 30 && $countAbsence[0] < 40) $alert = 2;
            else if ($persent >= 40 && $persent <= 50) $alert = 3;
            else if($persent > 50) $alert = 4;
        }
        ?>
        <span>نسبة المئوية : <span><?php echo $persent;?></span></span>
        <span>الانذار رقم : <span><?php echo $alert;?></span></span>
    </div>
    <div class="body sub23">
        <?php
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if($academic != false){
            $absence = selectData('*','absence,absence_day','adid=aadid and adacademicYear='.$academic['aid'].' and abstudentId='.$id.' order by day desc');
            if($absence != false){
                $c = 1;
                echo '<table class="table">';
                    echo '<thead class="color">';
                            echo '<th>رقم</th>';
                            echo '<th>اليوم</th>';
                            echo '<th>التاريخ</th>';
                    echo '</thead>';
                    echo '<tbody>';
                        foreach($absence as $b){
                            echo '<tr ';
                            if($c%2 == 0) echo 'class="even"';
                            echo '>';
                                echo '<td>'.$c.'</td>';
                                echo '<td>'.day(date('D', strtotime($b['day']))).'</td>';
                                echo '<td>'.$b['day'].'</td>';
                            $c++;
                            echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table>';
            }else 
                echo '<h4 class="text-center alert alert-info">لا توجد فترة غياب مسجلة</h4>';
        }else
            echo '<h4 class="text-center alert alert-success">لا توجد فترة غياب مسجلة</h4>';
        ?>
    </div>  
</div>
         <?php
           if(isset($_POST['addDegree']) || isset($_POST['editDegree'])){
               if(isset($_POST['noSteps'])) $step = $_POST['noSteps'];
               else $step = 1;
               if(isset($_POST['editDegree']))
                   $degreeType = selectData('*','degreetype','dtid='.$_POST['dtid']);
               ?>
           <div class="desc_sec add addDegree" id="add_degree">
                
               <?php 
               if($step == 1){
               ?>
               <h1 class="text-center">الدرجات</h1>
               <form action="teacher.php#add_degree" method="post" class="sform">
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <label for="code" class="col-sm-2 col-form-label">اسم الامتحان</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="code"  name="dtname" value="<?php if(isset($degreeType)) echo $degreeType['dtname'] ;?>">
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <label for="cname" class="col-sm-2 col-form-label">اسم المادة</label>
                        <div class="col-sm-6">
                          <select name="courseName" class="form-control">
                              <option disabled selected></option>
                            <?php
                                if(isset($degreeType))
                                    $val = ' and rtcourseId='.$degreeType['dtcourseId'];
                                else $val = '';
                              $courses = selectData('*','reg_teacher,course','rtcourseId=cid and rtacademicYear='.$academic['aid'].' and rtteacherId='.$id.$val,1);
                              if(!isset($degreeType)) {
                              foreach($courses as $c){
                                  echo '<option value="'.$c['cid'].'">'.$c['cname'].' -> ';
                                  printClass($c['clevel']);
                                  echo '</option>';
                              }
                              }
                                else
                                    echo '<option selected value="'.$courses[0]['cid'].'">'.$courses[0]['cname'].' -> ';
                                      printClass($courses[0]['clevel']);
                                    echo '</option>';
                              ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                      </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <label for="code" class="col-sm-2 col-form-label">الدرجة القصي</label>
                        <div class="col-sm-6">
                            <?php
                            if(isset($degreeType))
                                $max = 'value="'.$degreeType['dtmaxDegree'].'"';
                            else $max = '';
                            ?>
                            <input type="number" class="form-control" id="code"  name="maxDegree" <?php echo $max;?> >
                        </div>
                        <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group row">
                        <?php
                            if(isset($degreeType))
                                $max = 'value="'.$degreeType['dtexamDate'].'"';
                            else $max = '';
                            ?>
                        <div class="col-sm-2"></div>
                        <label for="semester" class="col-sm-2 col-form-label">تاريخ الامتحان</label>
                        <div class="col-sm-6">
                            <input type="date" name="date" class="form-control" <?php echo $max;?> >
                        </div>
                        <div class="col-sm-2"></div>
                      </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-6">
                            <?php 
                            if(isset($degreeType) && !isset($_POST['addDegree'])){
                                echo '<input type="hidden" name="editDegree" >';
                                echo '<input type="hidden" name="dtid" value="'.$_POST['dtid'].'">';
                            }
                            ?>
                            <input type="hidden" name="noSteps" value="2">
                            <button type="submit" name="addDegree" class="btn btn-primary from-control col-sm-4">الخطوة التالية</button>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </form>
               <?php
               }
               else if($step == 2){
                   if(!isset($_POST['editDegree'])){
                       $check = selectData('*','degreetype','dtcourseId='.$_POST['courseName'].' and dtname="'.$_POST['dtname'].'" and dtacademicYear='.$academic['aid']);
                   }else
                       $check = true;
                   if(isset($_POST['editDegree']))
                            echo '<h1 class="text-center">تعديل الدرجات</h1>';
                       else echo '<h1 class="text-center">اضافة الدرجات</h1>';
                   if($check == false){
                       
                       if(!isset($_POST['editDegree']))
                            $student = selectData('*','reg_course,course,user','studentId=id and courseId=cid and courseId='.$_POST['courseName'].' order by name',1);
                       else
                           $student = selectData('*','degreetype,degree,user,course','dtcourseId=cid and dstudentId=id and dtype=dtid and dtype='.$_POST['dtid'],1);
                       if($student != false){
                           ?>
                            <div class="infoDegree row">
                                <div class="col">المادة : <span><?php echo $student[0]['cname'];?></span></div>
                                <div class="col">الصف : <span><?php  printClass($student[0]['clevel']);?></span></div>
                                <div class="col">اسم الامتحان : <span><?php echo $_POST['dtname'];?></span></div>
                            </div>
                            <form action="teacher.php#add_degree" method="post" class="editTable">
                                <table class="table">
                                    <thead>
                                        <th scope="col">رقم</th>
                                        <th scope="col">رقم الهوية</th>
                                        <th scope="col">اسم الطالب</th>
                                        <th scope="col">الدرجة</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $c =1;
                                        foreach($student as $s){
                                            echo '<tr ';
                                            if(isset($_POST['editDegree']))
                                                $val = 'value="'.$s['degree'].'"';
                                            else $val = '';
                                            if($c%2==0) echo 'class="even"';
                                            echo '>';                       
                                                echo '<td>'.$c.'</td>';
                                                echo '<td>'.$s['id'].'</td>';
                                                echo '<td>'.$s['name'].'</td>';
                                                echo '<td><input type="number" min="0" max="'.$_POST['maxDegree'].'" name="'.$s['id'].'" '.$val.' class="form-control" required></td>';
                                            echo '</tr>';   
                                            $c++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                    foreach($_POST as $key=>$value){
                                        echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
                                    }
                                ?>
                                <input type="hidden" name="cid" value="<?php echo $courseName?>">
                                <?php
                                if(isset($_POST['editDegree'])){
                                    echo '<input type="hidden" name="dtid" value="'.$_POST['dtid'].'">';
                                    echo '<button type="submit" name="editDegreeFinal" class="btn btn-primary btn-center text-center">تعديل الدرجات</button>';
                                }else{
                                    echo '<button type="submit" name="addDegreeFinal" class="btn btn-primary btn-center text-center">اضافة الدرجات</button>';
                                }
                                ?>

                            </form>
                            <?php
                       }else
                           echo '<h4 class="text-center alert alert-warning">لا يوجد طلاب في هذا الصف</h4>';
                   }else{
                       echo '<h4 class="text-center alert alert-danger">هذه البيانات موجودة مسبقا</h4>';
                   }
                   
               }else
                   echo 'else here';
           }
            else if(isset($_POST['showDegree'])){
                echo '<div class="showDegree">';
               echo '<h1 class="text-center">عرض الدرجات</h1>';
                $student = selectData('*','degreetype,degree,user,course','dtcourseId=cid and dstudentId=id and dtype=dtid and dtype='.$_POST['dtid'],1);
               if($student != false){
                   ?>
                    <div class="infoDegree d row">
                        <div class="col text-center">المادة : <span><?php echo $student[0]['cname'];?></span></div>
                        <div class="col text-center">الصف : <span><?php  printClass($student[0]['clevel']);?></span></div>
                        <div class="col text-center">اسم الامتحان : <span><?php echo $student[0]['dtname'];?></span></div>
                        <div class="col text-center">اسم الامتحان : <span><?php echo $student[0]['dtname'];?></span></div>
                    </div>
                    <div class="sub23">
                        <table class="table rtl" dir="rtl">
                            <thead class="color">
                                <th scope="col"><span>رقم</span></th>
                                <th scope="col"><span>رقم الهوية</span></th>
                                <th scope="col"><span>اسم الطالب</span></th>
                                <th scope="col"><span>الدرجة</span></th>
                            </thead>
                            <tbody>
                                <?php
                                $c =1;
                                foreach($student as $s){
                                    echo '<tr ';
                                    if($c%2==0) echo 'class="even"';
                                    echo '>';                       
                                        echo '<td><span>'.$c.'</span></td>';
                                        echo '<td><span>'.$s['id'].'</span></td>';
                                        echo '<td><span>'.$s['name'].'</span></td>';
                                        echo '<td><span>'.$s['degree'].'</span></td>';
                                    echo '</tr>';   
                                    $c++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
               }else
                   echo '<h4 class="text-center alert alert-warning">لا يوجد طلاب في هذا الصف</h4>';
            echo '</div>';
            }
           ?>
           </div>
           
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