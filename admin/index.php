<?php
session_start();
include 'init.php';
print_r($_SESSION);
if(isset($_SESSION['Username'])&& isset($_SESSION['GroupID'])&&($_SESSION['GroupID'] == 2 || $_SESSION['GroupID'] == 4)){
    //print_r($_SESSION);
    //print_r($_POST)
    $goBack = 'javascript:history.go(-1)';
    function isExist($table,$condition){
        global $con;
        $stmt = $con->prepare('select * from '.$table.' where '.$condition);
        $stmt->execute();
        if($stmt->rowCount() > 0)
            return true;
        return false;
    }
    function selectData($select='*',$from,$condition,$ch = 0){
        global $con;
        $stmt = $con->prepare('select '.$select.' from '.$from.' where '.$condition.'');
        $stmt->execute();
        if($stmt->rowCount() == 0)
            return false;
        else if($stmt->rowCount() == 1 && $ch ==0){
            return $stmt->fetch();
        }
        return $stmt->fetchAll();
    }
    // $check = selectData('*','admin','teacherId='.$_SESSION['id']);
    // if($check == false){
    //     header('Location: logout.php');
    //     exit();
    // }
    function deleteData($table,$condition){
        global $con;
        $stmt = $con->prepare('delete from '.$table.' where '.$condition);
        $stmt->execute();
        if($stmt->rowCount() == 0)
            return false;
        return true;
    }
    function regStudent($cid){
        global $con;
        $check = selectData('*','course','cid='.$cid);
        $error = 0;
        if($check != false){
            #$regCourse = selectData('*','reg_course','academicYear in (select max(aid) from academic_year) and courseId='.$cid,1);
            $allStudent = selectData('*','user','groupid=1  and regdate='.(date('Y')-$check['clevel']+1),1);
            if($allStudent != false){
                echo 'in the condition 1 -- ';
                foreach($allStudent as $as){
                    $academic = selectData('aid','academic_year','1 order by aid desc limit 1');
                    if($academic == false) return false;
                    $check = isExist('reg_course','academicYear='.$academic['aid'].' and courseId='.$cid.' and studentId='.$as['id']);
                    if($check == true) continue;
                    $stmt = $con->prepare('insert into reg_course (studentId,courseId,academicYear) values (?,?,?)');
                    $stmt->execute(array($as['id'],$cid,$academic['aid']));
                    if($stmt->rowCount() == 0) $error++;
                }
                if($error == 0) return true;
                else return false;
            }else
                return true;
        }
        return false;
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appearShowStudent'])) //when jquery submit , that will enter his page
        $do = 'show_student';
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appearShowTeacher']))
        $do = 'show_teacher';
    else
        $do = isset($_GET['do'])?$_GET['do']:'main_page';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewStudent'])){
        $student_name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $ssn = $_POST['ssn'];
        $address = $_POST['address'];
//        $pssn = $_POST['pssn'];
        $birthday = $_POST['birthday'];
//        $pbrithday = $_POST['pbirthday'];
        $stmt = $con->prepare("insert into user (`name`, `username`, `email`, `password`, `groupid`, `birthday`, `startdate`, `phone`, `address`, `regdate`, `ssn`,active) values (?,?,?,?,?,?,?,?,?,?,?,?)");
        $nameSplit = explode(' ',$student_name);
        $username = $nameSplit[0];
        $u = $username;
        $password =  sha1($_POST['password']);
        $date = date("Y-m-d");
        $year = date('Y');
        $stmt->execute(array($student_name,$username,$email,$password,1,$birthday,$date,$phone,$address,$year,$ssn,1));
        if($stmt->rowCount() == 0){
            redirecthHome('يرجي المحاولة مرة اخري','','default');
        }else{
            $id = selectData('*','user','name="'.$student_name.'" and password="'.$password.'" and email="'.$email.'"');
            $username= $nameSplit[0].$id['id'];
            $stmt = $con->prepare('update user set username=? where id=?');
            $stmt->execute(array($username,$id['id']));
            if($stmt->rowCount() == 0)
                redirecthHome('يرجي المحاولة مرة اخري','','default');
            else{
                if(!isset($_POST['parentExist']) || $_POST['parentExist']==0){
                $stmt = $con->prepare("insert into user (`name`, `username`, `email`, `password`, `groupid`, `startdate`, `phone`,address, `ssn`,active) values (?,?,?,?,?,?,?,?,?,?)");
                $nameSplit = explode(' ',$_POST['parentName']);
                $username = $nameSplit[0];
                $password = $_POST['password1'];
                $stmt->execute(array($_POST['parentName'],$username,$_POST['parentEmail'],$password,3,$date,$_POST['parentPhone'],$_POST['parentAddress'],$_POST['parentSsn'],1));
                if($stmt->rowCount() != 0){
                    $check1 = selectData('*','user','username="'.$username.'"');
                    if($check1 != false){
                        $stmt= $con->prepare('update user set username="'.$username.$check1['id'].'" where id='.$check1['id']);
                        $stmt->execute();
                    }
                }
                }else
                    $check1 = selectData('*','user','id='.$_POST['parentExist']);
                $msg = '<div class="text-center">تم تسجيل الطالب فقط</div>';
                //add parent here
                    $stmt = $con->prepare('insert into parent (studentId,parentId) values ('.$id['id'].','.$check1['id'].')');
                    $stmt->execute();
                    if($stmt->rowCount() == 0)
                        $msg= '<div class="text-center">حدث خطاء ما يرجي المحاولة مرة اخري</div>';
                if($stmt->rowCount() == 0)
                    redirecthHome($msg,'index.php','');
            }
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'?do=show_student','');
//            $stmt = $con->prepare('select id,name,regdate from user where groupId=1');
//                $stmt->execute();
//                $students = $stmt->fetchAll();
//                if($stmt->rowCount() > 0){
//                    foreach($students as $s){
//                        $stmt = $con->prepare('select * from course,academic_year where year=? and semester=? and csemester=?');
//                        $stmt->execute(array(date('Y'),$select2,$select2));
//                        $rows = $stmt->fetchAll();
//                        if($stmt->rowCount() > 0){
//                            foreach($rows as $r){
//                                $l = date('Y')-$s['regdate']+1;
//                                if($l!=$r['clevel'])
//                                    continue;
//                                $stmt = $con->prepare('insert into reg_course (studentId,courseId,academicYear) values (?,?,?)');
//                                $stmt->execute(array($s['id'],$r['cid'],$r['aid']));
//                            }
//                        }
//                    }
//                }else{
//                    echo '<h1>fine0</h1>';
//                }
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewSemester']) && isset($_POST['noSteps']) && $_POST['noSteps'] == 3){
                        // first we must regist the new semester after that will regist the teacher to the course ..
        $stmt = $con->prepare('select * from academic_year where yearId=?');
        $stmt->execute(array($_POST['yearId']));
        if($stmt->rowCount()==0){
            $check = selectData('checked','academic_year','1 order by aid desc limit 2',1);
            if($check != false){
                if(count($check) == 1) $check = $check[0][0];
                else{
                    if($check[0][0] == $check[1][0]){
                        if($check[0][0] == false) $check = true;
                        else $check = false;
                    }else
                        $check = $check[0][0];
                }
            }else
                $check = false;
            $stmt = $con->prepare('insert into academic_year (yearId ,year, semester,checked) values (?,?,?,?)');
            $stmt->execute(array($_POST['yearId'],date('Y-m-d'),$_POST['semester'],$check));
            if ($stmt->rowCount() > 0){
                $stmt = $con->prepare('select max(aid) from academic_year');
                $stmt->execute();
                $aid = $stmt->fetch();
                $aid = $aid['max(aid)'];
                foreach($_POST as $key=>$value){
                    $postKey = explode('-',$key);
                    // that postKey => containt number of class and number of course
                    if(count($postKey) == 3){
                        $level = $postKey[1]; // get level -> done
                        $courseId = $postKey[2];// get course id --> done
                        $teacherId = $_POST[$key]; // get post --> done
                        $stmt = $con->prepare('insert into reg_teacher (rtteacherId , rtcourseId , rtacademicYear) values (?,?,?)');
                        $stmt->execute(array($teacherId,$courseId,$aid));
                        if($stmt->rowCount()==0){
                            redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','index.php','default');
                        }else{
                            // this section for regist the student automatic about courses into reg_course
                            $stmt = $con->prepare('select id from user where groupid=1 and regdate=? ');
                            $stmt->execute(array(date('Y')-$level+1));
                            $students = $stmt->fetchAll();
                            if($stmt->rowCount()>0){
                                foreach($students as $s){
                                    $stmt = $con->prepare('insert into reg_course (studentId,courseId,academicYear) values (?,?,?)');
                                    $stmt->execute(array($s['id'],$courseId,$aid));
                                    if($stmt->rowCount()==0){ // check if there student not regist here..

                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                redirectHome('لم يتم تسجيل الترم .. يرجي المحاولة مرة اخري' ,'index.php','default');
            }
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'index.php','');
        }else{
            redirectHome('لا يمكن التسجيل بنفس الاسم الترم السابق .. يرجي المحاولة مرة اخري','index.php','default');
        }

    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['showEvent']))
        $do = 'showEvent';
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addDegreeFinal'])){
        $check = isExist('degreeType','dtname="'.$_POST['dtname'].'" and dtcourseId='.$_POST['cid'].' and dtacademicYear='.$_POST['aid']);
        if($check == false){// that for check if this info is exist before or not
            //here insert the information about this exam into database
            $stmt = $con->prepare('insert into degreeType (dtname,dtcourseId,dtacademicYear,dtmaxDegree,dtexamDate) values (?,?,?,?,?)');
            $stmt->execute(array($_POST['dtname'],$_POST['cid'],$_POST['aid'],$_POST['maxDegree'],$_POST['date']));
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
                redirectHome('هذا الامتحان مسجل مسبقا','?do=add_degree','default');
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['degreeType'])){
        $check = isExist('degreeType' ,'dtid='.$_POST['dtid']);
        if($check == true){
            if(isset($_POST['deleteDegreeType'])){
                if(deleteData('degreeType','dtid='.$_POST['dtid'])){
                    $msg = '<div class="text-center">تم الحذ بنجاح</div>';
                    redirectHome($msg,'?do=manage_student','');
                }else
                    redirectHome('حدث خطاء ما .. لم يتم الحذف','?do=manage_student','default');
            }
            else if(isset($_POST['editDegreeType'])){
                $do = 'edit_degreeType';
            }
            else if(isset($_POST['showDegreeType'])){
                $do = 'show_degreeStudent';
            }
        }else{
            redirectHome('حدث خطاء ما .. يرجي اعادة المحاولة','index.php','default',1);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['edit_event']) || isset($_POST['delete_event']))){
        if(isset($_POST['edit_event']))
            $do = 'edit_event';
        else{
            $stmt = $con->prepare('delete from event where eid='.$_POST['eid']);
            $stmt->execute();
            if($stmt->rowCount() == 0)
                redirectHome('لم يتم التسجيل .. يرجي المحاولة مرة اخري','?do=show_event','');
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'?do=show_event','');
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectUser'])){
        $do = 'regEvent';
        $regevent= selectData('*','reg_event','reevent='.$_POST['eid'].' and reuser='.$_POST['user']);
        if($regevent == false){
            $stmt = $con->prepare('insert into reg_event (reevent,reuser,redate) values (?,?,?)');
            $stmt->execute(array($_POST['eid'],$_POST['user'],date('Y-m-d')));
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editStudentDegree'])){
        $do = 'editStudentDegree';
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editDegreeFinal'])){
        $selectCourse = selectData('cid','course,academic_year','csemester=semester and aid in (select max(aid) from academic_year) and cname="'.$_POST['courseName'].'" and clevel='.$_POST['classes']);
        if($selectCourse != false){
            $check = isExist('degreeType','dtname="'.$_POST['dtname'].'" and dtcourseId='.$selectCourse['cid'].' and dtexamDate="'.$_POST['date'].'" and dtmaxDegree='.$_POST['maxDegree'].' and dtid='.$_POST['dtid']);
            if($check == false){
                $stmt = $con->prepare('update degreeType set dtname=? , dtcourseId=? , dtexamDate=? , dtmaxDegree=? where dtid=?');
                $stmt->execute(array($_POST['dtname'],$selectCourse['cid'],$_POST['date'],$_POST['maxDegree'],$_POST['dtid']));
                if($stmt->rowCount() == 0)
                redirectHome('حدث خطاء في تحديث البيانات .. يرجي المحاولة مرة اخري','?do=manage_student','default',100);
            }
            $msg = '<div class="text-center">تم العملية بنجاح</div>';
            redirectHome($msg,'?do=manage_student','',1);
        }else{
            redirectHome('لا يمكن تسجيل هذه المادة الانها لم تسجل بعد في هذا الترم','?do=manage_student','default');
        }

    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post1'])){ // remove from reg_teacher
        $do = 'profileTeacher';
        $id = $_POST['studentId'];
        $stmt = $con->prepare('delete from reg_teacher where rtid=?');
        $stmt->execute(array($_POST['post1']));
        if($stmt->rowCount() > 0){
            $msg = '<div class="text-center">تم الحذف المادة بنجاح</div>';
            redirectHome($msg,'index.php?do=profileTeacher&&id='.$id,'',1);
        }else{
            redirectHome('حدث خطاء ما .. يرجا المحاولة مرة اخري','index.php?do=profileTeacher&&id='.$id,'default',1);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['regTeacher'])){
        $stmt = $con->prepare('insert into reg_teacher (rtteacherId,rtcourseId,rtacademicYear) value (?,?,?)');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['addEvent']) || isset($_POST['editEvent']))){
        $currentDate = date('Y-m-d');
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if($academic == false)
            redirectHome('لا يوجد فصل دراسي','','default');
        if(isset($_POST['editEvent'])){
            $check = selectData('*','event','edate="'.$_POST['date'].'" and title="'.$_POST['title'].'" and details="'.$_POST['details'].'" and eacademicYear='.$academic[0]);
            if($check != false){
                $msg = '<div class="text-center">تمت العملية بنجاح</div>';
                redirectHome($msg,'?do=show_event','');
            }
        }
        if(isset($_POST['editEvent'])){
            $stmt = $con->prepare('update event set title=? , details=? , edate=? where eid=?');
            $stmt->execute(array($_POST['title'],$_POST['details'],$_POST['date'],$_POST['eid']));
        }else{
            $stmt = $con->prepare('insert into event (title,details,edate,eacademicYear) values (?,?,?,?)');
            $stmt->execute(array($_POST['title'],$_POST['details'],$_POST['date'],$academic[0]));
        }
        if($stmt->rowCount() == 0)
            redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري'.$_POST['title'].' - '.$_POST['details'].' - '.$_POST['date'].' - '.$_POST['eid'],'','default',100);
        $msg = '<div class="text-center">تمت العملية بنجاح</div>';
        redirectHome($msg,'?do=show_event','');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['regStudent'])){
        $check = regStudent($_POST['cid']);
        if($check == true){
            $msg = '<div class="text-center">تم تسجيل كل الطلبة بنجاح</div>';
            redirectHome($msg,'index.php','',1);
        }else
            redirectHome('لم يتم تسجيل كل الطلبة','index.php','default');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerStudent'])){
        $academic = selectData('*','academic_year','1 order by aid desc limit 1');
        if($academic == false)
            redirectHome('لا يوجد فصل دراسي','index.php','default');
        $error = 0;
        foreach($_POST as $key=>$value){
            $split = explode('_',$key);
            if(count($split) == 2 && is_numeric($split[1])){
                $check = selectData('*','reg_teacher','rtcourseId='.$split[1].' and rtacademicYear='.$academic['aid']);
                if($check != false){
                    $stmt = $con->prepare('update reg_teacher set rtteacherId=? where rtcourseId='.$split[1].' and rtacademicYear='.$academic['aid']);
                    $stmt->execute(array($value));

                }else{
                    $stmt = $con->prepare('insert into reg_teacher (rtteacherId,rtcourseId,rtacademicYear) values (?,?,?)');
                    $stmt->execute(array($value,$split[1],$academic[0]));
                }
                if($stmt->rowCount() > 0)
                    regStudent($split[1]);
                else
                    $error++;
            }
        }
        if($error != 0)
            redirectHome('عدد : '.$error,'index.php','default');
        $msg = '<div class="text-center">تمت العملية بنجاح</div>';
        redirectHome($msg,'index.php','');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewTeacher'])){
        $teacher_name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $ssn = $_POST['ssn'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $subject = $_POST['subject'];
        $stmt = $con->prepare("insert into user (`name`, `username`, `email`, `password`, `groupid`,`birthday`, `startdate`, `phone`,address, `ssn`,active,description) values (?,?,?,?,?,?,?,?,?,?,?,?)");
                $nameSplit = explode(' ',$_POST['name']);
                $username = $nameSplit[0];
                $password = sha1($_POST['password']);
                $date = date('Y-m-d');
                $stmt->execute(array($teacher_name,$username,$email,$password,2,$birthday,$date,$phone,$address,$ssn,1,$subject));
                if($stmt->rowCount() != 0){
                    $check1 = selectData('*','user','username="'.$username.'"');
                    if($check1 != false){
                        $stmt= $con->prepare('update user set username="'.$username.$check1['id'].'" where id='.$check1['id']);
                        $stmt->execute();
                    }
                }

        if($stmt->rowCount() == 0){
            echo "<h1>Something is error in database</h1>";
        }else{
            $msg = '<div class="text-center">تم الاضافة بنجاح</div>';
            redirectHome($msg,'?do=show_teacher','',1);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editCourseInfo'])){
        $check = selectData('*','course','cid='.$_POST['cid']);
        if($check == false)
            redirectHome('لا يمكن اتعديل .. هذا الاسم موجود مسبقا','?do=show_course','default');
        $check = selectData('*','course','cname="'.$_POST['courseName'].'" and clevel='.$check['clevel'].' and csemester='.$check['csemester']);
        if($check != false)
            redirectHome('لا يمكن اتعديل .. هذا الاسم موجود مسبقا','?do=show_course','default');
        $stmt = $con->prepare('UPDATE `course` SET `cname`=?WHERE `course`.`cid` = ?;');
        $stmt->execute(array($_POST['courseName'],$_POST['cid']));
        if($stmt->rowCount() != 0)    {
        $msg = '<div class="text-center">تم التعديل بنجاح</div>';
        redirectHome($msg,'?do=show_course','',1);
        exit();
        }else
            redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','?do=show_course','default');

    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editStudentDegreeFinal'])){
        print_r($_POST);
        $check = selectData('*','degreeType','dtid='.$_POST['dtid']);
        if($check != false){
            $count = 0;
            foreach($_POST as $key=>$value){
                if(is_numeric($key)){
                    $check = selectData('degree','degree','dtype='.$_POST['dtid'].' and dstudentId='.$key);
                    if($check == false){
                        $stmt = $con->prepare('insert into degree (dtype,dstudentId,degree) values (?,?,?)');
                        $stmt->execute(array($_POST['dtid'],$key,$value));
                        if($stmt->rowCount() == 0) $count++;
                    }else{
                        if($check['degree'] == $value)
                            continue;
                        $stmt = $con->prepare('update degree set degree=? where dtype=? and dstudentId=?');
                        $stmt->execute(array($value,$_POST['dtid'],$key));
                        if($stmt->rowCount()==0){
                           $count++;
                        }
                    }

                }
            }
            if($count != 0)
                redirectHome('لم يتم تسجيل التعديل لي '.$count.' طالب','?do=manage_student','default',1);
            else{
                $msg = '<div class="text-center">تم تسجيل هذه التعديلات بنجاح</div>';
                redirectHome($msg,'?do=manage_student','',1);
            }
        }else{
            redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','?do=manage_student','default',1);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSchedule'])){
        $schedule = selectData('*','schedule_name','snname="'.$_POST['name'].'" and snacademicYear in (select max(aid) from academic_year)');
        if($schedule == false){
            $academic = selectData('aid','academic_year','1 order by aid desc limit 1');
            if($academic == false)
                return 0;
            $stmt = $con->prepare('insert into schedule_name (snname,snacademicYear,sntype,sndate) values (?,?,?,?)');
            $stmt->execute(array($_POST['name'],$academic[0],$_POST['type'],date('Y-m-d')));
            if($stmt->rowCount() != 0){
                $schedule = selectData('*','schedule_name','1 order by snid desc limit 1');
            }else
                $schedule = false;
        }
        if($schedule != false){
            $error = 0;
            foreach($_POST as $key=>$value){
                $var = explode('-',$key);
                if(count($var) == 2 && is_numeric($var[0])){ // when type == دراسي
                    $day = $var[0];
                    $cid = $var[1];
                    if(!($value == null || $value == '')){
                        $check = isExist('schedule','scourseId='.$cid.' and sday='.$day.' and ssnid='.$schedule[0]);// for process the duplicate
                        if($check == false){
                            $check = isExist('schedule','sday='.$day.' and ssnid='.$schedule[0].' and stime="'.$value.'"');
                            // this check for not register the data that equal the data in database
                            if($check == true)
                                continue;
                            $stmt = $con->prepare('insert into schedule (ssnid,scourseId,sday,stime) values (?,?,?,?)');
                            $stmt->execute(array($schedule['snid'],$cid,$day,$value));
                            if($stmt->rowCount() == 0)
                                $error++;
                        }
                    }
                }

                else if(count($var) == 2 && !is_numeric($var[0]) && is_numeric($var[1])){ //when type != دراسي
                    $cid = $var[1];
                    if(!($value == null || $value == '')){
                            $check = selectData('*','schedule','ssnid='.$schedule[0].' and scourseId='.$cid.' limit 1');
                        if($check == false) echo 'false - '.$var[0].' - '.'ssnid='.$schedule[0].' and scourseId='.$cid.' and sdate="'.$value.'" limit 1';
                        if($check == false){
                            if($var[0] == 'date') $val = 'sdate';
                            else if($var[0] == 'time') $val = 'stime';
                            $stmt = $con->prepare('insert into schedule (ssnid,scourseId,'.$val.') values (?,?,?)');
                            $stmt->execute(array($schedule[0],$cid,$value));
                            echo '<- true ->';
                        }else{
                            if($var[0] == 'date') $val = 'sdate';
                            else if($var[0] == 'time') $val = 'stime';
                            echo ' not fine ';
                            if(isset($val)){
                                $stmt = $con->prepare('update schedule set '.$val.'="'.$value.'" where sid='.$check['sid']);
                                $stmt->execute();
                            }
                        }
                    }
                }
            }
            if($error == 0){
                $msg = '<div class="text-center">تمت العملية بنجاح</div>';
                redirectHome($msg,'?do=show_schedule','',100);
            }else
                redirectHome('لم تسجل بعض المواعيد'.$error,'?do=show_schedule','default',1);
        }else{
            redirectHome('حدث خطاء ما .. يرجي اعادة المحاولة مرة اخري','?do=add_schedule','default');
        }

    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editSchedule'])){
        $do = 'editSchedule';
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['showSchedule'])){
        $do = 'showSchedule';
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editScheduleFinal'])){
        $schedule = selectData('*','schedule_name','snid='.$_POST['snid']);
        if(!($schedule['snname'] == $_POST['name'] && $schedule['sntype'] == $_POST['type'])){
            $stmt = $con->prepare('update schedule_name set snname="'.$_POST['name'].'" , sntype=? where snid=?');
            $stmt->execute(array($_POST['type'],$_POST['snid']));
            if($stmt->rowCount() == 0)
                redirectHome('حدث خطاء ما .. يرجي اعادة المحاولة','?do=show_schedule','default',1);
        }
        $error = 0;
        foreach($_POST as $key=>$value){
            $var = explode('-',$key);
            if(count($var) == 2 && is_numeric($var[0])){
                $day = $var[0];
                $cid = $var[1];
                if(!($value == null || $value == '')){
                    $check = isExist('schedule','sday='.$day.' and ssnid='.$_POST['snid'].' and stime="'.$value.'"');
                    // this check for not register the data that equal the data in database
                    if($check == true)
                        continue;
                    $check = selectData('sid','schedule','ssnid='.$_POST['snid'].' and sday='.$day.' and scourseId='.$cid.' limit 1');
                    if($check == false){
                        $stmt = $con->prepare('insert into schedule (ssnid,scourseId,sday,stime) values (?,?,?,?)');
                        $stmt->execute(array($schedule['snid'],$cid,$day,$value));
                        if($stmt->rowCount() == 0)
                        $error++;
                    }else{
                        $stmt = $con->prepare('update schedule set stime="'.$value.'" where sid='.$check['sid']);
                        $stmt->execute();
                        if($stmt->rowCount() == 0)
                            $error++;
                    }

                }
            }
            else if(count($var)==2 && !is_numeric($var[0])){
                $cid = $var[1];
                $col = 's'.$var[0];
                if(!($value == null || $value == '')){
                    $data = selectData('*','schedule','ssnid='.$schedule['snid'].' and scourseId='.$cid);
                    if($data == false){
                        $stmt = $con->prepare('insert into schedule (ssnid,scourseId,'.$col.') values (?,?,?)');
                        $stmt->execute(array($schedule['snid'],$cid,$value));
                        if($stmt->rowCount() == 0) $error++;
                    }else{
                        $stmt = $con->prepare('update schedule set '.$col.'=? where sid=?');
                        $stmt->execute(array($value,$data['sid']));
                        if($stmt->rowCount() == 0 && $data[$col] != $value) $error++;
                    }
                }
            }
        }
        if($error == 0){
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'?do=show_schedule','',1);
        }else
            redirectHome('لم يتم تسجيل بعض الطلبة');

    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteSchedule'])){
        $check = deleteData('schedule_name','snid='.$_POST['snid']);
        if(check == true){
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'?do=show_schedule','',1);
        }else
            redirectHome('حدث خطاء اثناء الحذف يرجي اعادة المحاولة','?do=show_schedule','default');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addAbsence'])){
        if($_POST['date'] > date('Y-m-d')) // that condition for make sure this date not in the feature  .. that is the point
            redirectHome('هذا التاريخ لا يمكن التسجيل .. يرجي المحاولة','','default');
        else{
            $adid = selectData('*','absence_day','adacademicYear in (select max(aid) from academic_year) and day="'.$_POST['date'].'" limit 1');
            $error = 0;
            if($adid == false){
                $aid = selectData('max(aid)','academic_year','1');
                $stmt = $con->prepare('insert into absence_day (day,adacademicYear) values (?,?)');
                $stmt->execute(array($_POST['date'],$aid['max(aid)']));
                if($stmt->rowCount() > 0)
                    $adid = selectData('*','absence_day','adacademicYear in (select max(aid) from academic_year) and day="'.$_POST['date'].'" limit 1');
                foreach($_POST as $key=>$value){
                    if(is_numeric($key)){
                        $check = isExist('absence','aadid='.$adid['adid'].' and abstudentId='.$key);
                        if($check == true)
                            continue;
                        $stmt = $con->prepare('insert into absence (aadid,abstudentId) values (?,?)');
                        $stmt->execute(array($adid['adid'],$key));
                        if($stmt->rowCount() ==0)
                           $error++;
                    }
                }
            }

            if($error == 0){
                $msg = '<div class="text-center">تمت العميلة بنجاح</div>';
                redirectHome($msg,'?do=manage_student',$goBack,1);
            }else{
                redirectHome('لم يتم تسجيل بعض الطلبة '.$error.' .. يرجي اعادة المحاولة',$goBack,'default');
            }
        }

    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_absence'])){
        if(deleteData('absence_day','adid='.$_POST['adid'])){
            $msg = '<div class="text-center">تم الحذف بنجاح</div>';
            redirectHome($msg,'?do=manage_student#absence','',1);
        }else
            redirectHome('لم يتم الحذف .. يرجي المحاولة مرة اخري','?do=manage_student#absence','default');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['show_absence'])||isset($_POST['edit_absence']))){
        if(isset($_POST['edit_absence']))
            $do = 'edit_absence';
        else if(isset($_POST['show_absence']))
            $do = 'show_absence';
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_absenceFinal'])){
        print_r($_POST);
        if(!isExist('absence_day','adid='.$_POST['adid'].' and day="'.$_POST['date'].'"')){
            $stmt = $con->prepare('update absence_day set day=? where adid=?');
            $stmt->execute(array($_POST['date'],$_POST['adid']));
            if($stmt->rowCount() == 0){

            }
        }
        $check = deleteData('absence','aadid='.$_POST['adid']);
        $check2 = isExist('absence','aadid='.$_POST['adid']);
        if($check == false && $check2==true){
            redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','?do=manage_student#absence','default');
        }
        $error =0;
        foreach($_POST as $key=>$value){
            if(is_numeric($key)){
                $stmt = $con->prepare('insert into absence (aadid,abstudentId) values (?,?)');
                $stmt->execute(array($_POST['adid'],$key));
                if($stmt->rowCount() ==0)
                   $error++;
                echo $_POST['adid'].' - '.$key;
            }
        }if($error == 0){
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'?do=manage_student#absence','',1);
        }else{
            redirectHome('هناك عدد من الطلبة لم يسجلو بعد','?do=manage_student#absence','default');
        }
    }
    //here will make edit and remove semester ...
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editSemester'])){ // for edit semester  .. just be carefull
        $stmt = $con->prepare('select * from academic_year where aid = ?');
        $stmt->execute(array($_POST['idSemester']));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            $yearNow = date('Y');
            $msg = '<div class="editSemester">
                        <form action="index.php" method="post">
                            <input type="text" name="name" class="form-control" value="'.$row['yearId'].'">
                            <input type="hidden" value="'.$_POST['idSemester'].'" name="idSemester">
                            <input type="submit" name="editFinalSemester" class="btn btn-primary form-control" value="اتمام التعديل">
                        </form>
                    </div>
            ';
            redirectHome($msg,'','d',200);

        }else
            redirectHome($msg,'','default');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['editCourse']) || isset($_POST['deleteCourse']))){
        if(isset($_POST['deleteCourse'])){
            $stmt = $con->prepare('delete from course where cid=?');
            $stmt->execute(array($_POST['cid']));
            if($stmt->rowCount()>0){
                $msg = '<div class="text-center">تم حذف المادة</div>';
                redirectHome($msg,'?do=show_course','',1);
            }else
                redirectHome('حدث خطاء ما في حذف المادة','?do=show_course','default');
        }else{
            $do = 'edit_course';
            $cid = $_POST['cid'];
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewCourse'])){ // addCourse ==> if
        $name = $_POST['courseName'];
        $code = $_POST['code'];
        $classes = $_POST['classes'];
        $semester = $_POST['semester'];
        $stmt = $con->prepare('select cname from course where cname=? and clevel=? and csemester=?');
        $stmt->execute(array($name,$classes,$semester));
        if($stmt->rowCount() > 0)
            redirectHome('هذه البيانات موجودة في المادة مسبقا','?do=addCourse','default');
        else{
            $stmt = $con->prepare('insert into course (cname,clevel,csemester,ccode) values (?,?,?,?)');
            $stmt->execute(array($name,$classes,$semester,$code));
            if($stmt->rowCount() > 0){
                $msg = '<div class="text-center">تم تسجيل المادة بنجاح</div>';
                redirectHome($msg,'?do=show_course','',1);
            }else
                redirectHome('حدث خظاء ما .. لم يتم الاضافة , يرجي اعادة المحاولة');
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editFinalSemester'])){ // that will follow more steps to edit .. this second step and final step too
        $check = selectData('*','academic_year','aid='.$_POST['idSemester'].' and yearId="'.$_POST['name'].'"');
        if($check != false){
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'','d',1);
        }
        $stmt = $con->prepare('update academic_year set yearId=? where aid=?');
        $stmt->execute(array($_POST['name'],$_POST['idSemester']));
        if($stmt->rowCount() > 0){
            $msg = '<div class="text-center">تمت العملية بنجاح</div>';
            redirectHome($msg,'','d',1);
        }else
            redirectHome('حدث خطاء ما .. يرجي المحاولة مرة اخري','index.php','default');
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['removeSemester'])){ // for delete this semester .. final from database ..
        $id = $_POST['idSemester'];
        $stmt = $con->prepare('delete from academic_year where aid=?');
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $msg = '<div class="text-center">'.$id.' تم ازلة الترم بنجاح</div>';
            redirectHome($msg,'','d',1);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewYear'])){ //for setting button add new year

    }

    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editStudent'])){ // Edit Student and Teacher ..
        print_r($_POST);
        if(isset($_POST['description'])){ // for teacher
            if(isset($_POST['password']) && $_POST['password'] != '' || $_POST['password'] != null)
                $password= ',password="'.sha1($_POST['password']).'"';
            else $password = '';
            $stmt = $con->prepare('update user set name=?,username=?,email=?,phone=?,address=?,active=?,birthday=?,ssn=? , description=?'.$password.' where id=? and groupId =2');
            $stmt->execute(array($_POST['name'],$_POST['username'],$_POST['email'],$_POST['phone'],$_POST['address'],$_POST['active'],$_POST['birthday'],$_POST['ssn'],$_POST['description'],$_POST['id']));
            if(isset($_POST['admin'])){
                if($_POST['admin'] == 1){
                    $stmt = $con->prepare('insert into admin (teacherId) values ('.$_POST['id'].')');
                    $stmt->execute();
                }else{
                    $stmt = $con->prepare('delete from admin where teacherId='.$_POST['id']);
                    $stmt->execute();
                }
            }
        }
        else{ // for student
            if(isset($_POST['password']) && $_POST['password'] != '' || $_POST['password'] != null)
                $password= ',password="'.sha1($_POST['password']).'"';
            else $password = '';
            $level = date('Y')-$_POST['level']+1;
            print_r($_POST);
            echo $level;
            $stmt = $con->prepare('update user set name=?,username=?,email=?,phone=?,address=?,active=?,birthday=?,regdate=?,ssn=?'.$password.' where id=? and groupId =1');
            $stmt->execute(array($_POST['name'],$_POST['username'],$_POST['email'],$_POST['phone'],$_POST['address'],$_POST['active'],$_POST['birthday'],$level,$_POST['ssn'],$_POST['id']));
        }
        if($stmt->rowCount() > 0){
            $msg = '<div class="text-center">تم التعديل</div>';
            $url = isset($_POST['description'])?'?do=show_teacher':'?do=show_student?'.$level;
            redirectHome($msg,$url,'',1);
        }
        else
            echo '';
    }
    else if(isset($_GET['do'])&& ($_GET['do'] == 'remove_student' || $_GET['do'] == 'remove_teacher') && isset($_GET['id'])){
        $id = is_numeric($_GET['id'])?$_GET['id']:0;
        $stmt = $con->prepare('delete from user where id=?');
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $check = selectData('*','parent','studentId='.$id);
            if($check != false){
                $stmt = $con->prepare('delete from user where id='.$check['parentId']);
                $stmt->execute();
            }

            $msg = '<h3 class="text-center">تم الحذف بنجاح</h3>';
            if($_GET['do'] == 'remove_student')
                redirectHome($msg,'index.php?do=show_student','',1);
            else
                redirectHome($msg,'index.php?do=show_teacher','',1);
        }else{
            redirectHome(' ** خطاء في البيانات **','index.php?do=show_student');
        }
    }

}else{
    print_r($_SESSION);
    header('Location: login.php');
    exit();
}

?>
<body>

    <!-------- satrt body conatainer ------------>
<section class="Content">
  <div class="row">
    <?php include $tpl.'aside.php';?>
        <!-----end side_nav -------->
<?php
      if($do == 'main_page'){
?>
<div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
               <li class="page-back">
               <a href="index.php"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#"> اللوحه الام</a>
             </li>
             <li>
                 <a href="index.php?do=main_page"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
        <div class="sb2-2-1">
                    <h2>اللوحه الام </h2>
                    <p>تضيف فئة الجدول التصميم الأساسي (حشو الضوء والفواصل الافقيه فقط) إلى جدول:</p>
                    <div class="db-2">
                        <ul>
                            <?php
                                $stmt = $con->prepare("select count(*) from user where groupid=1");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                $studentCount = $row['count(*)'];
                                $stmt = $con->prepare("select count(*) from course");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                $courseCount = $row['count(*)'];
                                $stmt = $con->prepare("select count(*) from user where groupid=2");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                $teacherCount = $row['count(*)'];
                                $countEvent = selectData('count(*)','event','1');
                            ?>
                            <li>
                                <div class="dash-book dash-b-1">
                                    <h5> المواد </h5>
                                    <h4><?php echo $courseCount;?></h4>
                                    <a href="#">View more</a>
                                </div>

                            </li>
                            <li>
                                <div class="dash-book dash-b-2">
                                    <h5>المدرسين</h5>
                                    <h4><?php echo $teacherCount;?></h4>
                                    <a href="#">View more</a>
                                </div>
                            </li>
                            <li>
                                <div class="dash-book dash-b-3">
                                    <h5>الطلاب </h5>
                                    <h4><?php echo $studentCount;?></h4>
                                    <a href="#">View more</a>
                                </div>
                            </li>
                            <li>
                                <div class="dash-book dash-b-4">
                                    <h5>الفعاليات</h5>
                                    <h4><?php echo $countEvent[0];?></h4>
                                    <a href="#">View more</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
       </div>
        <div class="semester">
            <div class="card">
                  <div class="card-header text-center">السنة الدراسية</div>
                  <div class="card-body">
                      <?php
                            $row = selectData('*','academic_year','1 order by aid desc limit 2',1);
                            if($row != false){
                                $counter = 1;
                                $rr = 0;
                                foreach($row as $r){
                                   if($rr != 0 && $rr['checked'] != $r['checked'])
                                       continue;
                                    if($counter == 1){
                                        echo '<div class="row main-name">';
                                            echo '<div class="col text-center">';
                                                echo 'اسم الترم';
                                            echo '</div>';
                                            echo '<div class="col text-center">';
                                                echo 'السنة';
                                            echo '</div>';
                                            echo '<div class="col text-center">';
                                                echo 'الترم';
                                            echo '</div>';
                                            echo '<div class="col text-center">';
                                                echo 'تعديل';
                                            echo '</div>';
                                        echo '</div>';
                                        $rr = $r;
                                    }
                                    //data is below ..
                                    echo '<div class="row">';
                                        ?>
                                            <form action="index.php?do=show_semester" method="post" class="col text-center">
                                                <input type="hidden" name="aid" value="<?php echo $r['aid'];?>">
                                                <input type="hidden" name="semester" value="<?php echo $r['semester'];?>">
                                                <input type="submit" name="infoSemester" class="semester-link" value="<?php echo $r['yearId'];?>">
                                            </form>
                                        <?php
                                        echo '<div class="col text-center">';
                                            echo $r['year'];
                                        echo '</div>';
                                        echo '<div class="col text-center">';
                                            echo $r['semester'];
                                        echo '</div>';
                                        echo '<div class="col text-center">';
                                            echo '<form action="index.php" method="post">';
                                                echo '<input type="hidden" name="idSemester" value="'.$r['aid'].'">';
                                                echo '<input type="submit" class="btn btn-success" value="تعديل" name="editSemester">';
                                                echo '<input type="submit" class="btn btn-danger" value="حذف" name="removeSemester"></form>';
                                        echo '</div>';
                                    echo '</div>';
                                    $counter++;
                                }
                                if($counter == 2){ //for button to add the second semester and will appear when you have only the first semester.
                                    echo '<form action="index.php?do=add_semester" method="post">';
                                    echo '<input type="hidden" name="noSteps" value="1">';
                                    echo '<input type="hidden" name="ssemester" value="2">';
                                    echo '<input class="btn btn-primary text-center secondSemester" type="submit" name="addNewSemester" value="اضافة ترم الثاني"> </form>';
                                }else if($counter >=3){ // for add button to add new study year
                                    echo '<form action="index.php?do=add_semester" method="post">';
                                     echo '<input type="hidden" name="noSteps" value="1">';
                                    //echo '<input type="hidden" name="ssemester" value="1">';
                                    echo '<input class="btn btn-primary text-center secondSemester" type="submit" name="addNewSemester" value="اضافة سنة دراسة جديد"> </form>';
                                }

                            }else{ // we will add new semester here
                                ?>
                                    <div class="add-semester">
                                        <form action="index.php?do=add_semester" method="post">
                                            <input type="hidden" name="noSteps" value="1">
                                            <input type="submit" name="addNewSemester" class="btn btn-primary form-control" value="اضافة ترم جديد">
                                        </form>
                                    </div>
                                <?php

                            }
                      ?>
                  </div>
            </div>
        </div>
    </div>

<?php
      }
      else if($do == 'show_event'){
          ?>
      <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">الفعاليات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>عرض الفعاليات</h4>
            </div>
            <!--Start Body Of This Section-->

            <div class="manageEvent">
                    <div class="filter row"><!--Academic Year => semester .. -->
                        <form action="index.php?do=show_event" method="post">
                            <select name="academicYear1" class="form-control academicYear filter-selection">
                                <?php
                                    $semester = selectData('*','academic_year',' 1  order by aid desc',1);
                                    if ($semester == false){
                                        echo '<option class="text-center" value="0">لا توجد ترم لعرضة </option>';
                                    }else{
                                        $academic1 = isset($_POST['academicYear1'])?$_POST['academicYear1']:0;
                                        foreach($semester as $s){
                                            echo '<option value="'.$s['aid'].'"';
                                            if($academic1 != 0 && $academic1 == $s['aid'])
                                                echo 'selected';
                                            echo '>'.$s['yearId'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <a href="?do=add_event" class="btn btn-primary">اضافة الفعاليات</a>
                        </form>
                    </div>
                    <hr>
                    <div class="listOfAbsence">
                        <?php
                        if(isset($academic1) && $academic1 == 0)
                            $academic1 = $semester[0]['aid'];
                        if(!isset($academic1))
                            $academic1 = 0;
                        $absence = selectData('*','event','eacademicYear='.$academic1.' order by edate desc',1);
                        if($absence != false){
                            ?>
                        <table class="table">
                            <thead>
                                <th scope="col">رقم</th>
                                <th scope="col">العنوان</th>
                                <th scope="col">التاريخ</th>
                                <th scope="col">التعديل</th>
                            </thead>
                            <tbody>
                                <?php
                                $count=1;
                                foreach($absence as $b){
                                    echo '<tr>';
                                        echo '<td>'.$count.'</td>';
                                        echo '<td>'.$b['title'].'</td>';
                                        echo '<td>'.$b['edate'].'</td>';
                                        echo '<td>';
                                            echo '<form action="index.php" method="post" class="editButton">';
                                                echo '<input type="hidden" name="eid" value="'.$b['eid'].'">';
                                                echo '<input type="submit" name="showEvent" value="عرض" class="btn btn-info">';
                                                echo '<input type="submit" name="edit_event" value="تعديل" class="btn btn-success">';
                                                echo '<input type="submit" name="delete_event" value="حذف" class="btn btn-danger">';
                                            echo '</form>';
                                        echo '</td>';
                                    echo '</tr>';
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo '<h3 class="text-center alert alert-info">لم يتم تسجيل الفعاليات الي هذا الترم</h3>';
                        }
                        ?>
                    </div>
                </div>
            <!--End Body Of This Section-->
          </div>

        </div>




    </div>
      </div>
      <?php
      }
       else if($do == 'showEvent' && isset($_POST['eid'])){
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">عرض الفعاليات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add sub23">
           <div class="titel">
             <h4>عرض الفعاليات</h4>
               <form action="index.php?do=regEvent" method="post">
                    <input type="hidden" name="eid" value="<?php echo $_POST['eid'];?>">
                   <input type="submit" name="regEvent" value="تسجيل في الحدث" class="btn btn-primary">
               </form>
            </div>
            <!--Start Body Of This Section-->
            <?php
            $academic = selectData('*','academic_year','1 order by aid desc limit 1');
            if($academic != false){
                $event = selectData('*','event','eid='.$_POST['eid']);
                $regEvent = selectData('id','event,reg_event,user','reevent=eid and reuser=id and eid='.$_POST['eid'].' order by edate desc',1);
                if($regEvent==false) $val = 0; else $val = count($regEvent);
                if($event != false){
                    ?>
                    <h1 class="text-center">الحدث</h1>
                    <div class="eventInfo">
                        <span><span>عدد المسجلين : </span><?php echo $val;?></span>
                        <span><span>التفعيل : </span><?php if($event['edate'] > date('Y-m-d')) echo 'غير نشط'; else echo 'نشط'?></span>
                    </div>
                    <div class="eventDetails">
                        <h5>العنوان</h5>
                        <p><?php echo $event['title']?></p>
                        <h5>التفاصيل</h5>
                        <p><?php echo $event['details'];?></p>

                    <?php
                    if($regEvent != false){
                            ?>
                            <table class="table">
                                    <thead>
                                        <th scope="col">رقم</th>
                                        <th scope="col">رقم الهوية</th>
                                        <th scope="col">الاسم</th>
                                        <?php if($event['register'] == 0) echo '<th scope="col">نوع المستخدم</th>';?>
                                        <th scope="col">تاريخ</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $c = 1;
                                        if($event['register'] == 0){
                                            for($v=1;$v != 4;$v++){
                                            if($event['register'] == 0)
                                                $user = selectData('name,id,eid,redate,groupid','event,reg_event,user','reevent=eid and reuser=id and eid='.$_POST['eid'].' and groupid='.$v.' order by reid desc',1);
                                            else $user = selectData('name,id,eid,edate,redate','event,reg_event,user','reevent=eid and eid='.$_POST['eid'].' and reuser=id order by edate desc',1);
                                            if($user!=false){
                                                foreach($user as $r){
                                                    echo '<tr ';
                                                    if($c%2==0)
                                                        echo 'class="even"';
                                                    echo '>';
                                                        echo '<td>'.$c.'</td>';
                                                        echo '<td>'.$r['id'].'</td>';
                                                        echo '<td>'.$r['name'].'</td>';
                                                        if($event['register'] == 0){
                                                            if($r['groupid'] == 1)
                                                                $val = 'طالب';
                                                            else if($r['groupid'] == 2)
                                                                $val = 'مدرس';
                                                            else if($r['groupid'] == 3)
                                                                $val = 'ولي امر';
                                                            else
                                                                $val = 'غير';
                                                            echo '<td>'.$val.'</td>';
                                                        }
                                                        echo '<td>'.$r['redate'].'</td>';
                                                    echo '</tr>';
                                                    $c++;
                                                }
                                            }
                                        }
                                        }else{
                                            $user = selectData('name,id,eid,edate,redate','event,reg_event,user','reevent=eid and eid='.$_POST['eid'].' and reuser=id order by edate desc',1);
                                            if($user!=false){
                                                foreach($user as $r){
                                                    echo '<tr ';
                                                    if($c%2==0)
                                                        echo 'class="even"';
                                                    echo '>';
                                                        echo '<td>'.$c.'</td>';
                                                        echo '<td>'.$r['id'].'</td>';
                                                        echo '<td>'.$r['name'].'</td>';
                                                        if($event['register'] == 0){
                                                            if($r['groupid'] == 1)
                                                                $val = 'طالب';
                                                            else if($r['groupid'] == 2)
                                                                $val = 'مدرس';
                                                            else if($r['groupid'] == 3)
                                                                $val = 'ولي امر';
                                                            else
                                                                $val = 'غير';
                                                            echo '<td>'.$val.'</td>';
                                                        }
                                                        echo '<td>'.$r['redate'].'</td>';
                                                    echo '</tr>';
                                                    $c++;
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                        <?php
                    }else
                        echo '<h4 class="text-center alert alert-info">لم يتم تسجيل اي مستخدم حتي الان</h4>';
                    ?></div><?php
                }else
                    echo '<h4 class="text-center alert alert-info">لا توجد فعاليات مسجلة</h4>';
            }else
                echo '<h4 class="text-center alert alert-info">لا توجد فعاليات مسجلة</h4>';
            ?>
            <!--End Body Of This Section-->
          </div>
        </div>
    </div>
      </div>
           <?php
      }
      else if(isset($_POST['regEvent']) && $do == 'regEvent'){
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">تسجيل الحدث</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>تسجيل الحدث</h4>
            </div>
            <!--Start Body Of This Section-->
            <div class="registerEvent sub23">
                <?php
                $event = selectData('*','event','eid='.$_POST['eid']);
                if($event != false){
                    echo '<h4 class="text-center">'.$event['title'].'</h4>';
                    ?>
                <form action="index.php?do=regEvent" method="post">
                    <input type="hidden" name="eid" value="<?php echo $_POST['eid'];?>">
                    <input type="hidden" name="regEvent">
                    <input type="search" class="form-control search" name="search_user" placeholder="البحث بالاسم او بارقم الهوية">

                <?php
                    if(isset($_POST['search_user'])&&$_POST['search_user'] != ''){
                        if($event['register'] != 0) $val = 'groupid='.$event['register'].' and';
                        else $val = '';
                        if(is_numeric($_POST['search_user']))
                            $search = selectData('*',$val.'user','id='.$_POST['search_user'],1);
                        else
                            $search = selectData('*','user',$val.'name like "%'.$_POST['search_user'].'%" order by name',1);
                        if($search != false){
                            ?>
                            <table class="table">
                                <thead>
                                    <th scope="col">رقم</th>
                                    <th scope="col">رقم الهوية</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">الاختيار</th>
                                </thead>
                                <tbody>
                                <?php
                                    $c = 1;
                                    foreach($search as $s){
                                        echo '<tr>';
                                            echo '<td>'.$c.'</td>';
                                            echo '<td>'.$s['id'].'</td>';
                                            echo '<td>'.$s['name'].'</td>';
                                            echo '<td>
                                            <form action="index.php?do=regEvent" method="post">
                                                <input type="hidden" name="eid" value="'.$_POST['eid'].'">
                                                <input type="hidden" name="user" value="'.$s['id'].'">
                                                <input type="hidden" name="regEvent">
                                                <input type="submit" name="selectUser" value="الاختيار">
                                            </form>
                                            </td>';
                                        echo '</tr>';
                                        $c++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }else
                            echo '<h4 class="text-center alert alert-success">لا يوجد طالب بهذا الاسم "'.$_POST['search_user'].'"</h4>';
                    }else{
                        $regEvent = selectData('*','event,reg_event,user','reevent=eid and reuser=id and eid='.$_POST['eid'].' order by edate desc',1);
                        if($regEvent != false){
                            ?>
                            <table class="table">
                                <thead>
                                    <th scope="col">رقم</th>
                                    <th scope="col">رقم الهوية</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">تاريخ</th>
                                    <?php if($event['register'] == 0) echo '<th scope="col">نوع المستخدم</th>';?>
                                </thead>
                                <tbody>
                                    <?php
                                    $c = 1;
                                    foreach($regEvent as $r){
                                        echo '<tr ';
                                            if($c%2 == 0)
                                                echo 'class="even"';
                                        echo '>';
                                            echo '<td>'.$c.'</td>';
                                            echo '<td>'.$r['id'].'</td>';
                                            echo '<td>'.$r['name'].'</td>';
                                            echo '<td>'.$r['redate'].'</td>';
                                        if($event['register'] == 0){
                                            if($r['groupid'] == 1)
                                                $val = 'طالب';
                                            else if($r['groupid'] == 2)
                                                $val = 'مدرس';
                                            else if($r['groupid'] == 3)
                                                $val = 'ولي امر';
                                            else
                                                $val = 'غير';
                                            echo '<td>'.$val.'</td>';
                                        }
                                        echo '</tr>';
                                        $c++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }else
                            echo '<h4 class="text-center alert alert-warning">لا يوجد مستخدمين مسجلين في هذه الحدث</h4>';
                    }
                    ?>
                </form>
                    <?php
                }else
                    echo '<h4 class="text-center alert alert-danger">لا توجد فعالية هنا</h4>';
                ?>
            </div>
            <!--End Body Of This Section-->
          </div>
        </div>
    </div>
      </div>
           <?php
      }
      else if($do == 'add_semester' && isset($_POST['addNewSemester'])){
          ?>
          <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
                <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">اضافة ترم</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
               <h4>اضافة ترم جديد</h4>
            </div>
            <!--Start Course Body-->
            <div class="profile">
                <div class="semesterForm">
                    <?php
                    $var = 1;
                    if(isset($_POST['ssemester']))
                        $var = 2;
                    $step = $_POST['noSteps'];
                    if($step==1){
                        if($var == 2)
                            $check = selectData('*','academic_year','semester='.$var.' order by aid desc limit 1');
                        else $check = false;
                        if($check == false){
                        ?>
                        <div class="card">
                            <div class="card-header text-center">اضافة ترم</div>
                            <div class="card-body">
                                <form action="index.php?do=add_semester" method="post">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="yearId" placeholder="اسم الترم" required>
                                        </div>
                                        <div class="col">
                                            <select name="semester" class="form-control">
                                                <?php if($var == 1) echo '<option value="1" selected>الترم الاول</option>';
                                                else if($var == 2) echo '<option value="2" selected>الترم الثاني</option>';?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="noSteps" value="2">
                                    <input type="submit" name="addNewSemester" value="الخطوة التالي" class="btn btn-primary">
                                </form>
                            </div>
                        </div>

                    <?php
                        }else
                            echo '<h4 class="text-center alert alert-warning">لا يمكن تكرار هذا الفصل الدراسي</h4>';
                    }
                    else if($step == 2){
                        ?>
                            <div class="addTeacherToCourse">
                                <div class="card">
                                    <div class="card-header text-center">اضافة المواد الي المدرسين</div>
                                    <div class="card-body">
                                        <form action="index.php?do=add_semester" method="post">
                                            <input type="hidden" name="semester" value="<?php echo $_POST['semester']?>">
                                            <input type="hidden" name="yearId" value="<?php echo $_POST['yearId']?>">
                                        <div class="profileTab">

                              <?php
                                  // for all class and get info about it ..
                                    echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                                    for($count=1;$count<=6;$count++){
                                        $idBody = 'class'.$count;
                                        $idNav = 'class-tab'.$count;
                                        $var = $count==1? 'active':'';
                                        echo  '<li class="nav-item">';
                                            echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                            echo printClass($count);
                                            echo '</a>';
                                        echo '</li>';
                                    }
                                    echo '
                                        </ul>
                                        <div class="tab-content content" id="myTabContent">
                                    ';
                                    for($count=1;$count<=6;$count++){
                                        $idBody = 'class'.$count;
                                        $idNav = 'class-tab'.$count;
                                        $var = $count==1?'show active':'';
                                        echo '
                                            <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                            ?>
                                            <?php
                                                $stmt = $con->prepare('select * from course where clevel=? and csemester=?');
                                                $stmt->execute(array($count,$_POST['semester']));
                                                $rows = $stmt->fetchAll();
                                                if($stmt->rowCount() >0){
                                                    ?>
                                                    <table class="table">
                                                        <thead>
                                                             <tr>
                                                                <th scope="col">المادة</th>
                                                                <th scope="col">المدرس</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    foreach($rows as $r){
                                                        $stmt = $con->prepare('select * from user where groupid=2 ');
                                                        $stmt->execute();
                                                        $teachers = $stmt->fetchAll(); //to get name of teacher
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $r['cname'];?></td>
                                                                    <td>
                                                                        <select name="teacherAndCourse-<?php echo $count.'-'.$r['cid'];?>" class="form-control">
                                                                            <option value="0" disabled selected></option>
                                                                            <?php
                                                                            foreach($teachers as $t){
                                                                                echo '<option value="'.$t['id'].'">';
                                                                                    echo $t['name'].' -> '.$t['description'];
                                                                                echo '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>

                                                                </tr>
                                                            <?php
                                                    }?>
                                                     </tbody>
                                            </table>
                                                <?php
                                                }else{
                                                    echo '<h1 class="text-center">لم تسجل مواد الي هذا الصف بعد</h1>';
                                                }
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                ?>
                        </div>
                                            <input type="hidden" name="noSteps" value="3">
                                            <input type="submit" name="addNewSemester" class="btn btn-primary" value="اضافة ترم">
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php
                    }

                    ?>


                </div>
            </div>
            <!--End Course Body-->
          </div>

        </div>
    </div>
      </div>
      <?php
      }
      else if($do == 'show_semester' && isset($_POST['infoSemester'])){
          $acid = $_POST['aid'];
          $semester = $_POST['semester'];
          ?>
          <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">الترم</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>عرض معلومات عن الترم</h4>
            </div>
            <!--Start Course Body-->
            <div class="profile">
                <?php
                $academic = selectData('*','academic_year','1 order by aid desc limit 1');
                if($acid == $academic['aid']){
                    echo '<a href="?do=register" class="text-center btn btn-primary btn-center">تسجيل الطلاب</a>';
                }
                ?>
                <div class="profileTab">

                          <?php
                              // for all class and get info about it ..


                                echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1? 'active':'';
                                    echo  '<li class="nav-item">';
                                        echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                        echo printClass($count);
                                        echo '</a>';
                                    echo '</li>';
                                }
                                echo '
                                    </ul>
                                    <div class="tab-content content" id="myTabContent">
                                ';
                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1?'show active':'';
                                    echo '
                                        <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                        ?>
                                        <?php
                                            $stmt = $con->prepare('select * from course where clevel=? and csemester=?');
                                            $stmt->execute(array($count,$semester));
                                            $rows = $stmt->fetchAll();
                                            if($stmt->rowCount() >0){
                                                ?>
                                                <table class="table">
                                                    <thead>
                                                         <tr>
                                                            <th scope="col">المادة</th>
<!--                                                             <th scope="col">الترم</th>-->
                                                            <th scope="col">المدرس</th>
                                                            <th scope="col">عدد الطلاب</th>
                                                            <th scope="col">تعديل</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                <?php
                                                $academic = selectData('*','academic_year','1 order by aid desc limit 1');
                                                if($academic == false) $academic[] = 0;
                                                foreach($rows as $r){
                                                    //So, i need data count of student -- name of teacher -- id
                                                    $stmt = $con->prepare('select count(studentId) from reg_course where courseId=? and academicYear='.$academic[0]);
                                                    $stmt->execute(array($r['cid']));
                                                    $countStudtent = $stmt->fetch(); // count student --> done
                                                    $stmt = $con->prepare('select name,clevel from reg_teacher,user,course,academic_year where rtteacherId=id and rtcourseId=cid and rtacademicYear=aid and rtacademicYear=? and rtcourseId=?');
                                                    $stmt->execute(array($acid,$r['cid']));
                                                    $teacher = $stmt->fetch(); // name teacher that teach this course --> done
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $r['cname'];?></td>
                                                                <td><?php if($stmt->rowCount() > 0) echo $teacher['name'];else echo 'لا';?></td>
                                                                <td><?php echo $countStudtent['count(studentId)'];?></td>
                                                                <td>
                                                                    <form action="index.php" method="post" class="editButton">
                                                                        <input type="hidden" name="cid" value="<?php echo $r['cid'];?>">
                                                                        <?php
                                                                        $date = date('Y')-$teacher['clevel']+1;
                                                                        $cdata = selectData('count(*)','user','groupid=1 and regdate='.$date);
                                                                        if($cdata[0] > $countStudtent['count(studentId)']){
                                                                            echo '<input type="submit" name="regStudent" value="التسجيل للطلاب" class="btn btn-info">';
                                                                        }
                                                                        else if($cdata[0] < $countStudtent['count(studentId)']){
                                                                            $notActive = selectData('*','user','groupId=1 and active=0 and regdate='.$date,1);
                                                                            foreach($notActive as $na){
                                                                                $check = selectData('*','reg_course','academicYear in (select max(aid) from academic_year) and courseId='.$r['cid'].' and studentId='.$na['id'].' limit 1');
                                                                                if($check != false){
                                                                                    deleteData('reg_course','rid='.$check['rid']);
                                                                                }
                                                                            }
                                                                            echo '<div class="btn alert alert-info">تم التسجيل</div>';
                                                                        }
                                                                        else if($cdata[0] == 0 && $countStudtent[0]==0)
                                                                            echo '<div class="btn alert alert-danger">لم يتم التسجيل</div>';
                                                                        else{
                                                                            echo '<div class="btn alert alert-info">تم التسجيل</div>';
                                                                        }
                                                                        ?>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                }?>
                                                 </tbody>
                                        </table>
                                            <?php
                                            }else{
                                                echo '<h1 class="text-center">لم تسجل مواد الي هذا الصف بعد</h1>';
                                            }
                                    echo '</div>';
                                }
                                echo '</div>';
                            ?>
                    </div>

                </div>
            <!--End Course Body-->
          </div>

        </div>
    </div>
      </div>
      <?php
      }
     else if($do == 'register'){
         ?>
      <div class="col-sm-9 details editStudent">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
                <a href="#">تسجيل الطلاب</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel" id="editStudentid">
                <h4>تسجيل الطلاب</h4>
            </div>
                <div class="addTeacherToCourse">
        <div class="card">
            <div class="card-header text-center">اضافة المواد الي المدرسين</div>
            <div class="card-body">
                <?php
                $academic = selectData('*','academic_year','1 order by aid desc limit 1');
                if($academic != false){
                    ?>
                <form action="index.php?do=index.php" method="post">
                <div class="profileTab">

      <?php
          // for all class and get info about it ..
            echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
            for($count=1;$count<=6;$count++){
                $idBody = 'class'.$count;
                $idNav = 'class-tab'.$count;
                $var = $count==1? 'active':'';
                echo  '<li class="nav-item">';
                    echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                    echo printClass($count);
                    echo '</a>';
                echo '</li>';
            }
            echo '
                </ul>
                <div class="tab-content content" id="myTabContent">
            ';
            for($count=1;$count<=6;$count++){
                $idBody = 'class'.$count;
                $idNav = 'class-tab'.$count;
                $var = $count==1?'show active':'';
                echo '
                    <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                    ?>
                    <?php
                        $stmt = $con->prepare('select * from course where clevel=? and csemester=?');
                        $stmt->execute(array($count,$academic['semester']));
                        $rows = $stmt->fetchAll();
                        if($stmt->rowCount() >0){
                            ?>
                            <table class="table">
                                <thead>
                                     <tr>
                                        <th scope="col">المادة</th>
                                        <th scope="col">المدرس</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            foreach($rows as $r){
                                $stmt = $con->prepare('select * from user where groupid=2');
                                $stmt->execute();
                                $teachers = $stmt->fetchAll(); //to get name of teacher
                                    ?>
                                        <tr>
                                            <td><?php echo $r['cname'];?></td>
                                            <td>
                                                <select name="teacherAndCourse-<?php echo $count.'_'.$r['cid'];?>" class="form-control">
                                                    <option value="0" disabled selected></option>
                                                    <?php
                                                    $tt = selectData('rtteacherId','reg_teacher','rtcourseId='.$r['cid'].' and rtacademicYear='.$academic[0]);
                                                    foreach($teachers as $t){
                                                        echo '<option value="'.$t['id'].'" ';
                                                        if($tt[0] == $t['id']) echo 'selected';
                                                        echo '>';
                                                            echo $t['name'].' -> '.$t['description'];
                                                        echo '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php
                            }?>
                             </tbody>
                    </table>
                        <?php
                        }else{
                            echo '<h1 class="text-center">لم تسجل مواد الي هذا الصف بعد</h1>';
                        }
                echo '</div>';
            }
            echo '</div>';
        ?>
                    </div>
                    <input type="submit" name="registerStudent" class="btn btn-primary btn-center" value="التسجيل الطلاب">
                </form>
                <?php
                }else
                    echo '<h4 class="text-center alert alert-danger">لا يوجد فصل دراسي</h4>';
                ?>

            </div>
        </div>
    </div>
          </div>

        </div>
    </div>
      </div>
      <!--=========================================================-->

      <?php
     }
      else if($do == 'show_course'){
          ?>
        <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">المواد</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>عرض معلومات عن المواد</h4>
            <a href="?do=addCourse" class="btn btn-primary">اضافة مادة</a>
            </div>
            <!--Start Course Body-->
            <div class="profile">
                    <div class="profileTab">

                          <?php
                              // for all class and get info about it ..
                                echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1? 'active':'';
                                    echo  '<li class="nav-item">';
                                        echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                        echo printClass($count);
                                        echo '</a>';
                                    echo '</li>';
                                }
                                echo '
                                    </ul>
                                    <div class="tab-content content" id="myTabContent">
                                ';
                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1?'show active':'';
                                    echo '
                                        <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                        ?>
                                        <?php
                                            $stmt = $con->prepare('select * from course where clevel=? and csemester in (1,2)');
                                            $stmt->execute(array($count));
                                            $rows = $stmt->fetchAll();
                                            if($stmt->rowCount() >0){
                                                ?>
                                                <table class="table">
                                                    <thead>
                                                         <tr>
                                                            <th scope="col">المادة</th>
                                                             <th scope="col">الترم</th>
                                                            <th scope="col">تعديل</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                <?php
                                                foreach($rows as $r){
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $r['cname'];?></td>
                                                                <td><?php if ($r['csemester'] == 1) echo 'الاول'; else echo 'الثاني';?></td>
                                                                <td>
                                                                    <form action="index.php" method="post" class="editButton">
                                                                        <input type="hidden" name="cid" value="<?php echo $r['cid'];?>">
                                                                        <button type="submit" name="editCourse" class="btn btn-success">تعديل</button>
                                                                        <button type="submit" name="deleteCourse" class="btn btn-danger">حذف</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                }?>
                                                 </tbody>
                                        </table>
                                            <?php
                                            }else{
                                                echo '<h1 class="text-center">لم تسجل مواد الي هذا الصف بعد</h1>';
                                            }
                                    echo '</div>';
                                }
                                echo '</div>';
                            ?>
                    </div>
                </div>
            <!--End Course Body-->
          </div>

        </div>
    </div>
      </div>
<?php
      }
      else if($do == 'addCourse'){
          ?>
            <div class="col-sm-9 details editStudent">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
                <a href="#">تعديل اضافة</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel" id="editStudentid">
                <h4>اضافة مواد</h4>
            </div>
                <div class="formContain">
                    <form action="index.php" method="post">
                        <div class="form-group row">
                            <label for="cname" class="col-sm-2 col-form-label">اسم المادة</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="cname"  name="courseName">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">كود المادة</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="code"  name="code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="classes" class="col-sm-2 col-form-label">الصف</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="classes"  name="classes">
                                    <?php
                                    for($i=1;$i<=6;$i++){
                                        echo '<option value="'.$i.'">';
                                            printClass($i);
                                        echo'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                          </div>

                        <div class="form-group row">
                            <label for="semester" class="col-sm-2 col-form-label">الترم</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="semester"  name="semester">
                                    <option value="1">الاول</option>
                                    <option value="2">الثاني</option>
                                </select>
                            </div>
                          </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" name="addNewCourse" class="btn btn-primary from-control col-sm-4"><i class="fa fa-plus"></i>اضافة مادة</button>
                            </div>

                        </div>
                    </form>
                </div>
          </div>

        </div>
    </div>
      </div>
      <?php
      }
      else if($do == 'edit_course' && isset($cid)){
          $stmt = $con->prepare('select * from course where cid=?');
          $stmt->execute(array($cid));
          $row = $stmt->fetch(); // for catch course itself
          $stmt = $con->prepare('select name,id from reg_teacher,user,course,academic_year where rtteacherId=id and rtcourseId=cid and rtacademicYear = aid and rtcourseId=? and rtacademicYear in (select max(aid) from academic_year)');
          $stmt->execute(array($cid));
          $teacher = $stmt->fetch(); // for teacher
          $checkTeacher = $stmt->rowCount();
//          if($stmt->rowCount() != 0){ // if this id is exist in database
              ?>
<div class="col-sm-9 details editStudent">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
                <a href="#">تعديل المواد</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel" id="editStudentid">
                <h4>تعديل المواد</h4>
            </div>
                <div class="formContain">
                    <form action="index.php" method="post">
                        <div class="form-group row">
                            <label for="cname" class="col-sm-2 col-form-label">اسم المادة</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="cname"  name="courseName" value="<?php echo $row['cname'];?>">
                            </div>
                          </div>
                        <input type="hidden" name="cid" value="<?php echo $row['cid'];?>">
                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" name="editCourseInfo" class="btn btn-primary from-control col-sm-4"><i class="fa fa-edit"></i> حفظ التعديل</button>
                            </div>

                        </div>
                    </form>
                </div>

          </div>

        </div>
    </div>
      </div>
      <?php
      }
      else if($do == 'show_teacher'){?>
       <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#"> عرض المدرسين  </a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
<!--    <div class="sec_tow clear-fix student">-->
    <div class="sec_tow clear-fix student">
       <div class="add">
           <div class="titel">
             <h4>عرض معلومات المدرسين</h4>
            <a href="index.php?do=add_teacher" class="btn btn-primary">اضافة مدرس جديد</a>
            </div>
           <div >
               <form action="index.php?do=show_student" enctype="multipart/form-data" method="post" class="manage-student">
                   <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter-class'])){ //filter ...
                        $noClass = $_POST['filter-class'];
                        $search_student = $_POST['search-student'];
                        if(isset($_POST['search-student']) && $_POST['search-student'] != '')
                            $noClass= 0;
                    }else{
                        $noClass = 1;
                        $search_student = '';
                    }
                    $_SESSION['do'] = $do;
                   ?>


                   <input type="hidden" name="appearShowStudent"> <!--for appear student-->
                    <input type="search" class="form-control feat" name="search-student" placeholder="بحث عن الطالب بالاسم او بارقم">

               </form>
           </div>
         <div class="adit">

            <?php

                $order = isset($_GET['order'])?$_GET['order']: 'startdate';
                if(!($order == 'name' || $order=='regdate'||$order=='startdate'||$order=='address'||$order=='birthday'))
                    $order = 'startdate';
                $class = isset($class)&&is_numeric($class)?$class:0;
                if($class == 0)
                    $st = '';
                else{
                    $class = date('Y')-$class-1;
                    $st = " and regdate=".$class;
                }
                echo $search_student;
                if(isset($search_student) && $search_student != ''){ // search student .. not yet ..

                    if(is_numeric($search_student)){
                        $students = selectData('*','user','groupId=2 and id='.$search_student,1);
                    }else{
                        $students = selectData("*",'user',"groupid=2 and name LIKE '%".$search_student."%'",1);
                    }
                }else{
                    $stmt = $con->prepare("select * from user where groupid =2$st order by $order");
                    $stmt->execute();
                    $students = $stmt->fetchAll();
                }
                if($stmt->rowCount()>0){
                    $counter = 1;
                    ?>
             <table class="table">
            <thead>
            <tr>
                <th scope="col">الرقم</th>
                <th scope="col"><a href="?do=show_teacher&order=name">الاسم <i class="" ></i></a></th>
                <th scope="col"><a href="?do=show_teacher&order=description">التخصص<i class=""></i></a></th>
                <th scope="col"><a href="?do=show_teacher&order=address">العنوان <i class=""></i></a></th>
                <th scope="col"><a href="?do=show_teacher&order=birthday">تاريخ الميلاد <i class=""></i></a></th>
                <th scope="col"><a href="?do=show_teacher&order=startdate">تاريخ الدخول <i class=""></i></a></th>
                <th scope="col"><a href="#">تعديل <i class=""></i></a></th>
            </tr>
            </thead>
            <tbody>
             <?php
                        foreach($students as $s){
                            ?>
                                <?php // for selection of filter [subjects]

                                ?>
                                <tr class="<?php if($s['active'] == 0) echo 'not-active';?>">
                                    <td><?php echo $counter?></td>
                                    <th scope="row"><a href="?do=profileTeacher&id=<?php echo $s['id']?>" class="link-student"><?php echo $s['name'];?></a></th>
                                    <td><?php echo $s['description'];?></td>
                                    <td><?php echo $s['address'];?></td>
                                    <td><?php echo $s['birthday'];?></td>
                                    <td><?php echo $s['startdate'];?></td>
                                    <td class="studentButton">
                                        <a href="index.php?do=editTeacher&id=<?php echo $s['id'];?>#editStudentid" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="index.php?do=remove_teacher&id=<?php echo $s['id'];?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                                        <a href="index.php?do=profileTeacher&id=<?php echo $s['id'];?>" alt="عرض المواد الحالية" class="btn btn-info"><i class="far fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php
                            $counter++;
                        }
                    ?>
                </tbody>
        </table>

                <?php
                    }
                else{
                    echo '<h1 class="text-center">لا يوجد هذا مدرسين</h1>';
                }
                ?>

           </div>
        </div>

        </div>


<!--    </div>-->
      </div>
<?php
      }
      else if($do=='add_teacher'){
      ?>
      <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">اضافة مدرس</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>اضافه معلومات مدرس جديد </h4>
            </div>
            <div class="add_form">
               <form action="index.php?do=show_teacher" method="post">
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="name" placeholder="الاسم بالكامل" required>
                    </div>
                    <div class="col">
                      <input type="email" class="form-control" name="email" required placeholder="الاميل الالكتروني">
                    </div>
                  </div>
                   <div class="row">
                    <div class="col">
                      <input type="date" class="form-control" name="birthday" placeholder="تاريخ الميلاد" required>
                    </div>
                    <div class="col">
                      <input type="number" class="form-control" name="phone" placeholder="رقم التلفون" required>
                    </div>
                  </div>
                   <div class="row">
                    <div class="col">
                      <input type="number" class="form-control" name="ssn" placeholder="الرقم القومي" required>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" name="address" placeholder="العنوان">
                    </div>
                  </div>
                   <div class="row">
                       <div class="col-sm-3" style="padding-top: 25px;text-align: center;">
                       <label >كلمة المرور: </label>
                       </div>
                    <div class="col">
                      <input type="text" class="form-control" name="password" value="123" placeholder="كلمة المرور" required>
                    </div>
                  </div>
                   <div class="row">
                        <div class="col">
                            <select name="subject" class="form-control">
                                <?php
                                    $stmt  = $con->prepare('select distinct cname from course');
                                    $stmt->execute();
                                    $course = $stmt->fetchAll();
                                    foreach($course as $c){
                                        echo '<option value="'.$c['cname'].'">'.$c['cname'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                  </div>
                   <input type="submit" class="btn" value="تسجيل" name="addNewTeacher">
                </form>


              </div>
          </div>

        </div>




    </div>
      </div>
<?php }
      else if($do == 'show_schedule'){
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">الجدول</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>عرض الجداول</h4>
            </div>
            <!--Start Body Of This Section-->
            <div class="schedule">
                <div class="filter row" style="margin:20px 0"><!--Academic Year => semester .. -->
                    <form action="index.php?do=show_schedule" method="post">
                        <select name="academicYear" class="form-control academicYear filter-selection">
                            <?php
                                $semester = selectData('*','academic_year',' 1  order by aid desc',1);
                                if ($semester == false){
                                    echo '<option class="text-center" value="0">لا توجد ترم لعرضة </option>';
                                }else{
                                    $academic = isset($_POST['academicYear'])?$_POST['academicYear']:0;
                                    foreach($semester as $s){
                                        echo '<option value="'.$s['aid'].'"';
                                        if($academic != 0 && $academic == $s['aid'])
                                            echo 'selected';
                                        echo '>'.$s['yearId'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <a href="?do=add_schedule" class="btn btn-primary">اضافة الجدول</a>
                    </form>
                </div>

                <div class="showSchedule">
                    <?php
                    if(!isset($academic))
                        $academic = 0;
                    else if($academic == 0 )
                        $academic = $semester[0]['aid'];
                    $schedules = selectData('*','schedule_name','snacademicYear='.$academic,1);
                    if($schedules == false){
                        echo '<h4 class="text-center alert alert-info">لا توجد جداول مسجلة الي هذا الفصل الدراسي</h4>';
                    }else{
                        ?>
                    <table class="table">
                        <thead>
                            <th scope="col">الرقم</th>
                            <th scope="col">اسم الجدول</th>
                            <th scope="col">نوع</th>
                            <th scope="col">تاريخ</th>
                            <th scope="col">تعديل</th>
                        </thead>
                        <tbody>
                            <?php
                            $count =1;
                            foreach($schedules as $s){
                                echo '<tr>';
                                    echo '<td>'.$count.'</td>';
                                    echo '<td>'.$s['snname'].'</td>';
                                    echo '<td>'.$s['sntype'].'</td>';
                                    echo '<td>'.$s['sndate'].'</td>';
                                    echo '<td>';
                                        echo '<form action="index.php" method="post" class="editButton">';
                                            echo '<input type="hidden" name="snid" value="'.$s['snid'].'">';
                                            echo '<button type="submit" name="showSchedule" class="btn btn-info">عرض</button>';
                                            echo '<button type="submit" name="editSchedule" class="btn btn-success">تعديل</button>';
                                            echo '<button type="submit" name="deleteSchedule" class="btn btn-danger">حذف</button>';
                                        echo '</form>';
                                    echo '</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!--End Body Of This Section-->
          </div>

        </div>




    </div>
      </div>
           <?php
      }
      else if($do == 'add_schedule' || $do == 'editSchedule' || $do == 'showSchedule'){
          if(isset($_POST['noSteps']))
              $step = $_POST['noSteps'];
          else if($do == 'showSchedule')
              $step = 2;
          else
              $step = 1;
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
                <?php
                   if($do == 'editSchedule')
                       echo '<a href="#">تعديل الجدول</a>';
                    else if($do == 'showSchedule')
                        echo '<a href="#">عرض الجدول</a>';
                    else
                        echo '<a href="#">اضافة الجدول</a>';
                   ?>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
               <?php
               if($do == 'editSchedule')
                   echo '<h4>تعديل الجدول</h4>';
                else if($do == 'showSchedule')
                   echo '<h4>عرض الجدول</h4>';
                else
                    echo '<h4>اضافة الجدول</h4>';
               ?>

            </div>
            <!--Start Body Of This Section-->
            <?php
            $check = isExist('academic_year','1');
            if($check != false){
                ?>
            <div class="add-schedule">
                <?php
                if($step == 1){
                    if($do == 'editSchedule'){
                        $editHere = selectData('*','schedule_name','snid='.$_POST['snid']);
                        #$do = 'editSchedule';
                    }
                    if($do == 'showSchedule'){

                    }else{
                    ?>
                <div class="part1">
                    <form action="?do=add_schedule" method="post">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" name="name" placeholder="اسم الجدول" <?php if(isset($editHere)) echo 'value="'.$editHere['snname'].'"';?> required class="form-control">
                            </div>
                            <div class="col-sm-4" style="float:left; margin-right:auto">
                                <select name="type" class="form-control" required >
                                    <?php
                                    if(isset($editHere)){
                                        if($editHere['sntype'] == 'دراسي')
                                            $select = 1;
                                        else if($editHere['sntype'] == 'الامتحانات')
                                            $select = 2;
                                        else
                                            $select = 0;
                                    }else
                                        $select = 0;
                                    ?>
                                    <option disabled <?php if($select == 0) echo 'selected';?>>نوع الجدول</option>
                                    <option value="1" <?php if($select == 1) echo 'selected';?>>دراسي</option>
                                    <option value="2" <?php if($select == 2) echo 'selected';?>>الامتحانات</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="noSteps" value="2">
                            <input type="hidden" name="snid" value="<?php echo $_POST['snid'];?>">
                            <?php
                                if($do == 'editSchedule')
                                    echo '<input type="hidden" name="edit" value="">';
                            ?>
                            <input type="submit" name="step1AddDegree" value="الخطوة التالية" class="btn btn-primary btn-center">
                        </div>
                    </form>
                </div>
                <?php
                    }
                }else if($step == 2 || $do == 'showSchedule'){
                    if(isset($_POST['edit']))
                        $do = 'editSchedule';
                    else if(isset($_POST['showSchedule'])){
                        $do = 'showSchedule';
                        $schedule = selectData('*','schedule_name','snid='.$_POST['snid']);
                        if($schedule == false)
                            return 0;
                        else{
                            $_POST['name'] = $schedule['snname'];
                            $_POST['type'] = $schedule['sntype'];
                        }
                    }
                    if(isset($_POST['type']) && $do != 'showSchedule'){
                        if($_POST['type'] == 1)
                            $type = 'دراسي';
                        else if($_POST['type'] == 2)
                            $type = 'الامتحانات';
                        else
                            $type = 'الامتحانات';
                    }
                    else if($do == 'showSchedule')
                        $type = $_POST['type'];
                    else
                        $type = 'الامتحانات';
                    ?>
                <div class="info-schedule">
                    <div>
                        <span>الاسم الجدول: </span>
                        <span><?php echo $_POST['name'];?></span>
                    </div>
                    <div>
                        <span>النوع: </span>
                        <span><?php echo $type;?></span>
                    </div>
                </div>
                <?php
                if($type == 'دراسي' && $do == 'add_schedule')
                    $check = isExist('schedule_name','sntype="'.$type.'" and snacademicYear in (select max(aid) from academic_year)');
                else
                    $check = false;
                if($check == false){
                    ?>
                <form action="index.php" method="post">
                <?php

                    if($do == 'add_schedule')
                        $check = isExist('schedule_name','snname="'.$_POST['name'].'" and snacademicYear in (select max(aid) from academic_year)'); // this line for check if really exist or not ..
                    // for all class and get info about it ..
                    if($check == false){
                        echo '<div class="profileTab">';
                        echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                        for($count=1;$count<=6;$count++){
                            $idBody = 'class'.$count;
                            $idNav = 'class-tab'.$count;
                            $var = $count==1? 'active':'';
                            echo  '<li class="nav-item">';
                                echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                echo printClass($count);
                                echo '</a>';
                            echo '</li>';
                        }
                        echo '
                            </ul>
                            <div class="tab-content content" id="myTabContent">
                        ';
                        for($count=1;$count<=6;$count++){
                            $idBody = 'class'.$count;
                            $idNav = 'class-tab'.$count;
                            $var = $count==1?'show active':'';
                            if($do == 'showSchedule')
                                $b12 = 'sub23';
                            else
                                $b12 = '';
                            echo '
                                <div class="tab-pane schedule fade '.$b12.' '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                /*the body here of this level .. */
                                $semester = selectData('*','academic_year','1 order by aid desc limit 1');
                                $course = selectData('*','course','clevel='.$count.' and csemester='.$semester['semester'],1);
                                $xcount =1;
                                echo '<table class="table">';
                                if($do == 'showSchedule') $v12 = 'class="color"';
                                else $v12 = '';
                                    echo '<thead '.$v12.' >';
                                        echo '<th scope="col">الرقم</th>';
                                        echo '<th scope="col">المادة</th>';
                                        if($type != 'دراسي'){
                                            echo '<th scope="col">التاريخ</th>';
                                            echo '<th scope="col">الوقت</th>';
                                        }else{
                                            echo '<th scope="col">السبت</th>';
                                            echo '<th scope="col">الاحد</th>';
                                            echo '<th scope="col">الاثنين</th>';
                                            echo '<th scope="col">الثلاثاء</th>';
                                            echo '<th scope="col">الاربعاء</th>';
                                            echo '<th scope="col">الخميس</th>';
                                        }
                                    echo '</thead>';
                                    echo '<tbody>';
                                        foreach($course as $c){
                                            if($do == 'showSchedule' and $xcount%2==0) $addClass = 'class="even"';
                                            else $addClass = '';
                                            echo '<tr '.$addClass.' >';
                                                echo '<td>'.$xcount.'</td>';
                                                echo '<td>'.$c['cname'].'</td>';
                                            if($type != 'دراسي'){
                                                if($do == 'editSchedule' || $do == 'showSchedule'){
                                                    $courseValue = selectData('*','schedule','ssnid='.$_POST['snid'].' and scourseId='.$c['cid'],1);
                                                    if($courseValue == false){$dateVal = '';$timeVal = '';}
                                                    else {
                                                        foreach($courseValue as $data){
                                                            if($data['sdate'] != null)
                                                                $dateVal = 'value="'.$data['sdate'].'"';
                                                            if($data['stime'] != null)
                                                                $timeVal = 'value="'.$data['stime'].'"';
                                                        }
                                                    }
                                                }else {$dateVal = '';$timeVal = '';}
                                                if($do == 'showSchedule'){
                                                    echo '<td>'.$dateVal.'</td>';
                                                    echo '<td>'.$timeVal.'</td>';
                                                }else{
                                                    echo '<td><input type="date" name="date-'.$c['cid'].'" '.$dateVal.' class="form-control d"></td>';
                                                    echo '<td><input type="time" name="time-'.$c['cid'].'" '.$timeVal.' class="form-control d"></td>';
                                                }

                                            }else{
                                                for($r=1;$r<=6;$r++){
                                                    if($do == 'editSchedule' || $do == 'showSchedule')
                                                        $courseValue = selectData('*','schedule','sday='.$r.' and ssnid='.$_POST['snid'].' and scourseId='.$c['cid']);
                                                    else
                                                        $courseValue = false;
                                                    if($do != 'showSchedule'){
                                                        echo '<td><input type="time" name="'.$r.'-'.$c['cid'].'" class="form-control" ';
                                                        if($courseValue != false)
                                                            echo 'value="'.$courseValue['stime'].'"';
                                                        echo ' ></td>';
                                                    }else{
                                                        if($courseValue != false)
                                                            echo '<td>'.$courseValue['stime'].'</td>';
                                                        else
                                                            echo '<td>-----</td>';
                                                    }

                                                }
                                            }
                                            echo '</tr>';
                                            $xcount++;
                                        }
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="">
                        <input type="hidden" name="name" value="'.$_POST['name'].'">
                        <input type="hidden" name="type" value="'.$type.'">';
                        if($do == 'editSchedule'){
                            echo '<input type="hidden" name="snid" value="'.$_POST['snid'].'">';
                            echo '<input type="submit" name="editScheduleFinal" class="btn btn-primary btn-center" value="تعديل الجدول">';
                        }
                        else if($do == 'add_schedule')
                            echo '<input type="submit" name="addSchedule" class="btn btn-primary btn-center" value="اضافة الجدول">';
                        echo '</div>';
                    }else{
                        echo '<h4 class="text-center alert alert-info">اسم الجدول الذي ادخلته موجود مسبقا .. يرجي اعادة المحاولة</h4>';
                    }
                ?>
                </form>
                <?php
                }else{ //for check of sntype
                    echo '<h4 class="text-center alert alert-info">لا يمكن تسجيل الجدول العامة اكثر من مرة</h4>';
                }
                }else // this else is follow condition about steps
                    echo ' => Out Of Steps <= ';
                ?>


            </div>
            <?php
            }else{
                echo '<h4 class="text-center alert alert-danger">لا يمكن التسجيل .. الان لايوجد فصل دراسي مسجل</h4>';
            }
            ?>

            <!--End Body Of This Section-->
          </div>

        </div>
    </div>
      </div>
           <?php
      }
      else if($do == 'manage_student'){
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">بيانات الطلبة</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>تعديل الدرجات والغياب</h4>
            </div>
            <!--Start Body Of This Section-->
            <div class="card" id="degree">
                <div class="card-header text-center" >الدرجات</div>
                <div class="card-body">
                    <div class="filter row"><!--Academic Year => semester .. -->
                        <form action="index.php?do=manage_student#degree" method="post">
                            <select name="academicYear" class="form-control academicYear filter-selection">
                                <?php
                                    $semester = selectData('*','academic_year',' 1  order by aid desc',1);
                                    if ($semester == false){
                                        echo '<option class="text-center" value="0">لا توجد ترم لعرضة </option>';
                                    }else{
                                        $academic = isset($_POST['academicYear'])?$_POST['academicYear']:0;
                                        foreach($semester as $s){
                                            echo '<option value="'.$s['aid'].'"';
                                            if($academic != 0 && $academic == $s['aid'])
                                                echo 'selected';
                                            echo '>'.$s['yearId'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </form>
                    </div>
                    <hr>
                    <div class="filter degree row">
                        <form action="index.php?do=manage_student" class="filter-form" method="post">
                            <select name="filter-class" class="form-control  filter-selection col-sm-5">
                                    <option value="0">الصف الدراسي</option>
                                    <?php
                                        $selectLevel = isset($_POST['filter-class'])?$_POST['filter-class']:0;
                                        for($i=1;$i<=6;$i++){
                                        echo '<option value="'.$i.'"';
                                            if($selectLevel == $i)
                                                echo 'selected';
                                        echo '>';
                                            printClass($i);
                                        echo'</option>';
                                    }
                                    ?>
                                </select>
                            <select name="selectCourse" class="form-control filter-selection">
                                <?php
                                $courses = selectData('distinct cname','course','1',1);
                                $selectCourse = isset($_POST['selectCourse'])?$_POST['selectCourse']:0;
                                echo '<option value="0"';
                                    if($selectCourse==0)
                                        echo 'selected';
                                echo '>المادة</option>';
                                foreach($courses as $c){
                                    echo '<option value="'.$c['cname'].'"';
                                    if($selectCourse == $c['cname'] && !is_numeric($selectCourse))
                                        echo 'selected';
                                    echo '>'.$c['cname'].'</option>';
                                }
                                ?>
                            </select>
                            <?php ?>
                        </form>
                    </div>
                    <div class="show-degree">
                        <?php
                        $selectCourse = isset($_POST['selectCourse'])?$_POST['selectCourse']:0;
                        if($selectCourse === 0 || $selectCourse === '0') $selectCourse='cname';
                        else $selectCourse = '"'.$selectCourse.'"';
                        if($selectLevel == 0) $selectLevel = 'clevel';
                        if(isset($academic) && $academic == 0) {
                            $academic= selectData('max(aid)','academic_year','1');
                            $academic = $academic['max(aid)'];
                        }else if(!isset($academic))
                            $academic = 0;

                        //echo 'dtcourseId=cid and dtacademicYear=aid and dtacademicYear='.$academic.' and cname='.$selectCourse.' and clevel='.$selectLevel,' and csemester=semester order by clevel';
                            $selectDegree = selectData('cname,clevel,dtname,dtid,dtmaxDegree,dtexamDate','degreeType,course,academic_year','dtcourseId=cid and dtacademicYear=aid and dtacademicYear='.$academic.' and cname='.$selectCourse.' and clevel='.$selectLevel.' and csemester=semester order by clevel',1);
                        if($selectDegree != false){
                            ?>
                            <table class="table">
                                <thead>
                                    <th scope="col">المادة</th>
                                    <th scope="col">الصف</th>
                                    <th scope="col">اسم الامتحان</th>
                                    <th scope="col">الدرجة القصوي</th>
                                    <th scope="col">تاريخ</th>
                                    <th scope="col">التعديل</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($selectDegree as $d){
                                        echo '<tr>';
                                            echo '<td>'.$d['cname'].'</td>';
                                            echo '<td>';
                                                printClass($d['clevel']);
                                            echo '</td>';
                                            echo '<td>'.$d['dtname'].'</td>';
                                            echo '<td>'.$d['dtmaxDegree'].'</td>';
                                            echo '<td>'.$d['dtexamDate'].'</td>';
                                            echo '<td>';
                                                echo '<form action="index.php" method="post" class="editButton">';
                                                    echo '<input type="hidden" name="dtid" value="'.$d['dtid'].'">';
                                                    echo '<input type="hidden" name="degreeType" value="'.$d['dtid'].'">';
                                                    echo '<button type="submit" name="showDegreeType" class="btn b btn-info">عرض</button>';
                                                    echo '<button type="submit" name="editDegreeType" class="btn btn-success">تعديل</button>';
                                                    echo '<button type="submit" name="deleteDegreeType" class="btn btn-danger">حذف</button>';
                                                echo '</form>';
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        }else
                            echo '<h3 class="text-center alert alert-info">لاتوجد درجات الي هذه المادة</h3>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="card" id="absence">
                <div class="card-header text-center" >الغياب</div>
                <div class="card-body">
                    <div class="filter row"><!--Academic Year => semester .. -->
                        <form action="index.php?do=manage_student#absence" method="post">
                            <select name="academicYear1" class="form-control academicYear filter-selection">
                                <?php
                                    $semester = selectData('*','academic_year',' 1  order by aid desc',1);
                                    if ($semester == false){
                                        echo '<option class="text-center" value="0">لا توجد ترم لعرضة </option>';
                                    }else{
                                        $academic1 = isset($_POST['academicYear1'])?$_POST['academicYear1']:0;
                                        foreach($semester as $s){
                                            echo '<option value="'.$s['aid'].'"';
                                            if($academic1 != 0 && $academic1 == $s['aid'])
                                                echo 'selected';
                                            echo '>'.$s['yearId'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <a href="?do=add_absence" class="btn btn-primary">اضافة الغياب</a>
                        </form>
                    </div>
                    <hr>
                    <div class="listOfAbsence">
                        <?php
                        if(isset($academic1) && $academic1 == 0)
                            $academic1 = $semester[0]['aid'];
                        if(!isset($academic1))
                            $academic1 = 0;
                        $absence = selectData('*','absence_day','adacademicYear='.$academic1.' order by day desc',1);
                        if($absence != false){
                            ?>
                        <table class="table">
                            <thead>
                                <th scope="col">رقم</th>
                                <th scope="col">اليوم</th>
                                <th scope="col">التاريخ</th>
                                <th scope="col">العدد</th>
                                <th scope="col">التعديل</th>
                            </thead>
                            <tbody>
                                <?php
                                $count=1;
                                foreach($absence as $b){
                                    $levelCount = selectData('count(*)','absence','aadid='.$b['adid']);
                                    echo '<tr>';
                                        echo '<td>'.$count.'</td>';
                                        echo '<td>'.day(date('D', strtotime($b['day']))).'</td>';
                                        echo '<td>'.$b['day'].'</td>';
                                        echo '<td>'.$levelCount[0].'</td>';
                                        echo '<td>';
                                            echo '<form action="index.php" method="post" class="editButton">';
                                                echo '<input type="hidden" name="adid" value="'.$b['adid'].'">';
                                                echo '<input type="submit" name="show_absence" value="عرض" class="btn btn-info">';
                                                echo '<input type="submit" name="edit_absence" value="تعديل" class="btn btn-success">';
                                                echo '<input type="submit" name="delete_absence" value="حذف" class="btn btn-danger">';
                                            echo '</form>';
                                        echo '</td>';
                                    echo '</tr>';
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo '<h3 class="text-center alert alert-info">لم يتم تسجيل الغياب الي هذا الترم</h3>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--End Body Of This Section-->
          </div>

        </div>




    </div>
      </div>
           <?php
      }
      else if($do == 'add_absence'){
              ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">اضافة الغياب</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>اضافة الغياب</h4>
            </div>
            <!--Start Body Of This Section-->
            <?php
            if(!isset($_POST['noSteps']))
                $step = 1;
            else
                $step = 2;
          if($step == 1){
            ?>
            <div class="part1">
                <h1 class="text-center">الغياب</h1>
                <form action="index.php?do=add_absence" method="post">
                    <input type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control">
                    <input type="hidden" name="noSteps" value="2">
                    <input type="submit" name="add_absence" value="الخطوة التالية" class="btn btn-primary">
                </form>
            </div>
            <?php
          }else if($step == 2 && isset($_POST['add_absence'])){
              if(!isExist('absence_day','adacademicYear in (select max(aid) from academic_year) and day="'.$_POST['date'].'"')){
            ?>
            <form action="index.php" method="post" class="sub23">
            <div class="profile">
                    <div class="profileTab">
                          <?php
                              // for all class and get info about it ..
                                echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1? 'active':'';
                                    echo  '<li class="nav-item">';
                                        echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                        echo printClass($count);
                                        echo '</a>';
                                    echo '</li>';
                                }
                                echo '
                                    </ul>
                                    <div class="tab-content content" id="myTabContent">
                                ';

                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1?'show active':'';
                                    echo '
                                        <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                        $student = selectData('name,id','user','groupid=1 and regdate='.(date('Y')-$count+1).' order by name',1);
                                        if($student == false)
                                            echo '<h3 class="alert alert-danger text-center">لا يوجد مسجلة الي هذا الصف</h3>';
                                        else{

                                            echo '<table class="table">';
                                                echo '<thead class="color">';
                                                    echo '<tr>';
                                                    echo '<th scope="col">رقم</th>';
                                                    echo '<th scope="col">تحديد</th>';
                                                    echo '<th scope="col">رقم الهوية</th>';
                                                    echo '<th scope="col">الاسم</th>';
                                                    echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';
                                                $c=1;
                                                foreach($student as $s){
                                                        echo '<tr ';
                                                        if($c%2==0)
                                                            echo 'class="even" ';
                                                        echo '>';
                                                            echo '<td>'.$c.'</td>';
                                                            echo '<td><input type="checkbox" name="'.$s['id'].'"></td>';
                                                            echo '<td>'.$s['id'].'</td>';
                                                            echo '<td>'.$s['name'].'</td>';
                                                        echo '</tr>';
                                                    $c++;
                                                }
                                                echo '<tbody>';
                                            echo '</table>';

                                        }

                                    echo '</div>';
                                }

                                echo '</div>';
                            ?>
                    </div>

                </div>
                <input type="hidden" name="date" value="<?php echo $_POST['date']?>">
                <input type="submit" name="addAbsence" class="btn btn-primary btn-center" value="اضافة الغياب">
                </form>
            <!--End Body Of This Section-->
          </div>
        <?php
              }else{
                  echo '<h3 class="text-center alert alert-info">لا يمكن التسجيل بهذا التاريخ الانه مسجل مسبقا</h3>';
              }
          }
        ?>
        </div>




    </div>
      </div>
           <?php
    }
      else if($do == 'add_event' || ($do == 'edit_event' && isset($_POST['eid']))){
          if($do == 'edit_event')
            $event = selectData('*','event','eid='.$_POST['eid']);
          if(!isset($event)||$event != false){
              ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">اضافة الفعاليات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>اضافة الفعاليات</h4>
            </div>
            <!--Start Body Of This Section-->
            <div class="events">
                <form action="index.php" method="post">
                    <div class="form-group row">
                        <label for="cname" class="col-sm-2 col-form-label">عنوان</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cname" <?php if($do =='edit_event') echo 'value="'.$event['title'].'"';?>  name="title" required>
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="cname1" class="col-sm-2 col-form-label">تاريخ</label>
                        <div class="col-sm-6">
                          <input type="date" class="form-control" id="cname1" <?php if($do =='edit_event') echo 'value="'.$event['edate'].'"'; else echo 'value="'.date('Y-m-d').'"';?> name="date" required>
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="cname4" class="col-sm-2 col-form-label">التفصيل</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="5" id="cname4" name="details" required><?php if($do =='edit_event') echo $event['details'];?></textarea>
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="cname4" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-6">
                            <?php
                            if($do =='edit_event'){
                                echo '<input type="hidden" name="eid" value="'.$event['eid'].'">';
                                echo '<input type="submit" name="editEvent" value="تعديل الفعاليات" class="btn btn-primary">';
                            }
                            else
                                echo '<input type="submit" name="addEvent" value="اضافة الفعاليات" class="btn btn-primary">';
                            ?>

                        </div>
                      </div>
                </form>
            </div>
            <!--End Body Of This Section-->
          </div>
        </div>
    </div>
      </div>
           <?php
          }else
              echo '<h4 class="text-center alert alert-danger">هذا الفعالية غير موجودة !!</h4>';

    }
     else if($do == 'show_absence'){
              ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">عرض الغياب</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>عرض الغياب</h4>
            </div>
            <!--Start Body Of This Section-->
            <?php
            $absence = selectData('*','absence_day','adid='.$_POST['adid']);
            $countStudent = selectData('count(*)','absence','aadid='.$_POST['adid']);
            ?>
            <div class="part1">
                <h1 class="text-center">الغياب</h1>
                <div>
                    <div class="fat">اليوم: <?php echo day(date('D', strtotime($absence['day'])))?></div>
                    <div class="fat">التاريخ: <?php echo $absence['day'];?></div>
                    <div class="fat">العدد: <?php echo $countStudent[0]?></div>
                </div>
            </div>
            <div class="part2 sub23">
                <?php
                if($countStudent != 0){
                    ?>
                <table class="table">
                    <thead class="color">
                        <th scope="col">رقم</th>
                        <th scope="col">رقم الهوية</th>
                        <th scope="col">الاسم</th>
                        <th scope="col">الصف</th>
                        <th scope="col">نسبة الغياب</th>
                    </thead>
                    <tbody>
                        <?php
                        $count=1;
                        $student = selectData('name,id,regdate','absence,user','aadid='.$_POST['adid'].' and abstudentId=id order by regdate desc',1);
                        foreach($student as $s){
                            $persent = selectData('count(*)','absence,absence_day','aadid=adid and abstudentId='.$s['id'].' and adacademicYear='.$absence['adacademicYear']);
                            $countDay = selectData('count(*)','absence_day','adacademicYear='.$absence['adacademicYear']);
                            $persent = intval(($persent[0]*100)/$countDay[0]);

                            echo '<tr ';
                            if($count%2==0)
                                echo 'class="even"';
                            echo '>';
                            echo '<td>'.$count.'</td>';
                            echo '<td>'.$s['id'].'</td>';
                            echo '<td>'.$s['name'].'</td>';
                            echo '<td>';
                            printClass(date('Y')-$s['regdate']+1);
                            echo '</td>';
                            echo '<td>'.$persent.'%</td>';
                            echo '</tr>';
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                }else {
                    echo '<h3 class="text-center alert alert-info">لا توجد قائمة غياب لعرضها</h3>';
                }
                ?>
            </div>
            <!--End Body Of This Section-->
          </div>

        </div>




    </div>
      </div>
           <?php
    }
      else if($do == 'edit_absence'){
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">تعديل الغياب</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>تعديل الغياب</h4>
            </div>
            <!--Start Body Of This Section-->
            <?php
            $absence = selectData('*','absence_day','adid='.$_POST['adid']);
            if(!isset($_POST['noSteps']))
                $step = 1;
            else
                $step = 2;
          if($step == 1){
            ?>
            <div class="part1">
                <h1 class="text-center">الغياب</h1>
                <form action="index.php?do=edit_absence" method="post">
                    <input type="date" name="date" value="<?php echo $absence['day']?>" class="form-control">
                    <input type="hidden" name="noSteps" value="2">
                    <input type="hidden" name="adid" value="<?php echo $_POST['adid']?>">
                    <input type="submit" name="edit_absence" value="الخطوة التالية" class="btn btn-primary">
                </form>
            </div>
            <?php
          }else if($step == 2 && isset($_POST['edit_absence'])){
              if(!isExist('absence_day','day="'.$_POST['date'].'"') || $absence['day'] == $_POST['date']){
                  //that condition for check if this day is exist in another day register in my database
            ?>
            <form action="index.php" method="post" class="sub23">
            <div class="profile">
                    <div class="profileTab">
                          <?php
                              // for all class and get info about it ..
                                echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1? 'active':'';
                                    echo  '<li class="nav-item">';
                                        echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                        echo printClass($count);
                                        echo '</a>';
                                    echo '</li>';
                                }
                                echo '
                                    </ul>
                                    <div class="tab-content content" id="myTabContent">
                                ';

                                for($count=1;$count<=6;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1?'show active':'';
                                    echo '
                                        <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                        $student = selectData('name,id','user','groupid=1 and regdate='.(date('Y')-$count+1).' order by name',1);
                                        if($student == false)
                                            echo '<h3 class="alert alert-danger text-center">لا يوجد مسجلة الي هذا الصف</h3>';
                                        else{

                                            echo '<table class="table">';
                                                echo '<thead class="color">';
                                                    echo '<tr>';
                                                    echo '<th scope="col">رقم</th>';
                                                    echo '<th scope="col">تحديد</th>';
                                                    echo '<th scope="col">رقم الهوية</th>';
                                                    echo '<th scope="col">الاسم</th>';
                                                    echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';
                                                $c=1;
                                                foreach($student as $s){
                                                    $check = isExist('absence','aadid='.$_POST['adid'].' and abstudentId='.$s['id']);
                                                        echo '<tr ';
                                                        if($c%2==0)
                                                            echo 'class="even" ';
                                                        echo '>';
                                                            echo '<td>'.$c.'</td>';
                                                            echo '<td><input type="checkbox" ';
                                                            if($check == true)
                                                                echo 'checked';
                                                            echo ' name="'.$s['id'].'"></td>';
                                                            echo '<td>'.$s['id'].'</td>';
                                                            echo '<td>'.$s['name'].'</td>';
                                                        echo '</tr>';
                                                    $c++;
                                                }
                                                echo '<tbody>';
                                            echo '</table>';

                                        }

                                    echo '</div>';
                                }

                                echo '</div>';
                            ?>
                    </div>
                </div>
                <input type="hidden" name="date" value="<?php echo $_POST['date']?>">
                <input type="hidden" name="adid" value="<?php echo $_POST['adid']?>">
                <div>
                    <input type="submit" name="edit_absenceFinal" class="btn btn-primary btn-center" value="تعديل الغياب">
                </div>

                </form>
            <!--End Body Of This Section-->
          </div>
        <?php
              }else{
                  echo '<h3 class="text-center alert alert-danger">هذا التاريخ تم تسجيله مسبقا</h3>';
              }
          }
        ?>
        </div>




    </div>
      </div>
           <?php
      }
      else if($do == 'show_degreeStudent' && isset($_POST['dtid']) && isset($_POST['showDegreeType'])){
          $selectDegree = selectData('*','degreeType,degree,course,academic_year,user','dtcourseId=cid and dtype=dtid and dstudentId=id and dtacademicYear = aid and dtid='.$_POST['dtid'].' order by name',1);
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">عرض درجات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>عرض الدرجات</h4>
            </div>
            <!--Start Body Of This Section-->
            <?php
            if($selectDegree != false){
                ?>
            <div class="formContain sub23">
                <div class="div1">
                    <h1><?php echo $selectDegree[0]['cname'];?></h1>
                    <div class="sub">
                        <div><span>اسم الامتحان:</span> <?php echo $selectDegree[0]['dtname'];?></div>
                        <div><span>الصف الدراسي:</span> <?php echo $selectDegree[0]['clevel'];?></div>
                        <div><span>الدرجة القصي:</span> <?php echo $selectDegree[0]['dtmaxDegree'];?></div>
                    </div>
                </div>
                <div class="div2">
                    <form class="filter" action="index.php" method="post">
                        <input type="search" class="form-control" name="studentSearch" placeholder="البحث بالاسم او رقم الهوية">
                        <input type="hidden" name="dtid" value="<?php echo $_POST['dtid'];?>">
                        <button class="btn btn-primary" name="editStudentDegree"><i class="fa fa-edit"></i> تعديل الدرجات</button>
                    </form>
                    <table class="table">
                        <thead>
                            <th scope="col">رقم</th>
                            <th scope="col">رقم الهوية</th>
                            <th scope="col">الاسم</th>
                            <th scope="col">الدرجة</th>
                        </thead>
                        <tbody>
                            <?php
                            $count =1;
                            foreach($selectDegree as $d){
                                echo '<tr ';
                                if($count%2==0)
                                    echo 'class="even"';
                                echo '>';
                                    echo '<td>'.$count.'</td>';
                                    echo '<td>'.$d['id'].'</td>';
                                    echo '<td>'.$d['name'].'</td>';
                                    echo '<td>'.$d['degree'].'</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            }
            else
                echo '<h3 class=" alert alert-danger">لا سجلات الي هذه المادة</h3>';
            ?>
            <!--End Body Of This Section-->
          </div>

        </div>
    </div>
      </div>
           <?php
      }
      else if($do == 'editStudentDegree' && isset($_POST['dtid']) && isset($_POST['editStudentDegree'])){
           $degreeName = selectData('*','degreetype,course','dtcourseId=cid and dtid='.$_POST['dtid']);
           $student = selectData('*','reg_course,user','studentId=id and courseId='.$degreeName['dtcourseId'].' and academicYear='.$degreeName['dtacademicYear']);
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">تعديل درجات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>تعديل الدرجات</h4>
            </div>
            <!--Start Body Of This Section-->
            <?php
            if($student != false || $degreeName == false){
                ?>
            <div class="formContain sub23">
                <div class="div1">
                    <h1><?php echo $degreeName['cname'];?></h1>
                    <div class="sub">
                        <div><span>اسم الامتحان:</span> <?php echo $degreeName['dtname'];?></div>
                        <div><span>الصف الدراسي:</span> <?php echo $degreeName['clevel'];?></div>
                        <div><span>الدرجة القصي:</span> <?php echo $degreeName['dtmaxDegree'];?></div>
                    </div>
                </div>
                <div class="div2 div3">
                    <form class="filter" action="index.php" method="post">
                        <input type="search" class="form-control" name="studentSearch" placeholder="البحث بالاسم او رقم الهوية">
                        <input type="hidden" name="dtid" value="<?php echo $_POST['dtid'];?>">
                    </form>
                    <form action="index.php" method="post" class="form1">
                    <table class="table">
                        <thead>
                            <th scope="col">رقم</th>
                            <th scope="col">رقم الهوية</th>
                            <th scope="col">الاسم</th>
                            <th scope="col">الدرجة</th>
                        </thead>
                        <tbody>
                            <?php
                            $count =1;
                            echo '<input type="hidden" name="dtid" value="'.$_POST['dtid'].'">';
                            foreach($student as $d){
                                $degree = selectData('*','degree','dtype='.$_POST['dtid'].' and dstudentId='.$d['studentId']);
                                echo '<tr ';
                                if($count%2==0)
                                    echo 'class="even"';
                                if($degree == false) echo ' style="background-color:#00F;" ';
                                echo '>';
                                    echo '<td>'.$count.'</td>';
                                    echo '<td>'.$d['id'].'</td>';
                                    echo '<td>'.$d['name'].'</td>';
                                    echo '<td>';
                                        echo '<input type="number" name="'.$d['id'].'" value="';
                                        if($degree != false)
                                            echo $degree['degree'];
                                        else
                                            echo 0;
                                        echo '" min="0" max="'.$degreeName['dtmaxDegree'].'" class="form-control">';
                                    echo '</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                        <input type="submit" name="editStudentDegreeFinal" class="btn btn-primary" value="حفظ الدرجات">
                    </form>
                </div>
            </div>

            <?php
            }
            else
                echo '<h3 class=" alert alert-danger">لا سجلات الي هذه المادة</h3>';
            ?>
            <!--End Body Of This Section-->
          </div>

        </div>
    </div>
      </div>
           <?php

      }
      else if($do == 'edit_degreeType' && isset($_POST['dtid']) && isset($_POST['editDegreeType'])){
          $selectDegree = selectData('*','degreeType,course,academic_year','dtcourseId=cid and dtacademicYear = aid and dtid='.$_POST['dtid']);
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">تعديل الدرجات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>تعديل الدرجات</h4>
            </div>
            <!--Start Body Of This Section-->
            <div class="formContain">
                    <form action="index.php" method="post">
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">اسم الامتحان</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="code"  name="dtname" value="<?php echo $selectDegree['dtname']?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cname" class="col-sm-2 col-form-label">اسم المادة</label>
                            <div class="col-sm-6">
                              <select name="courseName" class="form-control">
                                <?php
                                  $courses = selectData('distinct cname','course','1 order by cname');
                                  foreach($courses as $c){
                                      echo '<option value="'.$c['cname'].'"';
                                        if($selectDegree['cname'] == $c['cname'])
                                            echo 'selected';
                                      echo '>'.$c['cname'].'</option>';
                                  }
                                  ?>
                                </select>
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="classes" class="col-sm-2 col-form-label">الصف</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="classes"  name="classes">
                                    <?php
                                    for($i=1;$i<=6;$i++){
                                        echo '<option value="'.$i.'"';
                                        if($selectDegree['clevel'] == $i)
                                            echo 'selected';
                                        echo '>';
                                            printClass($i);
                                        echo'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">الدرجة القصي</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="code"  name="maxDegree" value="<?php echo $selectDegree['dtmaxDegree'];?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester" class="col-sm-2 col-form-label">تاريخ الامتحان</label>
                            <div class="col-sm-6">
                                <input type="date" name="date" class="form-control" value="<?php echo $selectDegree['dtexamDate'];?>">
                            </div>
                          </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <input type="hidden" name="dtid" value="<?php echo $_POST['dtid'];?>">
                                <button type="submit" name="editDegreeFinal" class="btn btn-primary from-control col-sm-4">تعديل الامتحان</button>
                            </div>
                        </div>
                    </form>
                    <?php
                ?>
                </div>
            <!--End Body Of This Section-->
          </div>

        </div>
    </div>
      </div>
           <?php
      }
      else if($do == 'add_degree'){
          $step = isset($_POST['noSteps'])?$_POST['noSteps']:1;
          ?>
           <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#">اضافة الدرجات</a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>اضافة الدرجات</h4>
            </div>
            <!--Start Body Of This Section-->
            <div class="formContain <?php if(isset($_POST['noSteps']) && $_POST['noSteps']==2) echo 'choo';?>">
                <?php if($step == 1){?>
                    <form action="index.php?do=add_degree" method="post">
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">اسم الامتحان</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="code"  name="dtname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cname" class="col-sm-2 col-form-label">اسم المادة</label>
                            <div class="col-sm-6">
                              <select name="courseName" class="form-control">
                                  <option disabled selected></option>
                                <?php
                                  $courses = selectData('distinct cname','course','1 order by cname');
                                  foreach($courses as $c){
                                      echo '<option value="'.$c['cname'].'">'.$c['cname'].'</option>';
                                  }
                                  ?>
                                </select>
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="classes" class="col-sm-2 col-form-label">الصف</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="classes"  name="classes">
                                    <option disabled selected></option>
                                    <?php
                                    for($i=1;$i<=6;$i++){
                                        echo '<option value="'.$i.'">';
                                            printClass($i);
                                        echo'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">الدرجة القصي</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="code"  name="maxDegree">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester" class="col-sm-2 col-form-label">تاريخ الامتحان</label>
                            <div class="col-sm-6">
                                <input type="date" name="date" class="form-control">
                            </div>
                          </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <input type="hidden" name="noSteps" value="2">
                                <button type="submit" name="addDegree" class="btn btn-primary from-control col-sm-4">اضافة الامتحان</button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
                if($step == 2 && isset($_POST['addDegree'])){
                    $course = selectData('cid,cname,clevel,aid','course,academic_year','cname="'.$_POST['courseName'].'" and clevel='.$_POST['classes'].' and csemester=semester and aid in (select max(aid) from academic_year)');
                    // here check if this course is exist or not from course and if exist save it.
                    if($course != false){
                        $student = selectData('id,name','user,course,reg_course,academic_year','studentId=id and courseId=cid and academicYear=aid and academicYear in (select max(aid) from academic_year) and courseId='.$course['cid'],1); // get the student from reg_course
                        ?>
                        <div class="div1">
                            <h1><?php echo $course['cname'];?></h1>
                            <div class="sub">
                                <div><span>:اسم الامتحان</span> <?php echo $_POST['dtname'];?></div>
                                <div><span>:الصف الدراسي</span> <?php echo $course['clevel'];?></div>
                                <div><span>:الدرجة القصي</span> <?php echo $_POST['maxDegree'];?></div>
                            </div>
                        </div>
                        <div class="div2">
                            <!-- here will write the student and can set degree from here-->
                            <?php
                            if($student == false){
                                echo '<h3 class="text-center">لم تسجل طلبه بعد الي هذه المادة</h3>';
                            }else{
                                ?>
                            <form action="index.php" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-2">اسم الطالب</div>
                                    <div class="col-sm-6">الدرجة</div>
                                  </div>
                                <?php
                                foreach($student as $s){
                                    echo '
                                      <div class="form-group row">
                                        <div class="col-sm-2">'.$s['name'].'</div>
                                        <div class="col-sm-3">
                                            <input type="number" name="'.$s['id'].'" min="0" max="'.$_POST['maxDegree'].'" class="form-control">
                                        </div>
                                      </div>
                                    ';
                                }
                                foreach($_POST as $key=>$value){
                                    echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
                                }
                                ?>
                                <input type="hidden" name="cid" value="<?php echo $course['cid'];?>">
                                <input type="hidden" name="aid" value="<?php echo $course['aid'];?>">
                                <div class="form-group row">
                                    <div class="col-sm-2"></div>
                                    <input type="submit" name="addDegreeFinal" class="btn btn-primary" value="اضافة الدرجات">
                                </div>
                            </form>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                    }else{
                        #redirectHome('هذه المادة لم تسجل الي هذا الصف بعد','?do=add_degree','default');
                        echo 'هذه المادة لم تسجل الي هذا الصف بعد';
                    }
                    ?>

                <?php
                }
                ?>
                </div>
            <!--End Body Of This Section-->
          </div>

        </div>
    </div>
      </div>
           <?php
      }
      else if($do == 'show_student'){
          ?>

<div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#"> ضافه طالب جديد  </a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
<!--    <div class="sec_tow clear-fix student">-->
    <div class="sec_tow clear-fix student">
       <div class="add">
           <div class="titel">
             <h4>تعديل  معلومات طالب  </h4>
            <a href="index.php?do=addStudent" class="btn btn-primary">اضافة طالب جديد</a>
            </div>
           <div >
               <form action="index.php?do=show_student" enctype="multipart/form-data" method="post" class="manage-student">
                   <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter-class'])){ //filter ...
                        $noClass = $_POST['filter-class'];
                        $search_student = $_POST['search-student'];
                        if(isset($_POST['search-student']) && $_POST['search-student'] != '')
                            $noClass= 0;
                    }else{
                        $noClass = 1;
                        $search_student = '';
                    }
                    $_SESSION['do'] = $do;
                   ?>

                    <select name="filter-class" class="filter-selection form-control feat">
                        <?php
                        $count =0;
                        while($count<=6){
                            echo '<option value="'.$count.'"';
                            if($count == $noClass)
                                echo ' selected >';
                            else
                                echo '>';
                            printClass($count);
                            echo '</option>';
                            $count++;
                        }
                        ?>
                    </select>
                   <input type="hidden" value="appearShowStudent"> <!--for appear student-->
                    <input type="search" class="form-control feat" name="search-student" placeholder="بحث عن الطالب بالاسم او بارقم">

               </form>
           </div>
         <div class="adit">
           <table class="table">
            <thead>
            <tr>
                <th scope="col">الرقم</th>
                <th scope="col"><a href="?do=show_student&order=name">الاسم <i class=""></i></a></th>
                <th scope="col"><a href="?do=show_student&order=regdate">الصف <i class=""></i></a></th>
                <th scope="col"><a href="?do=show_student&order=address">العنوان <i class=""></i></a></th>
                <th scope="col"><a href="?do=show_student&order=birthday">تاريخ الميلاد <i class=""></i></a></th>
                <th scope="col"><a href="?do=show_student&order=startdate">تاريخ الدخول <i class=""></i></a></th>
                <th scope="col"><a href="#">تعديل <i class=""></i></a></th>
            </tr>
            </thead>
            <tbody>
            <?php

                $order = isset($_GET['order'])?$_GET['order']: 'startdate';
                if(!($order == 'name' || $order=='regdate'||$order=='startdate'||$order=='address'||$order=='birthday'))
                    $order = 'startdate';
                $class = isset($class)&&is_numeric($class)?$class:0;
                if($class == 0)
                    $st = '';
                else{
                    $class = date('Y')-$class-1;
                    $st = " and regdate=".$class;
                }
                echo $search_student;
                if(isset($search_student) && $search_student != ''){ // search student .. not yet ..

                    if(is_numeric($search_student)){
                        $students = selectData('*','user','groupId=1 and id='.$search_student,1);
                    }else{
                        $students = selectData("*",'user',"groupid=1 and name LIKE '%".$search_student."%'",1);
                    }
                }else{
                    $stmt = $con->prepare("select * from user where groupid =1$st order by $order");
                    $stmt->execute();
                    $students = $stmt->fetchAll();
                }
         // print_r($students);
                if($students != false && count($students) > 0){
                    $counter = 1;
                    $page = 0;
                    foreach($students as $s){
                        ?>
                            <?php $n = (date('Y')-$s['regdate'])+1; if($n != $noClass && $noClass != 0 ) continue;?>
                            <tr class=" <?php if($s['active'] == 0) echo 'not-active ';?>">
                                <td><?php echo $counter?></td>
                                <th scope="row"><a href="?do=profileStudent&id=<?php echo $s['id']?>" class="link-student"><?php echo $s['name'];?></a></th>
                                <td><?php echo printClass($n);?></td>
                                <td><?php echo $s['address'];?></td>
                                <td><?php echo $s['birthday'];?></td>
                                <td><?php echo $s['startdate'];?></td>
                                <td class="studentButton">
                                    <a href="index.php?do=editStudent&id=<?php echo $s['id'];?>#editStudentid" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    <a href="index.php?do=remove_student&id=<?php echo $s['id'];?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                                    <a href="index.php?do=profileStudent&id=<?php echo $s['id'];?>" alt="عرض المواد الحالية" class="btn btn-info"><i class="far fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php
                        $counter++;
                    }
                }else{
                    echo '<h1 class="text-center">لا يوجد هذا الطالب</h1>';
                }
                ?>
            </tbody>
        </table>
           </div>
        </div>

        </div>


<!--    </div>-->
      </div>
      <?php
      }
      else if(($do == 'editStudent' || $do == 'editTeacher') && isset($_GET['id'])){ // this page for edit student ..
          $id = is_numeric($_GET['id'])?$_GET['id']:0; // for make sure if $id is number or not
          if($do == 'editTeacher')
            $stmt = $con->prepare('select * from user where groupId=2 and id = ? limit 1');
          else
              $stmt = $con->prepare('select * from user where groupId=1 and id = ? limit 1');
          $stmt->execute(array($id));
          $row = $stmt->fetch();
          if($stmt->rowCount() != 0){ // if this id is exist in database
              ?>
<div class="col-sm-9 details editStudent">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
                <?php
                   if($do == 'editTeacher')
                       echo '<a href="#">تعديل صفحة المدرس</a>';
                    else
                        echo '<a href="#">تعديل صفحة الطالب</a>';
                   ?>

             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel" id="editStudentid">
                <?php
                   if($do == 'editTeacher')
                       echo '<h4>تعديل معلومات المدرس </h4>';
                    else
                        echo '<h4>تعديل معلومات الطالب </h4>';
                   ?>
            </div>
                <div class="profile">
                    <?php if($row['picture'] == '' || $row['picture'] == null){
                          echo '<img src="layout/img/default%20picture.jpg" alt="Default Picture">';
                      }else
                          echo '<img src="../files/img/'.$row['picture'].'" alt="Profile Picture">'; // for display picture of user and you must return to edit because this code not correct ..
                      ?>
                    <h4 class="text-center"><?php echo $row['name'];?></h4>
                </div>
                <div class="formContain">
                    <form action="index.php" method="post">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">الاسم</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="name"  name="name" value="<?php echo $row['name'];?>">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="active" class="col-sm-2 col-form-label">النشاط</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="active"  name="active">
                                    <?php
                                        $count=0;
                                        while($count<2){
                                            echo '<option value="'.$count.'"';
                                            if($row['active'] == $count)
                                                echo ' selected >';
                                            else
                                                echo '>';
                                            if($count ==0)
                                                echo 'غير نشط';
                                            else
                                                echo 'نشط';
                                            echo '</option>';
                                            $count++;
                                        }
                                    ?>
                                </select>
                            </div>
                          </div>
                        <?php
                            if($do == 'editTeacher'){
                                echo '
                                    <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">المادة</label>
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" id="description"  name="description" value="'.$row['description'].'">
                                    </div>
                                  </div>
                                ';
                                echo '
                                    <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">الادارة</label>
                                    <div class="col-sm-6"><select name="admin" class="form-control">';
                                      $check = selectData('*','admin','teacherId='.$row['id']);
                                    echo '<option value="0" ';if($check == false) echo 'selected'; echo'>مدرس</option>';
                                    echo '<option value="1" ';if($check != false) echo 'selected'; echo'>مدير</option>';
                                    echo '</select></div>
                                  </div>
                                ';
                            }
                            else{
                                $level = date('Y')-$row['regdate']+1;
                                echo '
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">الصف</label>
                                    <div class="col-sm-6">
                                      <select name="level" class="form-control">';
                                        for ($i=1;$i<=6;$i++){
                                            echo '<option ';
                                            if ($i == $level)
                                                echo 'selected';
                                            echo ' value="'.$i.'">';
                                            printClass($i);
                                            echo '</option>';
                                        }
                                      echo '</select>
                                    </div>
                                  </div>
                                ';
                            }
                        ?>

                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">التلفون</label>
                            <div class="col-sm-6">
                              <input type="number" class="form-control" id="phone"  name="phone" value="<?php echo $row['phone'];?>">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">العنوان</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="address"  name="address" value="<?php echo $row['address'];?>">
                            </div>
                          </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">الايميل</label>
                            <div class="col-sm-6">
                              <input type="email" class="form-control" id="email"  name="email" value="<?php echo $row['email'];?>">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">اسم المستخدم</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="username"  name="username" value="<?php echo $row['username'];?>">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">كلمة المرور</label>
                            <div class="col-sm-6">
                              <input type="password" class="form-control" id="password"  name="password">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="birthday" class="col-sm-2 col-form-label">تاريخ الميلاد</label>
                            <div class="col-sm-6">
                              <input type="date" class="form-control" id="birthday"  name="birthday" value="<?php echo $row['birthday'];?>">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label for="ssn" class="col-sm-2 col-form-label">الرقم القومي</label>
                            <div class="col-sm-6">
                              <input type="number" class="form-control" id="ssn"  name="ssn" value="<?php echo $row['ssn'];?>">
                            </div>
                          </div>

                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <input type="submit" name="" class="btn btn-primary col-sm-2" value="حفظ التعديل">
                          </div>
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                    </form>
                </div>

          </div>

        </div>
    </div>
      </div>
          <?php
          }else{
              echo '<div class="notExist">';
                echo '<i class="far fa-dizzy text-center"></i>';
                echo '<h1 class="text-center">عذرا .. هذا الطالب غير موجود</h1>';
              echo '</div>';
          }
      }
      else if($do == 'addStudent'){
          ?>
            <div class="col-sm-9 details">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#"> ضافه طالب جديد  </a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>اضافه معلومات طالب جديد </h4>
            </div>
            <div class="add_form">
               <form action="index.php?do=show_student" method="post">
                   <h4 class="text-center">الطالب</h4>
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="name" placeholder="الاسم بالكامل" required>
                    </div>
                    <div class="col">
                      <input type="email" class="form-control" name="email" required placeholder="الاميل الالكتروني">
                    </div>
                  </div>
                   <div class="row">
                    <div class="col">
                      <input type="date" class="form-control" name="birthday" placeholder="تاريخ الميلاد" required>
                    </div>
                    <div class="col">
                      <input type="number" class="form-control" name="phone" placeholder="رقم التلفون" required>
                    </div>
                  </div>
                   <div class="row">
                    <div class="col">
                      <input type="number" class="form-control" name="ssn" placeholder="الرقم القومي" required>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" name="address" placeholder="العنوان">
                    </div>
                  </div>
                   <div class="row">
                       <div class="col-sm-3" style="padding-top: 25px;text-align: center;">
                       <label >كلمة المرور: </label>
                       </div>
                    <div class="col">
                      <input type="text" class="form-control" name="password" value="123" placeholder="كلمة المرور" required>
                    </div>
                  </div>
                   <hr>
                   <h4 class="text-center">ولي الامر</h4>
                   <?php
                   $parents = selectData('*','user,parent','parentId=id',1);
                    if($parents != false){
                     ?>
                   <select name="parentExist" class="form-control">
                       <option value="0" display selected>ولي امر موجد مسبقا</option>
                        <?php
                        foreach($parents as $p){
                            echo '<option value="'.$p['id'].'">'.$p['name'].'</option>';
                        }
                       ?>
                   </select>
                   <?php
                    }
                   ?>
                   <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="parentName" placeholder="اسم" required>
                    </div>
                    <div class="col">
                      <input type="number" class="form-control" name="parentPhone" placeholder="رقم التلفون">
                    </div>
                  </div>
                   <div class="row">
                    <div class="col">
                      <input type="number" class="form-control" name="parentSsn" placeholder="الرقم القومي" required>
                    </div>
                    <div class="col">
                      <input type="email" class="form-control" name="parentEmail" placeholder="الايميل" required>
                    </div>
                  </div>
                   <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="parentAddress" placeholder="العنوان" required>
                    </div>
                  </div>
                   <div class="row">
                       <div class="col-sm-3" style="padding-top: 25px;text-align: center;">
                       <label >كلمة المرور: </label>
                       </div>
                    <div class="col">
                      <input type="text" class="form-control" name="password1" value="123" placeholder="كلمة المرور" required>
                    </div>
                  </div>
                   <input type="submit" class="btn" value="تسجيل" name="addNewStudent">
                </form>


              </div>
          </div>

        </div>




    </div>
      </div>

        <?php
      }
      else if(($do == 'profileStudent' || $do == 'profileTeacher') && (isset($_GET['id'])||isset($id))){ // ti will appear user info and course too ..
          if(!isset($id))
            $id = is_numeric($_GET['id'])?$_GET['id']:0;
          else
              $id = is_numeric($id)?$id:0;
          if($id == 0)
              redirectHome('هذا ID غير موجود','','default',1);
          else{
              $stmt = $con->prepare('select * from user where id=? limit 1'); // that for search about this id and make sure if he is student or teacher ..
              $stmt->execute(array($id));
              if($stmt->rowCount() == 0){ // if this id not exist in database
                  redirectHome('هذا ID غير موجود','','default',1);
              }else
                  $std = $stmt->fetch();
          }
          ?>
            <div class="col-sm-9 details profileStudent">
    <div class="">
       <div class="sec_one">
         <div class="sb2-2-2">
           <ul>
            <li class="page-back">
               <a href="<?php echo $goBack;?>" class="btn"> رجوع <i class="fa fa-backward" aria-hidden="true"></i> </a>
             </li>
             <div class="right">
               <li class="active-bre">
               <a href="#"><?php if($std['groupid'] == 1) echo 'صفحة الطالب';else echo 'صفحة المدرس'?></a>
             </li>
             <li>
                 <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> الصفحه الرئيسيه </a>
              </li>
               </div>
             </ul>
                </div>
        </div>
    <div class="sec_tow clear-fix">
        <div class="add">
           <div class="titel">
             <h4>صفحة الطالب</h4>
            </div>

                <div class="profile">
                    <img src="layout/img/default%20picture.jpg" alt="Student Picture">
                    <div class="profileTab">

                          <?php
                              // for all class and get info about it ..
                                echo '<ul class=" nav nav-tabs" id="myTab" role="tablist">';
                                for($count=1;$count<=4;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1? 'active':'';
                                    echo  '<li class="nav-item">';
                                        echo    '<a class="nav-link '.$var.'" id="'.$idNav.'" data-toggle="tab" href="#'.$idBody.'" role="tab" aria-controls="'.$idBody.'" aria-selected="true">';
                                        if($count == 1) echo 'الطالب';
                                        else if($count == 2) echo 'المواد';
                                        else if($count == 3) echo 'الدرجات';
                                        else if($count == 4) echo 'الغياب';
                                        echo '</a>';
                                    echo '</li>';
                                }
                                echo '
                                    </ul>
                                    <div class="tab-content content" id="myTabContent">
                                ';
                                for($count=1;$count<=4;$count++){
                                    $idBody = 'class'.$count;
                                    $idNav = 'class-tab'.$count;
                                    $var = $count==1?'show active':'';
                                    echo '
                                        <div class="tab-pane fade '.$var.'" id="'.$idBody.'" role="tabpanel" aria-labelledby="'.$idNav.'">';
                                    if($count == 1){
                                        ?>
                                          <div class="studentInfo">
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    الاسم
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php echo $std['name']?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    <?php if($std['groupid'] == 2) echo 'المادة';else echo 'الصف';?>
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php ?>
                                                    <?php if($std['groupid'] == 2) echo $std['description']; else printClass((date('Y') - $std['regdate'])+1);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    العنوان
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php echo $std['address']?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    العمر
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php
                                                        $date = $std['birthday'];
                                                        $str = explode('-',$date);
                                                        echo date('Y')-$str[0];
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    التلفون
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php echo $std['phone']?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    الرقم القومي
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php
                                                        echo $std['ssn'];
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    التفعيل
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php if($std['active']==1) echo 'نشط';else echo 'غير نشط';?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    تاريخ الميلاد
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php
                                                        echo $std['birthday'];
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    الايميل
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php
                                                        echo $std['email'];
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-sm-2">
                                                    تاريخ الدخول
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php echo $std['startdate']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <a class="btn btn-primary col-sm-4" href="?do=editTeacher&id=<?php echo $std['id'];?>">تعديل البيانات</a>
                                        </div>

                                    </div>
                                        <?php
                                    }
                                    else if($count == 2){
                                        ?>
                                      <div class="studentCourse">
                                          <div class="adit">
                                        <?php
                                            if($std['groupid'] == 1){ // student ..
                                                $stmt = $con->prepare('select cname,cid,aid from reg_course,user,course,academic_year where id=? and id=studentId and cid=courseId and aid=academicYear and aid in (SELECT max(aid) from academic_year )');
                                                $stmt->execute(array($std['id']));
                                                $courses = $stmt->fetchAll();
                                                if($stmt->rowCount() > 0){
                                                    ?>
                                                    <table class="table">
                                                        <thead>
                                                            <th scope="col">اسم المادة</th>
                                                            <th scope="col">اسم المدرس</th>
                                                        </thead>
                                                        <tbody>
                                                  <?php
                                                    foreach($courses as $c){
                                                        $stmt = $con->prepare('select name from user,reg_teacher where id=rtteacherId and rtcourseId=? and rtacademicYear=? limit 1');
                                                        $stmt->execute(array($c['cid'],$c['aid']));
                                                        $t= $stmt->fetch();
                                                        if ($stmt->rowCount() != 1)
                                                            $t['name'] = '<span class="alert-not">لم تسجل المادة بعد .. </span>'

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $c['cname'];?></td>
                                                                <td><?php echo $t['name'];?></td>
                                                            </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                        </tbody>
                                                    </table>
                                                  <?php
                                                }else{
                                                    echo '<h1 class="text-center">لم يتم تسجيل مواد الي هذا الطالب بعد</h1>';
                                                }
                                            }else if($std['groupid'] == 2){ // teacher ..
                                                $stmt = $con->prepare('select distinct yearId,id,name,clevel,cid,cname from user,course,reg_teacher,academic_year where rtteacherId=id and id=? and rtcourseId=cid and rtacademicYear in (select max(aid) from academic_year)');
                                                $stmt->execute(array($std['id']));
                                                $data = $stmt->fetchAll();
                                                if($stmt->rowCount() > 0){
                                                    echo '<table class="table">
                                                        <thead>
                                                            <th scope="col">اسم المادة</th>
                                                            <th scope="col">الفصل</th>
                                                            <th scope="col">الترم</th>
                                                        </thead>
                                                        <tbody>';
                                                        foreach($data as $d){
                                                            echo '<tr>';
                                                                echo '<td>'.$d['cname'].'</td>';
                                                                echo '<td>'.$d['clevel'].'</td>';
                                                                echo '<td>'.$d['yearId'].'</td>';
                                                            echo '</tr>';
                                                        }
                                                    echo '</tbody>
                                                    </table>';
                                                }else{
                                                    echo '<h2 class="text-center">لم يتم تسجيل مواد الي هذا المدرس بعد ... </h2>';
                                                }
                                                echo '<button class="btn btn-primary edit" onclick="addCourseTeacher()">اضافة او حذف مواد</button>';
                                            }
                                          ?>
                                      </div>
                                    <div class="displayNone">
                                        <div class="fixedContainer">
                                            <div class="close-button"><button class="fa fa-times" onclick="closeFixed()"></button></div>
                                            <h1 class="text-center">تعديل المواد للمدرس</h1>
                                            <div class="subjectContent">
                                                <?php
                                                $stmt = $con->prepare('select rtid,cname,semester,clevel,cid,aid from reg_teacher,course,academic_year where rtteacherId=? and cid=rtcourseId and rtacademicYear in (select max(aid) from academic_year)');
                                                $stmt->execute(array($std['id']));
                                                $rows = $stmt->fetchAll();
                                                if($stmt->rowCount() > 0){
                                                ?>
                                                    <table class="table">
                                                        <thead>
                                                            <th scope="col">اسم المادة</th>
                                                            <th scope="col">الصف</th>
                                                            <th scope="col">حذف</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($rows as $t){ // here for process to delete subject from reg_teacher .. by php
                                                                    echo '<tr>';
                                                                        echo '<td>'.$t['cname'].'</td>';
                                                                        echo '<td>'.$t['clevel'].'</td>';
                                                                        echo '<td>
                                                                        <form action="index.php" method="post">
                                                                            <input type="hidden" value="'.$t['rtid'].'" name="post1">
                                                                            <input type="hidden" value="'.$std['id'].'" name="studentId">
                                                                            <button type="submit"  class="btn btn-danger">حذف</button>
                                                                        </form>
                                                                        </td>';
                                                                    echo '</tr>';
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                <?php
                                                }else{
                                                    echo "none";
                                                }
                                                ?>
                                            </div>

                                                 <?php //subject never register until
                                                    $stmt = $con->prepare('select * from course,user where cname=description and id=? and cid not in (select rtcourseId from reg_teacher,academic_year where rtacademicYear in (select max(aid) from academic_year))'); // this selection it's very important for register ..
                                                    $stmt->execute(array($std['id']));
                                                    $rows = $stmt->fetchAll();
                                                    if($stmt->rowCount() > 0){
                                                        ?>
                                                        <from action="index.php" method="POST">
                                                            <select name="subject" class="form-control filter-selectios">
                                                                <?php
                                                                    foreach($rows as $r){
                                                                        echo '<option value="'.$r['cid'].'">'.$r['cname'].' -
                                                                        '.$r['clevel'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="student" value="<?php echo $std['id'];?>">
                                                            <button type="submit" name="regTeacher" class="btn btn-primary" value="">اضافة</button>
                                                        </from>
                                                <?php }else{ // where this teacher can't register this subject because not subject leave to register ..
                                                        echo '<div class="alert alert-info">كل المواد مسجلة</div>';
                                                    }
                                                ?>

                                        </div>
                                    </div>
                                  </div>
                                        <?php
                                    }
                                    else if($count == 3){
                                        ?>
                                        <div class="sub23">
                                            <h1 class="text-center">الدرجات</h1>
                                            <div class="student-info text-center">
                                                <div class="">الاسم : <span><?php echo $std['name'];?></span></div>
                                                <div>رقم الهوية : <span><?php echo $std['id'];?></span></div>
                                            </div>
                                                <?php
                                                $academic = selectData('*','academic_year','1 order by aid desc limit 1');
                                                if($academic != false){
                                                    $degreeNames = selectData('*','degreetype,course','dtcourseId=cid and clevel='.(date('Y')-$std['regdate']+1).' and dtacademicYear='.$academic['aid'].' order by cid',1);
                                                    if($degreeNames != false){
                                                        $c =1;
                                                        echo '<table class="table">';
                                                            echo '<thead class="color">';
                                                                echo '<th scope="col">رقم</th>';
                                                                echo '<th scope="col">اسم المادة</th>';
                                                                echo '<th scope="col">رقم الامتحان</th>';
                                                                echo '<th scope="col">الاسم الامتحان</th>';
                                                                echo '<th scope="col">التاريخ</th>';
                                                                echo '<th scope="col">الدرجة</th>';
                                                                echo '<th scope="col">الدرجة القصوي</th>';
                                                            echo '</thead>';
                                                        $pro = 0;
                                                        $c1=1;
                                                        echo '<tbody>';
                                                        foreach($degreeNames as $d){
                                                            $degree = selectData('degree','degree','dtype='.$d['dtid'].' and dstudentId='.$std['id'].' limit 1');
                                                            echo '<tr ';
                                                            if($c%2==0) echo 'class="even" ';
                                                            echo '>';
                                                                if($pro == $d['cid']) $c1++;
                                                                echo '<td>'.$c.'</td>';
                                                                echo '<td>'.$d['cname'].'</td>';
                                                                echo '<td>'.$c1.'</td>';
                                                                echo '<td>'.$d['dtname'].'</td>';
                                                                echo '<td>'.$d['dtexamDate'].'</td>';
                                                                echo '<td>';
                                                                if($degree != false) echo $degree['degree'];
                                                                else echo 'غ';
                                                                echo '</td>';
                                                                echo '<td>'.$d['dtmaxDegree'].'</td>';
                                                            echo '</tr>';
                                                            $c++;
                                                            $pro = $d['cid'];
                                                        }
                                                        echo '</tbody>';
                                                        echo '</table>';
                                                    }else
                                                        echo '<h4 class="text-center alert alert-warning">لا يوجد درجات مسجله هنا</h4>';
                                                }else{
                                                    echo '<h4 class="text-center alert alert-warning">لا يوجد ترم مسجل</h4>';
                                                }
                                                ?>
                                        </div>
                                        <?php
                                    }
                                    else if($count == 4){
                            $check = selectData('*','academic_year','1 order by aid desc limit 1');
                            if($check != false){
                                $absence = selectData('*','absence,absence_day','aadid=adid and abstudentId='.$std['id'].' and adacademicYear='.$check['aid'].' order by day desc',1);
                                $countAbsence = selectData('count(*)','absence_day','adacademicYear='.$check['aid']);
                                if($absence == false)
                                    $persent = 0;
                                else{
                                    $persent = (count($absence)*100)/$countAbsence[0];
                                }
                            ?>
                            <div class="absence-info">
                                <h1 class="text-center">الغياب</h1>
                                <div class="info">
                                    <div>الاسم : <span><?php echo $std['name'];?></span></div>
                                    <div>رقم الهوية : <span><?php echo $std['id'];?></span></div>
                                    <div>نسبة الغياب : <span><?php echo $persent.'%';?></span></div>
                                </div>
                            </div>
                            <?php
                            if($absence == false){
                                echo '<h4 class="text-center alert alert-info">لا يوجد ايام مسجلة الي هذا الطالب</h4>';
                            }
                            else{
                        ?>
                        <div class="absence-list sub23">
                                <table class="table">
                                    <thead class="color">
                                        <th scope="col">رقم</th>
                                        <th scope="col">يوم</th>
                                        <th scope="col">التاريخ</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $c=1;
                                        foreach($absence as $a){
                                            echo '<tr ';
                                            if($c%2==0) echo 'class="even"';
                                            echo '>';
                                                echo '<td>'.$c.'</td>';
                                                echo '<td>'.day(date('D', strtotime($a['day']))).'</td>';
                                                echo '<td>'.$a['day'].'</td>';
                                            echo '</tr>';
                                            $c++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            }else
                                echo '<h4 class="text-center alert alert-info">لا يوجد اي فصل دراسي مسجل</h4>';
                                    }
                                    echo '</div>';
                                }
                                echo '</div>';
                            ?>
                    </div>

          </div>

        </div>




    </div>
      </div>

        <?php
      }
      else{
          echo '<h1 class="text-center">'.$do.'</h1><br>';

      }
      echo '<div class="popPage">
            <div class="scontainer">
                <h1 class="text-center">Here</h1>
            </div>
        </div>';
      ?>
    </div>
</section>
<?php
include $tpl.'footer.php';
?>
