<div class="col-sm-3 sidebar"> 
        <div class="aside">
    <!----- satrt side_nav ---------->
          <ul class="list-group" id="asideActive">
            <div class="info text-center">
                <img src="layout/img/default%20picture.jpg">
                <h2><?php echo $_SESSION['Username'];?></h2>
            </div>
              <?php
              if (isset($do)){
                  $val = explode('_',$do);
              }
              ?>
              <li class="list-group-item <?php if(!isset($do) || $do == 'main_page') echo 'active';?>"><a href="index.php" class="link">الرئيسية<i class="fas fa-arrow-left"></i></a></li>
            <li class="list-group-item <?php if($do=='manage_student' || $val[0] == 'manage') echo 'active';?> "><a href="?do=manage_student" class="link">الدرجات والغياب<i class="fas fa-arrow-left"></i></a>
            </li>
              <li class="list-group-item <?php if($do=='show_schedule' || $val[1] == 'schedule') echo 'active';?>"><a class="link" href="?do=show_schedule" class="link">الجدول  <i class="fas fa-arrow-left"></i></a></li>
              <li class="list-group-item <?php if($do=='show_course' || $val[1] == 'course') echo 'active';?>"><a class="link" href="?do=show_course" class="link">المواد <i class="fas fa-arrow-left"></i></a></li>
            <li class="list-group-item <?php if($do=='show_teacher' || $val[1] == 'teacher') echo 'active';?>"><a class="link" href="?do=show_teacher" class="link">المدرسين <i class="fas fa-arrow-left"></i></a>
            </li>
              <li class="list-group-item <?php if($do=='show_student') echo 'active';?>"><a class="link" href="?do=show_student" class="link">الطلاب  <i class="fas fa-arrow-left"></i></a></li>
              <li class="list-group-item <?php if($do=='show_event') echo 'active';?>"><a class="link" href="?do=show_event" class="link">الفعاليات  <i class="fas fa-arrow-left"></i></a></li>
        </ul>
        </div>
      </div>