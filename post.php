<?php
// Connects to the Database 
include('connect.php');
if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 'true' ){
	header("Location: index.php");
}

	
	//if the login form is submitted 
	if (isset($_POST['post_submit'])) {
		if($_SESSION['csrf_token'] == $_POST['CSRF_Token']){
			$_POST['title'] = trim($_POST['title']);
			if(!$_POST['title'] | !$_POST['message']) {
				include('header.php');
				die('<p>You did not fill in a required field.
				Please go back and try again!</p>');
			}
			if($stmt = $mysqli->prepare("INSERT INTO threads (username, title, message, date) VALUES(?, ?, ?, ?)")){
				$stmt->bind_param('ssss',$username,$title,$message,$time);

				$username = $_SESSION['username'];
				$title = $mysqli->real_escape_string($_POST['title']);
				$message = $mysqli->real_escape_string($_POST['message']);
				$time = time();

				$stmt->execute();
			}
			header("Location: members.php");
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
				print"<p>Logged in as <a>".$_SESSION['username']."</a></p>";
			?>
            
            <h2 class="title">NEW POST</h2>
            <p class="meta">by <a href="#"><?php echo $_SESSION['username']; ?></a></p>
            <p> do not leave any fields blank... </p>
            
            <form method="post" action="post.php">
            Title: <input type="text" name="title" maxlength="50" required/>
            <br />
            <br />
            Posting:
            <br />
            <br />
            <textarea name="message" cols="120" rows="10" id="message" required></textarea>
            <br />
            <br />
            <input type="hidden" name="CSRF_Token" value="<?php echo $_SESSION['csrf_token']; ?>" >
            <br />
            <br />
            <input name="post_submit" type="submit" id="post_submit" value="POST" />
            </form>
        </div>
    </div>
</div>

<?php
	include('footer.php');
?>
</body>
</html>
