<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 16:43
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require ('Panel/class/Users/Users.class.php');
$Users = new Users();
######## LOGIN & Logout $ Pin code request #######
if(isset($_POST['Login'])){
    $res = json_decode($Users->UserDoLogin($_POST['Type'],$_POST['Email'],$_POST['Password'],$_POST['PIN']));
}
elseif(isset($_GET['Logout'])){
    $res = $Users->UserLogout();
}
######## LOGIN & Logout #######

if(isset($_SESSION['UserID'])){
    echo 'UserID: ' . $_SESSION['UserID'] . '<br>';
    echo 'Email: ' . $_SESSION['Email'] . '<br>';
    echo 'User Full name: ' . $_SESSION['UserFullName'] . '<br>';
    echo "<a href='?Logout'>Logout</a>";
}
else {

    ?>
    <form action="" method="post">
        <table>
            <?php if (isset($res)) {
                ?>
                <tr>
                    <td><span style="color: red"><?php echo $res->Msg; ?></span></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td>Type:</td>
                <td>
                    <select name="Type">
                        <option value="1">Login with password</option>
                        <option value="2">Login with PIN</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="Email"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="Password"></td>
            </tr>
            <tr>
                <td>PIN:</td>
                <td><input type="password" name="PIN"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Login"></td>
            </tr>
        </table>
    </form>
    <a href="RequestPin.php">Request new pin code</a>
    <?php
} ?>
