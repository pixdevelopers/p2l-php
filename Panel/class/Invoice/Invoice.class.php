<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 2/6/2018 AD
 * Time: 17:54
 */
$ROOT = dirname(dirname(dirname(dirname(__FILE__))));

require_once($ROOT.'/Panel/class/General/General.class.php');
require_once($ROOT.'/Panel/class/Package/Package.class.php');

class Invoice {

    /*
     * Status: 1 -> Unconfirmed
     * Status: 2 -> Confirmed, Unpaid
     * Status: 3 -> Paid
     * Features[FeatureID]
     * Files[FileNames]
     */
    public function AddInvoice($UserID, $PackageID, $PageCount, $UserDuration, $Price, $Desc, array $Features, array $Files)
    {
        $General = new General();
        $Package = new Package();

        $con = $General->Connect();

        mysqli_autocommit($con, FALSE);

        $OT = time();

        if($PackageID != ''){
            mysqli_query($con, "INSERT INTO `invoice_hdr` VALUES(NULL, '$UserID','$PackageID','$PageCount','$UserDuration','$Price','$Desc','$OT',NULL,'0', '0','', '0', '1')");
        }
        else{
            mysqli_query($con, "INSERT INTO `invoice_hdr` VALUES(NULL, '$UserID',NULL,'$PageCount','$UserDuration','$Price','$Desc','$OT',NULL,'0', '0','', '0', '1')");
        }
        if (mysqli_affected_rows($con) > 0) {
            $HdrID = mysqli_insert_id($con);

            ######### Insert feature list #########
            $Values = '';
            if($PackageID != ''){               //Get list of package features
                $ListFeatures = $Package->SelectPackage('','1','','','',$PackageID,'','','');
                while($row_feature = mysqli_fetch_assoc($ListFeatures)){
                    $FeatureID = $row_feature['ID'];
                    if ($Values != '') {
                        $Values = $Values . ',';
                    }
                    $Values = $Values . "(NULL,'$HdrID','$FeatureID')";
                }
            }
            elseif(count($Features)>0){
                for ($i = '0'; $i < count($Features); $i++) {
                    if ($Values != '') {
                        $Values = $Values . ',';
                    }
                    $Values = $Values . "(NULL,'$HdrID','$Features[$i]')";
                }
            }
            else{
                $msg['Type'] = '3';
                $msg['Msg'] = 'You should select package or features';
                $result = json_encode($msg);
                mysqli_rollback($con);
                return $result;
            }

            $query = mysqli_query($con,"INSERT INTO `invoice_dtl` $Values");
            if(!$query){
                $msg['Type'] = '3';
                $msg['Msg'] = 'Operation failed (Step 2)<br>' . mysqli_error($con);
                $result = json_encode($msg);
                mysqli_rollback($con);
                return $result;
            }

            ######### Insert file names #########

            $Values = '';
            if(count($Files)>0){
                for ($i = '0'; $i < count($Files); $i++) {
                    if ($Values != '') {
                        $Values = $Values . ',';
                    }
                    $Values = $Values . "(NULL,'$HdrID','$Files[$i]','1','$UserID',NULL)";
                }
            }
            else{
                $msg['Type'] = '3';
                $msg['Msg'] = 'No files selected';
                $result = json_encode($msg);
                mysqli_rollback($con);
                return $result;
            }

            $query = mysqli_query($con,"INSERT INTO `invoice_files` $Values");
            if(!$query){
                $msg['Type'] = '3';
                $msg['Msg'] = 'Operation failed (Step 3)<br>' . mysqli_error($con);
                $result = json_encode($msg);
                mysqli_rollback($con);
                return $result;
            }


            mysqli_commit($con);

            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);


        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed (Step 1)<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    public function CorroborantInvoice($ID, $CorroborantID, $CorroborantDuration, $FinalPrice, $CorroborantDesc)
    {
        $General = new General();

        $con = $General->Connect();

        $CT = time();

        $query = mysqli_query($con, "UPDATE `invoice_hdr` SET `CorroborantID`='$CorroborantID', `CorroborantDuration`='$CorroborantDuration', `FinalPrice`='$FinalPrice', `CorroborantDesc`='$CorroborantDesc', `CT`='$CT', `Status`='2' WHERE (`ID`='$ID')");                //UPDATE Hdr
        if ($query) {

            $msg['Type'] = '1';
            $msg['Msg'] = 'Operation completed successfully.';
            $result = json_encode($msg);


        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed<br>' . mysqli_error($con);
            $result = json_encode($msg);
            mysqli_rollback($con);
        }

        return $result;

    }

    public function SelectInvoice($Hdr,$Dtl,$Files,$ID,$UserID,$PackageID,$FROM_OT,$TO_OT,$CorroborantID,$FROM_CT,$TO_CT,$Status,$HdrID,$Type,$ORDER_BY,$ORDER_TYPE,$LIMIT){              //List invoice
        $General = new General();
        $con = $General->Connect();

        if($LIMIT != ''){
            $LIMIT = "LIMIT $LIMIT";
        }
        if($ORDER_BY != ''){
            $ORDER_BY = "ORDER BY $ORDER_BY";
        }

        $Condition = '';
        if($Hdr == '1'){
            if($ID != '') {
                $Condition = " (`ID`='$ID')";
            }
            if($UserID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`UserID`='$UserID')";
            }
            if($PackageID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`PackageID`='$PackageID')";
            }
            if($FROM_OT != '' AND $TO_OT){
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`OT` BETWEEN '$FROM_OT' AND '$TO_OT')";
            }
            elseif($FROM_OT != ''){
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`OT` >= '$FROM_OT')";
            }
            elseif($TO_OT != ''){
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`OT` <= '$TO_OT')";
            }
            if($CorroborantID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`CorroborantID`='$CorroborantID')";
            }
            if($FROM_CT != '' AND $TO_CT){
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`CT` BETWEEN '$FROM_CT' AND '$TO_CT')";
            }
            elseif($FROM_CT != ''){
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`CT` >= '$FROM_CT')";
            }
            elseif($TO_CT != ''){
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`CT` <= '$TO_CT')";
            }
            if($Status != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`Status`='$Status')";
            }
            if($Condition != '') {
                $Query = mysqli_query($con, "SELECT * FROM `invoice_hdr` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `invoice_hdr` $ORDER_BY $ORDER_TYPE $LIMIT");
            }
        }
        elseif($Dtl == '1'){
            if($ID != '') {
                $Condition = " (`ID`='$ID')";
            }
            if($HdrID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`HdrID`='$HdrID')";
            }
            if($Condition != '') {
                $Query = mysqli_query($con, "SELECT * FROM `invoice_dtl` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `invoice_dtl` $ORDER_BY $ORDER_TYPE $LIMIT");
            }
        }
        elseif($Files == '1'){
            if($ID != '') {
                $Condition = " (`ID`='$ID')";
            }
            if($HdrID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`HdrID`='$HdrID')";
            }
            if($Type != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`Type`='$Type')";
            }
            if($UserID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`UserID`='$UserID')";
            }
            if($Condition != '') {
                $Query = mysqli_query($con, "SELECT * FROM `invoice_files` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `invoice_files` $ORDER_BY $ORDER_TYPE $LIMIT");
            }
        }

        return $Query;
    }


}

?>