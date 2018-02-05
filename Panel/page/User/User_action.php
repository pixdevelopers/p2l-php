<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/30/2018 AD
 * Time: 18:01
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

############ Initial requirements ############
require_once('../../class/General/General.class.php');
require_once('../../class/Users/Users.class.php');
$General = new General();
$Users = new Users();

$ROOT = dirname(dirname(dirname(dirname(__FILE__))));				//آدرس root
############ Initial requirements ############

############ Check login ############
$CheckLogin = $General->AdminCheckLogin();
############ Check login ############

if($CheckLogin == '') {

    switch ($_GET['action']) {
        case 'new' :
            $user_pri = $General->CheckPrivilege('User_Manage');
            if ($user_pri == '1') {
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
            } else {
                $result = 'Your account doesn\'t have sufficient privilege to this part! ';
            }
            echo $result;
            break;

        case 'edit' :
            $user_pri = $General->CheckPrivilege('User_Manage');
            if ($user_pri == '1') {
                if(isset($_POST['IsSuperadmin'])){
                    $IsSuperadmin = '1';
                }
                else{
                    $IsSuperadmin = '0';
                }
                if(isset($_POST['Disabled'])){
                    $Status = '0';
                }
                else{
                    $Status = '';
                }
                $result = $Users->EditUser($_GET['ID'],$_GET['Email'],$_GET['Name'],$_GET['Family'],$Status);
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
            $user_pri = $General->CheckPrivilege('User_Manage');
            if ($user_pri == '1') {
                $result = $Users->DeleteUser($_GET['ID']);
                $result = json_decode($result);
                if ($result->Type == '1') {               //Success
                    $result = $result->Msg;
                } elseif ($result->Type == '2') {               //Alert
                    $result = $result->Msg;
                } elseif ($result->Type == '3') {               //Fail
                    $result = $result->Msg;
                }
            }else {
                $result = 'Your account doesn\'t have sufficient privilege to this part! ';
            }
            echo $result;
            break;

        case 'change_pass_user' :
            $user_pri = $General->CheckPrivilege('User_Manage');
            if ($user_pri == '1') {
                $result = $Users->ChangePassword('2',$_GET['ID'],$_POST['Password']);
                $result = json_decode($result);
                if ($result->Type == '1') {               //Success
                    $result = $result->Msg;
                } elseif ($result->Type == '2') {               //Alert
                    $result = $result->Msg;
                } elseif ($result->Type == '3') {               //Fail
                    $result = $result->Msg;
                }
            }else {
                $result = 'Your account doesn\'t have sufficient privilege to this part! ';
            }
            echo $result;
            break;

    }

}
else{
    echo $CheckLogin;
}
?>