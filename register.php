<?php
    include('connect.php');
    include('header.php');



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>hackme</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
        <h2 class = "title">hackme Registration</h2>
        <?php

		//if the registration form is submitted 
		if(isset($_POST['submit'])){
			
			$_POST['uname'] = trim($_POST['uname']);
			if(!$_POST['uname'] | !$_POST['password'] |
				!$_POST['fname'] | !$_POST['lname']) {
 				die('<p>You did not fill in a required field.
				Please go back and try again!</p>');
 			}
			
            if($stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?")){
                $stmt->bind_param('s', $username);

                $username = $mysqli->real_escape_string($_POST['uname']);

                $stmt->execute();
                if($stmt->fetch()){
                    die("Username already exists");
                }
                else{ 
                    if($stmt2 = $mysqli->prepare("INSERT INTO users (username, pass, fname, lname) VALUES (?, ?, ?, ?)")){
                        $stmt2->bind_param('ssss',$username,$password,$fname,$lname);

                        $username = $mysqli->real_escape_string($_POST['uname']);
                        $password = hash('sha256', $username.$_POST['password']);
                        $fname = $mysqli->real_escape_string($_POST['fname']);
                        $lname = $mysqli->real_escape_string($_POST['lname']);

                        $stmt2->execute();

                        if(!$stmt2->fetch()){
                            echo "<h3> Registration Successful!</h3> <p>Welcome, $fname! Please log in...</p>";
                        }
                    $stmt2->close();
                    }
                }
                
                $stmt->close();
            }
        ?>    
        <?php
		}else{
        ?>
        	<form  method="post" action="register.php">
            <table>
                <tr>
                    <td> Username </td> 
                    <td> <input type="text" name="uname" maxlength="20" required/> </td>
                    <td> <em>choose a login id</em> </td>
                </tr>
                <tr>
                    <td> Password </td>
                    <td> <input type="password" name="password" required/> </td>
                </tr>
                <tr>
                    <td> First Name </td>
                    <td> <input type="text" name="fname" maxlength="25" required/> </td>
                </tr>
                 <tr>
                    <td> Last Name </td>
                    <td> <input type="text" name="lname" maxlength="25" required/> </td>
                </tr>
                <tr>
                    <td> <input type="submit" name="submit" value="Register" /> </td>
                </tr>
            </table>
            </form>
        <?php
		}
		?>
        </div>
    </div>
</div>
<?php
	include('footer.php');
?>
</body>
</html>