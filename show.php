<?php
// Connects to the Database 
include('connect.php');
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 'true' ){
    header("Location: index.php");
}
	if (isset($_POST['delete_submit'])){
		if($_SESSION['csrf_token'] == $_POST['CSRF_Token']){
			if($stmt = $mysqli->prepare("DELETE FROM threads WHERE id = ?")){
				$stmt->bind_param('i',$id);

				$id = $mysqli->real_escape_string($_POST['delpid']);
				$stmt->execute();
			
				$stmt->close();
				header("Location: members.php");
			}
		}
	}
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>hackme</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<?php
	include('header.php');
	print "<p>Logged in as <a>".$_SESSION['username']."</a></p>";

	if($stmt = $mysqli->prepare("SELECT * FROM threads WHERE id = ? LIMIT 1")){
		$stmt->bind_param('i',$id);

		$id = $mysqli->real_escape_string($_GET['pid']);

		$stmt->execute();
		$stmt->bind_result($id, $username, $title, $message, $date);

		if($stmt->fetch()){

			echo '<div class="post">
				<div class="post-bgtop">
				<div class="post-bgbtm">
				<h2 class="title"><a href="show.php?pid='.htmlspecialchars($id, ENT_QUOTES).'&token='.hash('sha256', uniqid($_SESSION['username'], true)).'">'.htmlspecialchars($title, ENT_QUOTES).'</a></h2>
				<p class="meta"><span class="date">'.date('l, d F, Y',htmlspecialchars($date, ENT_QUOTES)).' - Posted by <a href="#">'.htmlspecialchars($username, ENT_QUOTES).'</a></p>

				<div class="entry">
					'.htmlspecialchars($message, ENT_QUOTES).'
				</div>

				</div>
				</div>
				</div>';

			if($_SESSION['username']==$username){
				echo '
				<form method="post" action="show.php">
				<input type="hidden" name="delpid" value="'.$id.'" />
				<input type="hidden" name="CSRF_Token" value="'.$_SESSION['csrf_token'].'" />
				<input type="submit" name="delete_submit" value="DELETE" />
				</form>
				';
			}
		}
		$stmt->close();
	}
	include('footer.php');
?>
</body>
</html>