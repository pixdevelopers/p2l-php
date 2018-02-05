<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 17:38
 */
require ('Panel/class/Users/Users.class.php');
$Users = new Users();

if(isset($_POST['Request'])){
    $Users->RequestPIN($_POST['Email'],'','1');
}
?>
<form target="" method="post">
    <table>
        <tr>
            <td>
                Email:
            </td>
            <td>
                <input type="text" name="Email">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="Request">
                <button type="submit">Request</button>
            </td>
        </tr>
    </table>
</form>
