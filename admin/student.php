<?php
session_start();
include 'init.php';
if(isset($_SESSION['Username'])){
    
}else{
    header('Location: login.php');
    exit();
}
?>
<section class="student">
    <section class="main-container">
        <section class="content">

              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">الطلاب الجدد</span>
                      <span class="info-box-number">1,410</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="far fa-grin"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">نشاط الطلابي</span>
                      <span class="info-box-number">410</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="far fa-bell-slash"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">الغياب اليومي</span>
                      <span class="info-box-number">13%</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fas fa-user-graduate"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">عدد الطلاب</span>
                      <span class="info-box-number">93,139</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

        </section>
        <section class="setting">
            <div class="card">
                <div class="card-header text-center">
                    <h2>الطالب</h2>
                </div>
                <div class="card-body">
                        <from class="student-search" action="index.php" method="get">
                            <input type="text" name="studentSearch" placeholder="بحث عن طالب .. ">
                            <input type="submit" style="display:inline">
                        </from>
                    <div class="contents">
                        <a href="#">تسجيل طلاب</a>
                        <a href="#">تسجيل طلاب</a>
                        <a href="#">تسجيل طلاب</a>
                        <a href="#">تسجيل طلاب</a>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
<?php
include $tpl.'footer.php';
?>