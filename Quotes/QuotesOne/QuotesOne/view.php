<!-- 
This is the home page for Final Project, Quotation Service. 
It is a PHP file because later on you will add PHP code to this file.

File name quotes.php 
    
Authors: Rick Mercer and Matthew Ricci
-->
<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="showQuotes()">

<h1>Quotation Service</h1>
<?php 
 session_start();
 echo '&nbsp; <a href="./register.php" ><button>Register</button></a>';
 echo '&nbsp; <a href="./login.php" ><button>Login</button></a>';
 echo '&nbsp; <a href="./addQuote.html" ><button>Add Quote</button></a>';
 
 if (isset($_SESSION['user'])) {
     $user = $_SESSION['user'];
     echo '<h4>Hello ' . $user . '</h4>';
 }
?>

<div id="quotes">
</div>

<script>
var elementToChange = document.getElementById("quotes");

function showQuotes() {
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "controller.php?todo=getQuotes");
	ajax.send();
	ajax.onreadystatechange = function() {
	if (ajax.readyState == 4 && ajax.status == 200) {
		array = ajax.responseText;
		console.log(array);
		elementToChange.innerHTML = array;
	}

	} // End function showQuotes
}
</script>

</body>
</html>