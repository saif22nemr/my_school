


<section class="nav_top_sec">
  <div class="container-fluid sb1">
        <div class="row">
            <!--== LOGO ==-->
            <div class="col-md-2 col-sm-3 col-xs-6 sb1-1">
                <div class="logo">
                    <img src="layout/img/logo.png" alt="">
                </div>
            </div>
            <!--== SEARCH ==-->
            <div class="col-md-6 col-sm-6 mob-hide">
                <form class="app-search">
                    
                </form>
            </div>
            <!--== NOTIFICATION ==-->
<!--
            <div class="col-md-2 tab-hide">
                <div class="top-not-cen">
                    <a class="waves-effect btn-noti" href="admin-all-enquiry.html" title="all enquiry messages"><i class="far fa-comments"></i><sup>5</sup></a>
                    <a class="waves-effect btn-noti" href="admin-course-enquiry.html" title="course booking messages"><i class="far fa-envelope"></i><sup>5</sup></a>
                    <a class="waves-effect btn-noti" href="admin-admission-enquiry.html" title="admission enquiry"><i class="fa fa-tag" aria-hidden="true"></i><sup>5</sup></a>
                </div>
            </div>
-->
            <!--== MY ACCCOUNT ==-->
            <div class="col-md-2 col-sm-3 col-xs-6" style="margin-right:auto">
                <!-- Dropdown Trigger -->
             <a class="waves-effect dropdown-button top-user-pro" href="#" data-activates="top-          menu">
                <img src="layout/img/default%20picture.jpg" alt="">
                </a>
                <div class="dropdown ">
                  <button class=" dropdown-toggle top-user-pro" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['Username'];?>
                    </button>
                   <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                    <a class="dropdown-item" href="?do=profile$id="><i class="fas fa-cogs"></i>الصفحة الشخصية </a>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-in-alt"></i>تسجيل خروج </a>
                    
                    </div>
                 </div>

                <!-- Dropdown Structure -->
                
            </div>
        </div>
    </div>  
    
    </section>