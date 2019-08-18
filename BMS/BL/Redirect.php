<?php 

class Redirect {

public function checkAdminSession() {
	$isAdmin = false;
	if (isset($_SESSION['admin'])) {
		$isAdmin = true;
	}
	return $isAdmin;
}
public function redirectAdmin() {
	$sesAdmin = $this->checkAdminSession();
	if (!$sesAdmin) {
		header("Location: ../landing/login.php");
		exit();
	}
}

public function checkUserSession() {
	$isUser = false;
	if (isset($_SESSION['admin'])) {
		$isUser = true;
	} else {

	if (isset($_SESSION['user'])) {
		$isUser = true;
	}
	if ($_SESSION['user'] != $_GET['id_radnik']) {
		$isUser = false;
	}
}
	
	return $isUser;
}
public function redirectUser() {
	$sesUser = $this->checkUserSession();
	if (!$sesUser) {
		header("Location: ../landing/login.php");
		exit();
	}
}

public function logoutUser() {
	$isAdmin = $this->checkAdminSession();
	$isUser = $this->checkUserSession();

	if ($isAdmin) {
		unset($_SESSION['admin']);
		session_destroy();
		header("Location: ../landing/index.html");
		exit();
	}
		if ($isUser) {
		unset($_SESSION['user']);
		session_destroy();
		header("Location: ../landing/index.html");
		exit();
	}
}

	} // end of class
 ?>