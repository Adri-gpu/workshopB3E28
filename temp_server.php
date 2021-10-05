<?php
session_start();
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

if(isset($_SESSION['username'])){
	$user_name = $_SESSION['username'];
}else{
	$user_name = "";
}

// LOGIN USER
if (isset($_POST['login'])){
    unset($_POST['login']);
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	//have to check password security
	$password = md5($password);
	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$result = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) == 1) {
		//Log in V
		$_SESSION['username'] = $user['username'];
		echo $user['username'];
	}else{
		echo "Erreur : Mauvais nom de compte/Mot de passe.";
	}
} 
// END LOGIN USER

// LOGOUT USER
if (isset($_POST['logout'])) {
    unset($_SESSION['username']);
    $_SESSION = array();
    session_unset();
    session_destroy();
}
// END LOGOUT USER