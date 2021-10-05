<?php
session_start();
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

if(isset($_SESSION['username'])){
	$user_name = $_SESSION['username'];
}else{
	$user_name = "";
}

// LANGUAGE SELECTOR
if(!isset($_COOKIE["Language"])) {
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	setcookie("Language", $lang, time() + (86400 * 7), ""); // 86400 = 1 day *7 on "/" entire website
	$_COOKIE["Language"] = $lang;
}
if($_COOKIE["Language"]=="fr"){
	include("languages/FR.php");	
}else if($_COOKIE["Language"]=="en"){
	include("languages/EN.php");
}
$langs = [
	"fr"=>"Français",
	"en"=>"English"];
// END LANGUAGE SELECTOR

// LOGIN USER
if (isset($_POST['login'])){
    unset($_POST['login']);
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['pass']);
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

// BLOG POST
if (isset($_POST['blogpost'])&&$user_name!=""){
	$title = mysqli_real_escape_string($db, $_POST['title']);
	$content = mysqli_real_escape_string($db, $_POST['content']);
	unset($_POST['blogpost']);
	$user_check_query = "INSERT INTO posts (title, content) VALUES('$title', '$content')";
	$result = mysqli_query($db, $user_check_query);
	echo $result;
}
// END BLOG POST

// GET POSTS NUMBER
function GetPostsNumber(){
	$db = mysqli_connect('localhost', 'root', '', 'registration');
	$user_check_query = "SELECT COUNT(*) FROM posts;";//Select actual user infos
	$result = mysqli_query($db, $user_check_query);
	$result = mysqli_fetch_assoc($result);
	return $result['COUNT(*)'];
}
// END GET POSTS NUMBER

// GET POSTS
if (isset($_POST['getposts'])){
	$maxID = $_POST['getposts'];
	unset($_POST['getposts']);
	$minID = mysqli_real_escape_string($db, $maxID-5);
	$maxID = mysqli_real_escape_string($db, $maxID+1);
	$user_check_query = "SELECT date, title, content FROM posts WHERE id<'$maxID' AND id>'$minID'";//Select actual user infos
	$result = mysqli_query($db, $user_check_query);
	$return = "";
	while($row = mysqli_fetch_assoc($result)){
		$return = $return.$row['content'].";".$row['title'].";".$row['date'].";;";//Send them in a ";" separated string
	}		
	echo $return;
}
// END GET POSTS