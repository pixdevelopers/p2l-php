<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/22/2018 AD
 * Time: 18:39
 */
require ('class/Users/Users.class.php');
$Users = new Users();
if(isset($_POST['Login'])){
    $res = json_decode($Users->AdminDoLogin($_POST['Username'],$_POST['Password']));
}
?>
<form action="" method="post">
    <table>
        <?php if(isset($res)) {
            ?>
            <tr>
                <td><span style="color: red"><?php echo $res->Msg; ?></span></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="Username"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="Password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="Login"></td>
        </tr>
    </table>
</form>
