<?php
// Connects to the Database 
include('connect.php');
if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 'true' ){
	header("Location: index.php");
}
	
	//if the login form is submitted 
	if (isset($_POST['submit'])) {
		
		if(!$_POST['username'] | !$_POST['password']) {
			print '<p>You did not fill in a required field.
			Please go back and try again!</p>';
		}

		if($stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ? AND pass = ?")){
			$stmt->bind_param('ss',$username, $password);

			$username = $mysqli->real_escape_string($_POST['username']);
			$password = hash('sha256', $username.$_POST['password']);

			$stmt->execute();

			$stmt->bind_result($user);

			if($stmt->fetch()){
				session_regenerate_id();
				$_SESSION['csrf_token'] = hash('sha256', session_id().rand().microtime());
				$_SESSION['username'] = htmlspecialchars($user, ENT_QUOTES);
				$_SESSION['logged_in'] = 'true';
				header("Location: members.php");	
			}
			else{
				die("<p>Invalid login or password.</p>");
			}
			$stmt->close();
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
?>
<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
        <h2 class = "title">hackme bulletin board</h2>
        	<?php
        	  	print "<p>Logged in as <a>".$_SESSION['username']."</a></p>";
            ?>
        </div>
    </div>
</div>

<?php
	if($stmt = $mysqli->prepare("SELECT * FROM threads ORDER BY date DESC")){
		$stmt->execute();
		$stmt->bind_result($id, $username, $title, $message, $date);
		
		while($stmt->fetch()){
			
		echo'<div class="post">
			<div class="post-bgtop">
			<div class="post-bgbtm">
			<h2 class="title">
				<a href="show.php?pid='.htmlspecialchars($id, ENT_QUOTES).'">'.htmlspecialchars($title, ENT_QUOTES).'</a></h2>
				<p class="meta"><span class="date">'.date('l, d F, Y',htmlspecialchars($date, ENT_QUOTES)).' - Posted by <a href="#">'.htmlspecialchars($username, ENT_QUOTES).'</a></p>
			</div>
			</div>
			</div>'; 
		}
		$stmt->close();
	}

	include('footer.php');
?>
</body>
</html>
