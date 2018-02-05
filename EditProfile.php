<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 17:47
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require ('Panel/class/Users/Users.class.php');
$Users = new Users();

if(isset($_SESSION['UserID'])) {

    if(isset($_POST['FormSubmit'])){
        $res = json_decode($Users->EditUser($_SESSION['UserID'],$_POST['Email'],$_POST['Name'],$_POST['Family'],''));
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

    $Info = $Users->SelectUser($_SESSION['UserID'],'','','','','','','','','1');
    $row_info = mysqli_fetch_assoc($Info);

    if(isset($res)){
        echo $res;
    }
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td>
                    Email:
                </td>
                <td>
                    <input name="Email" value="<?php echo $row_info['Email']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input name="Name" value="<?php echo $row_info['Name']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Family:
                </td>
                <td>
                    <input name="Family" value="<?php echo $row_info['Family']; ?>">
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