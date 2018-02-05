<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/23/2018 AD
 * Time: 14:19
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

############ Initial requirements ############
require_once('../../class/General/General.class.php');
require_once('../../class/UserGroups/UserGroups.class.php');
require_once('../../class/Users/Users.class.php');
$General = new General();
$UserGroups = new UserGroups();
$Users = new Users();

$ROOT = dirname(dirname(dirname(dirname(__FILE__))));				//آدرس root
############ Initial requirements ############

############ Check login ############
$CheckLogin = $General->AdminCheckLogin();
############ Check login ############

if($CheckLogin == '') {

    switch ($_GET['action']) {
        case 'new' :
            $user_pri = $General->CheckPrivilege('UsersGroups_Manage');
            if ($user_pri == '1') {
                $result = $UserGroups->AddUserGroup($_POST['Name'],$_POST['Privileges']);
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
            } else {
                $result = 'Your account doesn\'t have sufficient privilege to this part! ';
            }
            echo $result;
            break;

        case 'edit' :
            $user_pri = $General->CheckPrivilege('UserGroups_Manage');
            if ($user_pri == '1') {
                if(isset($_POST['Status'])){
                    $Status = '1';
                }
                else{
                    $Status = '0';
                }
                $result = $UserGroups->EditUserGroup($_GET['ID'],$_POST['Name'],$Status,$_POST['Privileges']);
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
            } else {
                $result = 'Your account doesn\'t have sufficient privilege to this part! ';
            }
            echo $result;
            break;

        case 'delete' :
            $user_pri = $General->CheckPrivilege('UserGroups_Manage');
            if ($user_pri == '1') {
                $result = $UserGroups->DeleteUserGroup($_GET['ID']);
                $result = json_decode($result);
                if ($result->Type == '1') {               //Success
                    $result = $result->Msg;
                } elseif ($result->Type == '2') {               //Alert
                    $result = $result->Msg;
                } elseif ($result->Type == '3') {               //Fail
                    $result = $result->Msg;
                }
            }else {
                $result = '2_' . 'شما مجوز لازم برای دسترسی به این بخش را ندارید.';
            }
            echo $result;
            break;

    }

}
else{
    echo $CheckLogin;
}
?>