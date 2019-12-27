<?php
function redirectHome($errorMes='Error Message',$url = null,$statu = 'default',$seconds=2){
	if($url === null)
		$url = 'index.php';
	elseif($url == 'back' || $url == '')
		$url = isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER'] != ''? $_SERVER['HTTP_REFERER']:'index.php';
	if($statu == 'default'){
	?>
		<div class="errorPages">
			<div class="mainContainer">
				<h2 class="text-center">تنبية</h2>
				<div class="text-center"><?php echo $errorMes?></div>
			</div>
		</div>
	<?php
	}
	else{
		?>
			<div class="errorPages">
				<div class="mainContainer else">
					<h2 class="text-center">تنبية</h2>
					<?php echo $errorMes?>
				</div>
			</div>
		<?php
	}
	header("refresh:$seconds; $url");
	exit();
}
function printClass($var){
    if($var == 1)
        echo 'الصف الاول';
    else if($var == 2)
        echo 'الصف الثاني';
    else if($var == 3)
        echo 'الصف الثالث';
    else if($var == 4)
        echo 'الصف الرابع';
    else if($var == 5)
        echo 'الصف الخامس';
    else if($var == 6)
        echo 'الصف السادس';
    else if($var == 0)
        echo 'كل';
    else
        echo 'لا';
}
function day($v,$num=0){
    if($v == 'Sat' || $num==1)
        return 'السبت';
    else if($v == 'Sun' || $num==2)
        return 'الاحد';
    else if($v == 'Mon'  || $num==3)
        return 'الاثنين';
    else if($v == 'Tue' || $num==4)
        return 'الثلاثاء';
    else if($v == 'Wed' || $num==5)
        return 'الاربعاء';
    else if($v == 'Thu' || $num==6)
        return 'الخميس';
    else if($v == 'Fri' || $num==7)
        return 'الجمعة';
    else 
        return $v;
}
function uploadfile($origin, $dest, $tmp_name)
{
  $origin = strtolower(basename($origin));
  $fulldest = $dest.$origin;
  $filename = $origin;
  $extension = pathinfo($filename, PATHINFO_EXTENSION);
  if(!file_exists($fulldest)){
      if (move_uploaded_file($tmp_name, $fulldest)){
          global $con;
          $stmt = $con->prepare("insert into upload (name,destination,extension) values (?,?,?)");
          $stmt->execute(array($filename,$fulldest,$extension));
          if($stmt->rowCount()== 1 )
              echo "<br>Inserted .. <br>";
          return true;
      }
      return false;
  }else
      return false;

}
?>