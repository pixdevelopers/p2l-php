<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/19/2018 AD
 * Time: 22:50
 */
$ROOT = dirname(dirname(dirname(dirname(__FILE__))));

require_once($ROOT.'/Panel/class/General/General.class.php');

class Users {

    /*
     * Status:0 => Disable
     * Status:1 => Enable
     * Status:2 => SystemAdmin
     */
    public function AddAdmin($Username, $Password, $Name, $IsSuperadmin, $GroupID)
    {              //Define admin user
        $General = new General();

        $con = $General->Connect();

        $check_username = mysqli_query($con, "SELECT `ID` FROM `admin` WHERE (`Username`='$Username') LIMIT 1");
        if (mysqli_num_rows($check_username) > 0) {
            $msg['Type'] = '2';
            $msg['Msg'] = 'The username ' . $Username . ' already exist.';
            $result = json_encode($msg);
            return $result;
        }

        $Password = md5($Password);

        if($GroupID != '') {
            mysqli_query($con, "INSERT INTO `admin` VALUES(NULL, '$Username', '$Password', '$Name', '$IsSuperadmin', '$GroupID', '1')");
        }
        else{
            mysqli_query($con, "INSERT INTO `admin` VALUES(NULL, '$Username', '$Password', '$Name', '$IsSuperadmin', NULL, '1')");
        }
        if (mysqli_affected_rows($con) > 0) {
            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);
        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    public function EditAdmin($ID, $Username, $Name, $IsSuperadmin, $GroupID, $Status)
    {                //Edit admin user
        $General = new General();

        $con = $General->Connect();

        $check_username = mysqli_query($con, "SELECT `ID` FROM `admin` WHERE (`Username`='$Username' AND `ID` != '$ID') LIMIT 1");
        if (mysqli_num_rows($check_username) > 0) {
            $msg['Type'] = '2';
            $msg['Msg'] = 'The username ' . $Username . ' already exist.';
            $result = json_encode($msg);
            return $result;
        }

        if ($GroupID != '') {
            $query = mysqli_query($con, "UPDATE `admin` SET `Username`='$Username', `Name`='$Name', `IsSuperadmin`='$IsSuperadmin', `GroupID`='$GroupID', `Status`='$Status' WHERE (`ID`='$ID')");
        } else {
            $query = mysqli_query($con, "UPDATE `admin` SET `Username`='$Username', `Name`='$Name', `IsSuperadmin`='$IsSuperadmin', `GroupID`= NULL, `Status`='$Status' WHERE (`ID`='$ID')");
        }
        if ($query) {

            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);
        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    public function DeleteAdmin($ID)
    {                //Delete admin
        $General = new General();

        $con = $General->Connect();

        mysqli_query($con, "DELETE FROM `admin` WHERE (`ID`='$ID')");
        if (mysqli_affected_rows($con) > 0) {
            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);
        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    public function SelectAdmin($ID,$Username,$GroupID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT){
        $General = new General();
        $con = $General->Connect();

        if($LIMIT != ''){
            $LIMIT = "LIMIT $LIMIT";
        }
        if($ORDER_BY != ''){
            $ORDER_BY = "ORDER BY $ORDER_BY";
        }

        $Condition = '';
        if($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if($Username != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Username`='$Username')";
        }
        if($GroupID != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`GroupID`='$GroupID')";
        }
        if($Status != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Status`='$Status')";
        }
        if($Condition != '') {
            $Query = mysqli_query($con, "SELECT * FROM `admin` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
        }
        else{
            $Query = mysqli_query($con, "SELECT * FROM `admin` $ORDER_BY $ORDER_TYPE $LIMIT");
        }

        return $Query;

    }

    public function AdminDoLogin($Username, $Password)
    {              //ورود به سیستم
        $General = new General();

        $con = $General->Connect();
        $time = time();

        $IP = $_SERVER['REMOTE_ADDR'];
        $md5_Password = md5($Password);

        $user_info = mysqli_query($con, "SELECT * FROM `admin` WHERE (`Username`='$Username') LIMIT 1");
        if (mysqli_num_rows($user_info) > 0) {
            $row_user_info = mysqli_fetch_assoc($user_info);
            $AdminID = $row_user_info['ID'];

            $CheckPassword = mysqli_query($con, "SELECT * FROM `admin` WHERE (`Username`='$Username' AND `Password`='$md5_Password') LIMIT 1");
            if (mysqli_num_rows($CheckPassword) > 0) {

                if ($row_user_info['Status'] == '1') {                //Login successful
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $AdminID = $row_user_info['ID'];
                    $AdminName = $row_user_info['Name'];
                    $IsSuperadmin = $row_user_info['IsSuperadmin'];
                    $GroupID = $row_user_info['GroupID'];

                    $_SESSION['AdminID'] = $AdminID;
                    $_SESSION['AdminUserName'] = $Username;
                    $_SESSION['AdminName'] = $AdminName;
                    $_SESSION['AdminIsSuperadmin'] = $IsSuperadmin;
                    $_SESSION['AdminGroupID'] = $GroupID;

                    mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Username',NULL,'$AdminID','$IP','1','','$time')");
                    header('location: index.php');


                } else {
                    $Reason = 'The user account disabled';
                    mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Username',NULL,'$AdminID','$IP','0','$Reason','$time')");

                    $msg['Type'] = '2';
                    $msg['Msg'] = 'The user "' . $Username . '" disabled';
                    $result = json_encode($msg);
                    return $result;
                }

            } else {
                $Reason = 'The entered password doesn\'t match';
                mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Username',NULL,'$AdminID','$IP','0','$Reason','$time')");

                $msg['Type'] = '3';
                $msg['Msg'] = 'The entered password doesn\'t match';
                $result = json_encode($msg);
                return $result;
            }


        } else {
            $Reason = 'Admin username not exist';
            mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Username',NULL,NULL,'$IP','0','$Reason','$time')");

            $msg['Type'] = '3';
            $msg['Msg'] = 'Entered username not exist';
            $result = json_encode($msg);
            return $result;
        }

    }

    public function AdminLogout(){
        $General = new General();

        session_destroy();

        $location = 'location: login.php';
        header($location);

    }

    /*
     * PT: 1 => Admin
     * PT: 2 => User
     */
    public function ChangePassword($PT,$UserID, $NewPassword)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $General = new General();
        $con = $General->Connect();

        $NewPassword = md5($NewPassword);

        if ($PT == '1') {
            $query = mysqli_query($con, "UPDATE `admin` SET `Password`='$NewPassword' WHERE (`ID`='$UserID')");
        } elseif ($PT == '2') {
            $query = mysqli_query($con, "UPDATE `user` SET `Password`='$NewPassword' WHERE (`ID`='$UserID')");
        }
        if ($query) {

            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation successful';
            $result = json_encode($msg);
            return $result;
        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
            return $result;
        }

    }

    public function SelectLogins($UserID, $AdminID, $FROM_Date, $TO_Date, $IP, $Result, $ORDER_BY, $ORDER_TYPE, $LIMIT){              //لیست لاگین های کاربر
        $General = new General();
        $con = $General->Connect();

        if($LIMIT != ''){
            $LIMIT = "LIMIT $LIMIT";
        }
        if($ORDER_BY != ''){
            $ORDER_BY = "ORDER BY $ORDER_BY";
        }

        $Condition = '';
        if($UserID != '') {
            $Condition = $Condition . "(`UserID`='$UserID')";
        }
        elseif($AdminID != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`AdminID`='$AdminID')";
        }
        if($FROM_Date != '' AND $TO_Date != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Time` BETWEEN '$FROM_Date' AND '$TO_Date')";
        }
        elseif($FROM_Date != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Time` >= '$FROM_Date')";
        }
        elseif($TO_Date != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Time` <= '$TO_Date')";
        }
        if($IP != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`IP`='$IP')";
        }
        if($Result != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Result`='$Result')";
        }
        if($Condition != '') {
            $Query = mysqli_query($con, "SELECT * FROM `logins` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
        }
        else{
            $Query = mysqli_query($con, "SELECT * FROM `logins` $ORDER_BY $ORDER_TYPE $LIMIT");
        }

        return $Query;
    }

    /*
     * Status:0 => Disable
     * Status:1 => Enable
     * Status:2 => Verified
     */
    public function AddUser($Email, $Password, $Name, $Family)
    {              //Define user
        $General = new General();

        $con = $General->Connect();

        $RT = time();

        $check_email = mysqli_query($con, "SELECT `ID` FROM `user` WHERE (`Email`='$Email') LIMIT 1");
        if (mysqli_num_rows($check_email) > 0) {
            $msg['Type'] = '2';
            $msg['Msg'] = 'The email ' . $Email . ' already exist.';
            $result = json_encode($msg);
            return $result;
        }

        if($Password != '') {
            $Password = md5($Password);
        }

        $PIN = mt_rand('1000','9999');

        mysqli_query($con,"INSERT INTO `user` VALUES(NULL,'$Email','$Password','$Name','$Family','$PIN','1','$RT')");
        if (mysqli_affected_rows($con) > 0) {

            $WelcomeEmailContent = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta charset=\"UTF-8\">
    <title>PSD2LIVE | Email</title>
    <style type=\"text/css\">
    body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }
    </style>
</head>

<body style=\"background: #f0f0f0 url(http://s9.picofile.com/file/8318259050/email_bg.jpg) no-repeat; background-size: 100% 340px;padding: 200px 0 20px;\">

    <table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;max-width:700px;margin:0 auto;border-radius:8px\">
        <tbody>
            <tr>
                <td>
                    <img src=\"http://s9.picofile.com/file/8318259034/p2l_logo.png\" style=\"display:block;margin:75px auto\">
                </td>
            </tr>
            <tr>
                <td style=\"padding:0 0 60px\">
                    <div style=\"width:100%;max-width: 600px;padding: 0 5px;margin: 0 auto;\">
                        <p class=\"main-title\" style=\"margin:0 auto 20px;color:#6acad8;font-size:26px\">Welcome to PSD2LIVE.com</p>
                        <p style=\"margin:10px auto;color:#515151;font-size:15px;line-height:28px\">Hello,
                            <br> Welcome to our Client Area. We will use your email address <strong>(<a href=\"mailto:" . $Email . "\" style=\"color:#515151;text-decoration:none\">" . $Email . "</a>)</strong> to notify you about replies to your tickets, projects and status updates.
                            <br>
                            <br> You can change your password any time by logging in to
                            <br>
                            <a style=\"color:#6acad8\" href=\"https://psd2live.com/user/dashboard/profile\">https://psd2live.com/user/dashboard/profile</a>
                            <br>
                            <br> Sincerely,
                            <br> PSD2LIVE Team
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class=\"footer\">
        <p style=\"color: #6d6d6d; font-size: 11px; text-align: center; line-height: 24px; margin: 30px auto 0;\">
        	<a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">PSD2LIVE</a>   |  
        	<a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">CLIENTS AREA</a>  |  
        	<a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">PRIVACY POLICY</a> |  
        	<a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">TERMS OF USE</a>
       	</p>
        <p style=\"color: #6d6d6d; font-size:11px; text-align: center; margin: 5px auto 60px;\">Copyright © 2017 PSD2LIVE. All rights reserved</p>
    </div>
</body>

</html>";
            $General->SendEmail('no-reply@P2L.com','',$Email,'Welcome to P2LIVE',$WelcomeEmailContent);


            $EmailContent = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta charset=\"UTF-8\">
    <title>PSD2LIVE | Email</title>
    <style type=\"text/css\">
    body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }
    </style>
</head>

<body style=\"background: #f0f0f0 url(http://s9.picofile.com/file/8318259050/email_bg.jpg) no-repeat; background-size: 100% 340px;padding: 200px 0 20px;\">

    <table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;max-width:700px;margin:0 auto;border-radius:8px\">
        <tbody>
            <tr>
                <td>
                    <img src=\"http://s9.picofile.com/file/8318259034/p2l_logo.png\" style=\"display:block;margin:75px auto\">
                </td>
            </tr>
            <tr>
                <td style=\"padding:0 0 60px\">
                    <div style=\"width:100%;max-width: 600px;padding: 0 5px;margin: 0 auto;\">
                        <p class=\"main-title\" style=\"margin:0 auto 20px;color:#6acad8;font-size:26px\">Verify Your Email Address</p>
                        <p style=\"margin:10px auto;color:#515151;font-size:15px;line-height:28px\">
                            Dear <strong>(<a href=\"mailto:" . $Email . "\" style=\"color:#515151;text-decoration:none\">" . $Email . "</a>)</strong>
                            <br> In order to confirm your identity, you have chosen to receive a verification code at this email address. Enter the verification code below into the email verification code box
                            <br>
                            <br>
                            <span style=\"display: inline-block;background: #f5f5f5;padding:20px 50px;font-size: 30px;color:#ff9292;\">" . $PIN . "</span>
                            <br>
                            <br>
                            Also you can follow the link below to activate your account:<br>
                            <a style=\"color:#6acad8\" href=\"https://psd2live.com/verify.php?email=" . $Email . "&PIN=" . $PIN . "\">https://psd2live.com/verify.php?email=" . $Email . "&PIN=" . $PIN . "</a>
                            <br>
                            <br>
                            Keep your verification code private and do not share it with anyone else. The verification code will expire 30 minutes after this email was sent.
                            <br>
                            <br> Sincerely,
                            <br> PSD2LIVE Team
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class=\"footer\">
        <p style=\"color: #6d6d6d; font-size: 11px; text-align: center; line-height: 24px; margin: 30px auto 0;\">
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">PSD2LIVE</a>   |  
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">CLIENTS AREA</a>  |  
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">PRIVACY POLICY</a> |  
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">TERMS OF USE</a>
        </p>
        <p style=\"color: #6d6d6d; font-size:11px; text-align: center; margin: 5px auto 60px;\">Copyright © 2017 PSD2LIVE. All rights reserved</p>
    </div>
</body>

</html>";
            if($General->SendEmail('no-reply@P2L.com','',$Email,'Email verifaction',$EmailContent)){
                $msg['Type'] = '1';
                $msg['Msg'] = 'Registration has been successfully.<br>You should confirm email address to activate your account';
                $result = json_encode($msg);
            }
            else{
                $msg['Type'] = '2';
                $msg['Msg'] = 'Registration has been successfully.<br>Problem occur on verification email sent, Please request to resend verification email';
                $result = json_encode($msg);
            }
        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    public function VerifyEmail($Email,$PIN){
        $General = new General();

        $con = $General->Connect();

        $CheckPIN = mysqli_query($con,"SELECT `ID` FROM `user` WHERE (`Email` = '$Email' AND `PIN`='$PIN') LIMIT 1");
        if(mysqli_num_rows($CheckPIN)>0){
            mysqli_query($con,"UPDATE `user` SET `Status`='2', `PIN`= NULL WHERE (`Email` = '$Email' AND `PIN`='$PIN')");
            if(mysqli_affected_rows($con)>0){
                $msg['Type'] = '1';
                $msg['Msg'] = 'Operation completed successfully.';
                $result = json_encode($msg);
                return $result;
            }
            else{
                $msg['Type'] = '3';
                $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
                $result = json_encode($msg);
                return $result;
            }
        }
        else{
            $msg['Type'] = '2';
            $msg['Msg'] = 'Email address and PIN code doesn\'t match.';
            $result = json_encode($msg);
            return $result;
        }
    }

    public function EditUser($ID, $Email, $Name, $Family, $Status)
    {                //Edit admin user
        $General = new General();

        $con = $General->Connect();

        $OldData = mysqli_query($con,"SELECT * FROM `user` WHERE (`ID`='$ID') LIMIT 1");
        $row_OldData = mysqli_fetch_assoc($OldData);
        if($row_OldData['Email'] != $Email){
            $check_email = mysqli_query($con, "SELECT `ID` FROM `user` WHERE (`Email`='$Email' AND `ID` != '$ID') LIMIT 1");
            if (mysqli_num_rows($check_email) > 0) {
                $msg['Type'] = '2';
                $msg['Msg'] = 'The email ' . $Email . ' already exist.';
                $result = json_encode($msg);
                return $result;
            }
        }

        mysqli_autocommit($con,FALSE);

        if($Status == '') {
            $query = mysqli_query($con, "UPDATE `user` SET `Email` = '$Email', `Name`='$Name', `Family`='$Family' WHERE (`ID` = '$ID')");
        }
        else{
            $query = mysqli_query($con, "UPDATE `user` SET `Email` = '$Email', `Name`='$Name', `Family`='$Family', `Status`='$Status' WHERE (`ID` = '$ID')");
        }
        if ($query) {

            if($row_OldData['Email'] != $Email){
                $query = mysqli_query($con,"UPDATE `user` SET `Status` = '1' WHERE (`ID`='$ID')");
                if($query){
                    mysqli_commit($con);
                    $msg['Type'] = '1';
                    $msg['Msg'] = 'Operation completed successfully.<br>You must verify your account again!';
                    $result = json_encode($msg);
                    return $result;
                }
                else{
                    $msg['Type'] = '3';
                    $msg['Msg'] = 'Operation failed (Step 2)<br>' . mysqli_error($con);
                    mysqli_rollback($con);
                    $result = json_encode($msg);
                    return $result;
                }
            }

            mysqli_commit($con);
            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);
            return $result;

        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed (Step 1)<br>' . mysqli_error($con);
            mysqli_rollback($con);
            $result = json_encode($msg);
            return $result;
        }

        return $result;

    }

    public function DeleteUser($ID)
    {                //Delete user
        $General = new General();

        $con = $General->Connect();

        mysqli_query($con, "DELETE FROM `user` WHERE (`ID`='$ID')");
        if (mysqli_affected_rows($con) > 0) {
            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);
        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    public function SelectUser($ID,$Email,$Name,$Family,$Status,$RT_FROM,$RT_TO,$ORDER_BY,$ORDER_TYPE,$LIMIT){
        $General = new General();
        $con = $General->Connect();

        if($LIMIT != ''){
            $LIMIT = "LIMIT $LIMIT";
        }
        if($ORDER_BY != ''){
            $ORDER_BY = "ORDER BY $ORDER_BY";
        }

        $Condition = '';
        if($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if($Email != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Email` LIKE '%$Email%')";
        }
        if($Name != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Name` LIKE '%$Name$')";
        }
        if($Family != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Family` LIKE '%$Family$')";
        }
        if($Status != '') {
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Status`='$Status')";
        }
        if($RT_FROM != '' AND $RT_TO != ''){
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`RT` BETWEEN '$RT_FROM' AND '$RT_TO')";
        }
        elseif($RT_FROM != ''){
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`RT` >= '$RT_FROM')";
        }
        elseif($RT_TO != ''){
            if($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`RT` >= '$RT_TO')";
        }
        if($Condition != '') {
            $Query = mysqli_query($con, "SELECT * FROM `user` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
        }
        else{
            $Query = mysqli_query($con, "SELECT * FROM `user` $ORDER_BY $ORDER_TYPE $LIMIT");
        }

        return $Query;

    }

    /*
     * Type: 1 => Login with password
     * Type: 2 => Login with PIN
     */
    public function UserDoLogin($Type,$Email, $Password, $PIN)
    {              //ورود به سیستم
        $General = new General();

        $con = $General->Connect();
        $time = time();

        $IP = $_SERVER['REMOTE_ADDR'];
        $md5_Password = md5($Password);

        $user_info = mysqli_query($con, "SELECT * FROM `user` WHERE (`Email`='$Email') LIMIT 1");
        if (mysqli_num_rows($user_info) > 0) {
            $row_user_info = mysqli_fetch_assoc($user_info);
            $UserID = $row_user_info['ID'];

            if($Type == '2' AND $row_user_info['PIN'] == ''){
                $msg['Type'] = '2';
                $msg['Msg'] = 'You should request the PIN code before login!';
                $result = json_encode($msg);
                return $result;
            }

            if($Type == '1') {
                $Authenticate = mysqli_query($con, "SELECT * FROM `user` WHERE (`Email`='$Email' AND `Password`='$md5_Password') LIMIT 1");
            }
            elseif($Type == '2'){
                $Authenticate = mysqli_query($con,"SELECT * FROM `user` WHERE (`Email` = '$Email' AND `PIN`='$PIN') LIMIT 1");
            }
            if (mysqli_num_rows($Authenticate) > 0) {

                if ($row_user_info['Status'] != '0') {                //Login successful
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $UserID = $row_user_info['ID'];
                    $FullName = $row_user_info['Name'] . $row_user_info['Family'];

                    $_SESSION['UserID'] = $UserID;
                    $_SESSION['Email'] = $Email;
                    $_SESSION['UserFullName'] = $FullName;

                    mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Email','$UserID',NULL,'$IP','1','','$time')");
                    header('location: index.php');


                } else {
                    $Reason = 'The user account disabled';
                    mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Email','$UserID',NULL,'$IP','0','$Reason','$time')");

                    $msg['Type'] = '2';
                    $msg['Msg'] = 'The user "' . $Email . '" disabled';
                    $result = json_encode($msg);
                    return $result;
                }

            } else {
                $Reason = 'The entered password doesn\'t match';
                mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Email','$UserID',NULL,'$IP','0','$Reason','$time')");

                $msg['Type'] = '3';
                $msg['Msg'] = 'The entered password doesn\'t match';
                $result = json_encode($msg);
                return $result;
            }


        } else {
            $Reason = 'Email address not exist';
            mysqli_query($con, "INSERT INTO `logins` VALUES(NULL,'$Email',NULL,NULL,'$IP','0','$Reason','$time')");

            $msg['Type'] = '3';
            $msg['Msg'] = 'Entered email address not exist';
            $result = json_encode($msg);
            return $result;
        }

    }

    public function UserLogout(){
        $General = new General();

        session_destroy();

        $location = 'location: login.php';
        header($location);

    }

    /*
     * SendEmail:1 => Send PIN to user (Default is 0)
     */
    public function RequestPIN($Email,$PIN,$SendEmail){             //Update pin code for user
        $General = new General();

        $con = $General->Connect();

        if($PIN == '') {
            $PIN = mt_rand('1000', '9999');
        }

        if($SendEmail == ''){
            $SendEmail = '0';
        }

        mysqli_query($con,"UPDATE `user` SET `PIN`='$PIN' WHERE (`Email`='$Email')");
        if (mysqli_affected_rows($con) > 0) {

            if($SendEmail == '1'){
                $EmailContent = "PIN: " . $PIN;
                if($General->SendEmail('no-reply@P2L.com','',$Email,'PIN code',$EmailContent)){
                    $msg['Type'] = '1';
                    $msg['Msg'] = 'PIN code sent to your email address';
                    $result = json_encode($msg);
                    return $result;
                }
                else{
                    $msg['Type'] = '2';
                    $msg['Msg'] = 'Problem occur on email sent, Please request to resend';
                    $result = json_encode($msg);
                    return $result;
                }
            }
            else{
                $msg['Type'] = '1';
                $msg['Msg'] = 'PIN code updated';
                $result = json_encode($msg);
                return $result;
            }

        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
            return $result;
        }
    }

    public function RequestVerificationEmail($Email){
        $General = new General();

        $con = $General->Connect();

        $SelectUser = mysqli_query($con,"SELECT `ID` FROM `user` WHERE (`Email`='$Email') LIMIT 1");
        if(mysqli_num_rows($SelectUser)>0) {                //Email address exist

            $PIN = mt_rand('1000','9999');
            $UpdatePIN = json_decode($this->RequestPIN($Email,$PIN, '0'));

            if ($UpdatePIN->Type == '1') {                //PIN updated
                $EmailContent = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta charset=\"UTF-8\">
    <title>PSD2LIVE | Email</title>
    <style type=\"text/css\">
    body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }
    </style>
</head>

<body style=\"background: #f0f0f0 url(http://s9.picofile.com/file/8318259050/email_bg.jpg) no-repeat; background-size: 100% 340px;padding: 200px 0 20px;\">

    <table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%;max-width:700px;margin:0 auto;border-radius:8px\">
        <tbody>
            <tr>
                <td>
                    <img src=\"http://s9.picofile.com/file/8318259034/p2l_logo.png\" style=\"display:block;margin:75px auto\">
                </td>
            </tr>
            <tr>
                <td style=\"padding:0 0 60px\">
                    <div style=\"width:100%;max-width: 600px;padding: 0 5px;margin: 0 auto;\">
                        <p class=\"main-title\" style=\"margin:0 auto 20px;color:#6acad8;font-size:26px\">Verify Your Email Address</p>
                        <p style=\"margin:10px auto;color:#515151;font-size:15px;line-height:28px\">
                            Dear <strong>(<a href=\"mailto:" . $Email . "\" style=\"color:#515151;text-decoration:none\">" . $Email . "</a>)</strong>
                            <br> In order to confirm your identity, you have chosen to receive a verification code at this email address. Enter the verification code below into the email verification code box
                            <br>
                            <br>
                            <span style=\"display: inline-block;background: #f5f5f5;padding:20px 50px;font-size: 30px;color:#ff9292;\">" . $PIN . "</span>
                            <br>
                            <br>
                            Also you can follow the link below to activate your account:<br>
                            <a style=\"color:#6acad8\" href=\"https://psd2live.com/verify.php?email=" . $Email . "&PIN=" . $PIN . "\">https://psd2live.com/verify.php?email=" . $Email . "&PIN=" . $PIN . "</a>
                            <br>
                            <br>
                            Keep your verification code private and do not share it with anyone else. The verification code will expire 30 minutes after this email was sent.
                            <br>
                            <br> Sincerely,
                            <br> PSD2LIVE Team
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class=\"footer\">
        <p style=\"color: #6d6d6d; font-size: 11px; text-align: center; line-height: 24px; margin: 30px auto 0;\">
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">PSD2LIVE</a>   |  
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">CLIENTS AREA</a>  |  
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">PRIVACY POLICY</a> |  
            <a style=\"color: #6d6d6d;text-decoration: none;\" href=\"http://www.psd2live.com\">TERMS OF USE</a>
        </p>
        <p style=\"color: #6d6d6d; font-size:11px; text-align: center; margin: 5px auto 60px;\">Copyright © 2017 PSD2LIVE. All rights reserved</p>
    </div>
</body>

</html>";
                if($General->SendEmail('no-reply@P2L.com','',$Email,'Email verification',$EmailContent)){
                    $msg['Type'] = '1';
                    $msg['Msg'] = 'Verification email sent to your email address';
                    $result = json_encode($msg);
                    return $result;
                }
                else{
                    $msg['Type'] = '2';
                    $msg['Msg'] = 'Problem occur on verification email sent, Please request to resend verification email';
                    $result = json_encode($msg);
                    return $result;
                }
            }
            else{
                $msg['Type'] = '3';
                $msg['Msg'] = $UpdatePIN->Msg;
                $result = json_encode($msg);
                return $result;
            }
        }
        else{
            $msg['Type'] = '2';
            $msg['Msg'] = 'The entered email address doesn\'t exist';
            $result = json_encode($msg);
            return $result;
        }

    }

}

?>