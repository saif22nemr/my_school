<?php

/*
	Title Function for get title from other pages
*/


function links(){
    if(isset($_SESSION['Username'])&&isset($_SESSION['GroupID'])){
        if($_SESSION['GroupID'] == 2)
            echo "teacher.php";
        elseif($_SESSION['GroupID'] == 1)
            echo "student.php";
        elseif($_SESSION['GroupID'] == 3)
            echo "parent.php";
        else
            echo "#";
    }else{
        header('Location: index.php');
        exit();
    }
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
function isExist($table,$condition){
    global $con;
    $stmt = $con->prepare('select count(*) from '.$table.' where '.$condition);
    $stmt->execute();
    if($stmt->rowCount() > 0)
        return true;
    return false;
}
function deleteData($table,$condition){
    global $con;
    $stmt = $con->prepare('DELETE FROM '.$table.' WHERE '.$condition);
    $stmt->execute();
    if($stmt->rowCount() == 0)
        return false;
    return true;
}
function day($v='',$num=0){
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
// this function for update files from web pages
function uploadFile($origin, $dest, $tmp_name,$title,$type,$description)
{
    /*
        - origin : the original picture [name]
        - dest : for destination
        - temp : this for temp of this file
    */
  $origin = strtolower(basename($origin));
  $fulldest = $dest.$origin;
  $filename = $origin;
  $extension = pathinfo($filename, PATHINFO_EXTENSION);
  if(!file_exists($fulldest)){
      if (move_uploaded_file($tmp_name, $fulldest)){
          global $con;
          $stmt = $con->prepare("insert into upload (name,destination,extension,title,type,description) values (?,?,?,?,?,?)");
          $stmt->execute(array($filename,$fulldest,$extension,$title,$type,$description));
          if($stmt->rowCount()== 1 )
              echo "<br>Inserted .. <br>";
          else
              echo "error" ; 
          return true;
      }
      return false;
  }else
      return false;

}

// function for download file ... 
function downloadFile($name,$path){
    $id = $name;

    // fetch file to download from database
    $sql = "SELECT * FROM upload WHERE name=?";
    $stmt = $con->prepare($sql);
    $stmt->execute(array($id));
    $file = $stmt->fetch();
    if($stmt->rowCount() != 0){
        $filepath = '../files/' .$path.'/'. $file['name'];
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize('../files/'.$path. $file['name']));
            readfile('uploads/' . $file['name']);

            // Now update downloads count

            exit();
        }
    }
}
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
?>
