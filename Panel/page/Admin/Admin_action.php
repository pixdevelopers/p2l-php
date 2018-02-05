<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/23/2018 AD
 * Time: 15:36
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
            $user_pri = $General->CheckPrivilege('Admin_Manage');
            if ($user_pri == '1') {
                if(isset($_POST['IsSuperadmin'])){
                    $IsSuperadmin = '1';
                }
                else{
                    $IsSuperadmin = '0';
                }
                $result = $Users->AddAdmin($_POST['Username'],$_POST['Password'],$_POST['Name'],$IsSuperadmin,$_POST['GroupID']);
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
            $user_pri = $General->CheckPrivilege('Admin_Manage');
            if ($user_pri == '1') {
                if(isset($_POST['IsSuperadmin'])){
                    $IsSuperadmin = '1';
                }
                else{
                    $IsSuperadmin = '0';
                }
                if(isset($_POST['Status'])){
                    $Status = '1';
                }
                else{
                    $Status = '0';
                }
                $result = $Users->EditAdmin($_GET['ID'],$_POST['Username'],$_POST['Name'],$IsSuperadmin,$_POST['GroupID'],$Status);
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
            $user_pri = $General->CheckPrivilege('Admin_Manage');
            if ($user_pri == '1') {
                $result = $Users->DeleteAdmin($_GET['ID']);
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

        case 'change_pass' :
            $user_pri = $General->CheckPrivilege('Admin_Manage');
            if ($user_pri == '1') {
                $result = $Users->ChangePassword('1',$_GET['ID'],$_POST['Password']);
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