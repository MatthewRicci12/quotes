<!-- AUTHOR: Matthew Ricci -->
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<h1>Register</h1>

<div class="logging_in">
<div class="padding">
	<form class="padelements" id="form" action="controller.php" method="post">
	<input placeholder="Username" class="padelements" name="username" required><br>
	<input type="password" placeholder="Password" class="padelements" name="password" required><br>
	<input type="submit" name="register" value="Register">
    <?php
    session_start();
    if(isset($_SESSION ['accountNameTaken']))
      echo $_SESSION ['accountNameTaken'];
    unset($_SESSION ['accountNameTaken']);
    ?>
	</form>
</div>
</div>
</html>