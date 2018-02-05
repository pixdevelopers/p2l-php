<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/24/2018 AD
 * Time: 21:50
 */
$ROOT = dirname(dirname(dirname(dirname(__FILE__))));

require_once($ROOT.'/Panel/class/General/General.class.php');

class Package {

    /*
     * Status: 1 -> Enable
     * Status: 0 -> Disable
     * Features[FeatureID]
     */
    public function AddPackage($Name, $Price, $IsSpecial, array $Features)
    {
        $General = new General();

        $con = $General->Connect();

        mysqli_autocommit($con, FALSE);

        mysqli_query($con, "INSERT INTO `package_hdr` VALUES(NULL, '$Name', '$Price', '$IsSpecial', '1')");
        if (mysqli_affected_rows($con) > 0) {
            $HdrID = mysqli_insert_id($con);

            $Values = '';
            for ($i = '0'; $i < count($Features); $i++) {
                if ($Values != '') {
                    $Values = $Values . ',';
                }
                $Values = $Values . "(NULL,'$HdrID','$Features[$i]')";
            }
            mysqli_query($con, "INSERT INTO `package_dtl` VALUES $Values");
            if (mysqli_affected_rows($con) > 0) {
                mysqli_commit($con);

                $msg['Type'] = '1';
                $msg['Msg'] = 'Operation completed successfully.';
                $result = json_encode($msg);
            } else {
                $msg['Type'] = '3';
                $msg['Msg'] = 'Operation failed (Step 2)<br>' . mysqli_error($con);
                $result = json_encode($msg);
                mysqli_rollback($con);
            }

        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed (Step 2)<br>' . mysqli_error($con);
            $result = json_encode($msg);
        }

        return $result;

    }

    /*
     * Features[FeatureID]
     */
    public function EditPackage($ID, $Name, $Price, $IsSpecial, $Status, array $Features)
    {
        $General = new General();

        $con = $General->Connect();

        mysqli_autocommit($con, FALSE);

        $query = mysqli_query($con, "UPDATE `package_hdr` SET `Name`='$Name', `Price`='$Price', `IsSpecial`='$IsSpecial', `Status`='$Status' WHERE (`ID`='$ID')");                //UPDATE Hdr
        if ($query) {

            $query = mysqli_query($con,"DELETE FROM `package_dtl` WHERE (`HdrID`='$ID')");               //Delete old Dtl values
            if($query){

                $Values = '';
                for ($i = '0'; $i < count($Features); $i++) {
                    if ($Values != '') {
                        $Values = $Values . ',';
                    }
                    $Values = $Values . "(NULL,'$ID','$Features[$i]')";
                }
                $query = mysqli_query($con, "INSERT INTO `package_dtl` VALUES $Values");
                if($query){
                    mysqli_commit($con);

                    $msg['Type'] = '1';
                    $msg['Msg'] = 'Operation completed successfully.';
                    $result = json_encode($msg);
                }
                else{
                    $msg['Type'] = '3';
                    $msg['Msg'] = 'Operation failed (Step 3)<br>' . mysqli_error($con);
                    $result = json_encode($msg);
                    mysqli_rollback($con);
                }

            }
            else{
                $msg['Type'] = '3';
                $msg['Msg'] = 'Operation failed (Step 2)br>' . mysqli_error($con);
                $result = json_encode($msg);
                mysqli_rollback($con);
            }


        } else {
            $msg['Type'] = '3';
            $msg['Msg'] = 'Operation failed (Step 1)<br>' . mysqli_error($con);
            $result = json_encode($msg);
            mysqli_rollback($con);
        }

        return $result;

    }

    public function DeletePackage($ID)
    {
        $General = new General();

        $con = $General->Connect();

        $query = mysqli_query($con, "DELETE FROM `package_hdr` WHERE (`ID`='$ID')");
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

    public function SelectPackage($Hdr,$Dtl,$ID,$IsSpecial,$Status,$HdrID,$ORDER_BY,$ORDER_TYPE,$LIMIT){              //لیست گروه های کاربری
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
            if($IsSpecial != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`IsSpecial`='$IsSpecial')";
            }
            if($Status != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`Status`='$Status')";
            }
            if($Condition != '') {
                $Query = mysqli_query($con, "SELECT * FROM `package_hdr` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `package_hdr` $ORDER_BY $ORDER_TYPE $LIMIT");
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
                $Query = mysqli_query($con, "SELECT * FROM `package_dtl` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `package_dtl` $ORDER_BY $ORDER_TYPE $LIMIT");
            }
        }

        return $Query;
    }

    public function CheckPackageAndFeatureRelation($PackageID,$FeatureID){
        $General = new General();
        $con = $General->Connect();

        $check = mysqli_query($con,"SELECT `ID` FROM `package_dtl` WHERE (`HdrID` = '$PackageID' AND `FeatureID` = '$FeatureID') LIMIT 1");
        if(mysqli_num_rows($check)>0){
            $row_check = mysqli_fetch_assoc($check);
            return $row_check['ID'];
        }
        else{
            return '0';
        }
    }


}

?>