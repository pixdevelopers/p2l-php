<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 16:18
 */
require ('Panel/class/Users/Users.class.php');
$Users = new Users();
if( (isset($_GET['email']) AND $_GET['email'] != '') AND (isset($_GET['PIN']) AND $_GET['PIN'] != '') ){
    $result = $Users->VerifyEmail($_GET['email'],$_GET['PIN']);
    $result = json_decode($result);
    if($result->Type == '1'){               //Success
        $result = $result->Msg;
    }
    elseif($result->Type == '2'){               //Alert
        $result = $result->Msg;
    }
    elseif($result->Type == '3'){               //Fail
        $result = $result->Msg;
    }
    echo $result;
}
else {
    ?>
    <form action="" method="get">
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
                <td>
                    PIN:
                </td>
                <td>
                    <input type="password" name="Password">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" value="">Verify</button>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
