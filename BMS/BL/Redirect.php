<?php 

class Redirect 
{
	/**
	 * Check if user have admin privilegies.
	 * @return string
	 */
	private function checkAdminSession() 
	{
		$isAdmin = false;
		if (isset($_SESSION['admin'])) {
			$isAdmin = true;
		}
		return $isAdmin;
	}
	/**
	 * If user not admin, redirect to login
	 */
	public function redirectAdmin() 
	{
		$sesAdmin = $this->checkAdminSession();
		if (!$sesAdmin) {
			header("Location: ../landing/login.php");
			exit();
		}
	}
	/**
	 * Check if user logged.
	 * @return string 
	 */
	public function checkUserSession() 
	{
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
	/**
	 * If user not logged, redirect to login
	 */
	public function redirectUser() 
	{
		$sesUser = $this->checkUserSession();
		if (!$sesUser) {
			header("Location: ../landing/login.php");
			exit();
		}
	}
	/**
	 * Logout user
	 */
	public function logoutUser() 
	{
		unset($_SESSION['admin'],$_SESSION['user']);
		session_destroy();
		header("Location: ../landing/index.html");
		exit();
}

	} // end of class
