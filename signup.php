<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 15:28
 */
require ('Panel/class/Users/Users.class.php');
$Users = new Users();
if(isset($_POST['SignUp'])){
    $result = $Users->AddUser($_POST['Email'],$_POST['Password'],$_POST['Name'],$_POST['Family']);
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
}

if(isset($result)){
    echo $result;
}
else {
    ?>
    <form action="" method="post">
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
                    Password:
                </td>
                <td>
                    <input type="password" name="Password">
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input type="text" name="Name">
                </td>
            </tr>
            <tr>
                <td>
                    Family:
                </td>
                <td>
                    <input type="text" name="Family">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="SignUp">
                    <button type="submit" value="">Sign-up</button>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
