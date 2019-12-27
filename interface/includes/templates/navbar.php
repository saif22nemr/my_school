<div class="upper-bar">
     <div class="container-fluid">    
      <div class="row">    
        <div class="info">
            <ul class="list-unstyled">
                <li><i class="far fa-envelope"></i>liber@info.com</li>
                <li><i class="fas fa-phone"></i>012 365 4798</li>
            </ul>
        </div>
        <div class="social-media">
            <ul class="list-unstyled">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            </ul>
        </div>
         </div>
        </div>
    </div>
    <!-- End Upper-bar -->
    <!-- Start Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav navsen">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">الرئيسية</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php#team">فريق العمل</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="about.php">من نحن</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="events.php">الفعاليات</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="ads.php">الاعلانات</a>
                </li>
                <?php
                if(!isset($_SESSION['Username1']))
                    echo '<li class="nav-item active">
                    <a class="nav-link" href="login.php">تسجيل دخول</a>
                </li>';
                
                ?>
                
            </ul>
        </div>
        <?php 
            if(!isset($_SESSION['Username1']))
                echo '<div class="logo"><img src="layout/imgs/logo.png"></div>';
            else{
                if (isset($_SESSION['GroupID1']) && $_SESSION['GroupID1'] == 2)
                    $type = 'teacher';
                else if (isset($_SESSION['GroupID1']) && $_SESSION['GroupID1'] == 1)
                    $type = 'student';
                else if (isset($_SESSION['GroupID1']) && $_SESSION['GroupID1'] == 3)
                    $type = 'parent';
                echo '<div class="username"><a href="'.$type.'.php">'.$_SESSION['Username1'].'</a> | <a href="logout.php">تسجيل الخروج</a></div>';
            }
        ?>
    </nav>