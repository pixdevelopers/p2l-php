<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 14:54
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require ('Panel/class/Users/Users.class.php');
$Users = new Users();

if(isset($_GET['Logout'])) {
    $res = $Users->UserLogout();
}
?>
<a href="signup.php" target="_blank">Sign up</a><br>
<a href="verify.php" target="_blank">Verify</a><br>
<a href="login.php" target="_blank">Login</a><br>
<a href="EditProfile.php" target="_blank">Edit profile</a><br>
<a href="ChangePass.php" target="_blank">Change password</a><br>
<a href="?Logout" target="_blank">Logout</a><br>

