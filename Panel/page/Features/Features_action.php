<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/23/2018 AD
 * Time: 16:48
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

############ Initial requirements ############
require_once('../../class/General/General.class.php');
require_once('../../class/Features/Features.class.php');
$General = new General();
$Features = new Features();

$ROOT = dirname(dirname(dirname(dirname(__FILE__))));				//آدرس root
############ Initial requirements ############

############ Check login ############
$CheckLogin = $General->AdminCheckLogin();
############ Check login ############

if($CheckLogin == '') {

    switch ($_GET['action']) {
        case 'new' :
            $user_pri = $General->CheckPrivilege('Features_Manage');
            if ($user_pri == '1') {
                $result = $Features->Add($_POST['Name'],$_POST['Desc'],$_POST['Price'],$_POST['CategoryID']);
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
            $user_pri = $General->CheckPrivilege('Features_Manage');
            if ($user_pri == '1') {
                if(isset($_POST['Status'])){
                    $Status = '1';
                }
                else{
                    $Status = '0';
                }
                $result = $Features->Edit($_GET['ID'],$_POST['Name'],$_POST['Desc'],$_POST['Price'],$_POST['CategoryID'],$Status);
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
            $user_pri = $General->CheckPrivilege('Features_Manage');
            if ($user_pri == '1') {
                $result = $Features->Delete($_GET['ID']);
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

        case 'new_category' :
            $user_pri = $General->CheckPrivilege('Features_Manage');
            if ($user_pri == '1') {
                $result = $Features->AddCategory($_POST['Name'],$_POST['Desc']);
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

        case 'edit_category' :
            $user_pri = $General->CheckPrivilege('Features_Manage');
            if ($user_pri == '1') {
                if(isset($_POST['Status'])){
                    $Status = '1';
                }
                else{
                    $Status = '0';
                }
                $result = $Features->EditCategory($_GET['ID'],$_POST['Name'],$_POST['Desc'],$Status);
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

        case 'delete_category' :
            $user_pri = $General->CheckPrivilege('Features_Manage');
            if ($user_pri == '1') {
                $result = $Features->DeleteCategory($_GET['ID']);
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