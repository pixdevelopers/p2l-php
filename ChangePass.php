<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 18:26
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require ('Panel/class/Users/Users.class.php');
$Users = new Users();

if(isset($_SESSION['UserID'])) {

    if(isset($_POST['FormSubmit'])){
        $res = json_decode($Users->ChangePassword('2',$_SESSION['UserID'],$_POST['password']));
        if($res->Type == '1'){               //Success
            $res = $res->Msg;
        }
        elseif($res->Type == '2'){               //Alert
            $res = $res->Msg;
        }
        elseif($res->Type == '3'){               //Fail
            $res = $res->Msg;
        }
    }

    if(isset($res)){
        echo $res;
    }
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td>
                    Password:
                </td>
                <td>
                    <input type="password" name="password" >
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="FormSubmit">
                    <button type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
else{
    echo 'Please login to your account';
}