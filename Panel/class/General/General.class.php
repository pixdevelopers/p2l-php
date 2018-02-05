<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/19/2018 AD
 * Time: 22:26
 */
$ROOT = dirname(dirname(dirname(dirname(__FILE__))));

require_once($ROOT.'/Panel/config/config.php');
require_once($ROOT.'/Panel/lib/jdf.php');
require_once($ROOT.'/Panel/class/UserGroups/UserGroups.class.php');
require_once($ROOT.'/Panel/class/SMTP/class.phpmailer.php');
require_once($ROOT.'/Panel/class/SMTP/class.smtp.php');

class General {

    private $HOST;
    private $PORT;
    private $USER;
    private $PASS;
    private $DB;
    private $URL;
    private $EMAIL_HOST;
    private $EMAIL_USERNAME;
    private $EMAIL_PASSWORD;


    public function __construct() {
        global $HOST;
        global $PORT;
        global $USER;
        global $PASS;
        global $DB;
        global $URL;
        global $EMAIL_HOST;
        global $EMAIL_USERNAME;
        global $EMAIL_PASSWORD;
        $this->HOST=$HOST;
        $this->PORT=$PORT;
        $this->USER=$USER;
        $this->PASS=$PASS;
        $this->DB=$DB;
        $this->URL=$URL;
        $this->EMAIL_HOST=$EMAIL_HOST;
        $this->EMAIL_USERNAME=$EMAIL_USERNAME;
        $this->EMAIL_PASSWORD=$EMAIL_PASSWORD;

    }

    public function Connect() {				//اتصال به پایگاه داده

        $con = mysqli_connect($this->HOST, $this->USER, $this->PASS, $this->DB,$this->PORT);

        mysqli_set_charset($con,"utf8");
        return $con;
    }


    /*
     * Date ّformat: yyyy/m/d
     * Hour format: 00
     * Min format: 00
     */
    public function GetStringTime($date,$hour,$min,$JalaliDate){				//تبدیل زمان به رشته

        $explode_date = explode('/',$date);

        if($JalaliDate == '1'){             //تاریخ جلالی
            jdate('');

            if(jcheckdate( $explode_date['1'] , $explode_date['2'] , $explode_date['0'] ) AND ($hour >= '0' AND $hour <= '23') AND ($min >= '0' AND $min <= '60')){             //بررسی ساختار زمان
                $string_time = jmktime($hour, $min,'0',$explode_date['1'],$explode_date['2'],$explode_date['0']);
                return $string_time;
            }
            else{
                return 'ساختار زمان ' . $date . $hour . ':' . $min . 'صحیح نیست';
            }
        }
        else{               //تاریخ میلادی

            if(checkdate( $explode_date['1'] , $explode_date['2'] , $explode_date['0'] ) AND ($hour >= '0' AND $hour <= '23') AND ($min >= '0' AND $min <= '60')) {             //بررسی ساختار زمان
                $string_time = mktime($hour, $min,'0',$explode_date['1'],$explode_date['2'],$explode_date['0']);
                return $string_time;
            }
            else{
                return 'ساختار زمان ' . $date . $hour . ':' . $min . 'صحیح نیست';
            }
        }

    }

    public function  AdminCheckLogin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['AdminID'])) {

            $msg = 'Please login to your account!';
            header('location: login.php?msg=' . $msg);

        }

    }

    public function CheckPrivilege($Privilege){             //بررسی دسترسی داشتن کاربر به بخش مورد نظر
        $UserGroups = new UserGroups();

        if($_SESSION['AdminIsSuperadmin'] == '1'){
            return '1';
        }
        else {
            $GroupID = $_SESSION['AdminGroupID'];
            $CheckPrivilege = $UserGroups->CheckGroupAndPrivilegeRelation($GroupID, $Privilege);
            return $CheckPrivilege;
        }

    }

    public function SendEmail($SenderEmail,$ReplyTo,$ReceiverEmail,$Subject,$Content){
        $PHPMailer = new PHPMailer();

        //$PHPMailer->SMTPDebug = 2;
        $PHPMailer->IsSMTP();
        $PHPMailer->Host = $this->EMAIL_HOST;
        $PHPMailer->SMTPAuth = true;
        $PHPMailer->Username = $this->EMAIL_USERNAME;
        $PHPMailer->Password = $this->EMAIL_PASSWORD;
        $PHPMailer->SetFrom($SenderEmail,'no-reply@PSD2LIVE');
        $PHPMailer->AddReplyTo($ReplyTo);
        $PHPMailer->AddAddress($ReceiverEmail,'no-reply@PSD2LIVE');
        $PHPMailer->Subject =$Subject;
        $PHPMailer->IsHTML(true);
        $PHPMailer->MsgHTML($Content);
        return $PHPMailer->send();

    }


}

?>