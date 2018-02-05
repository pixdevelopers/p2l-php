<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/20/2018 AD
 * Time: 19:52
 */
$ROOT = dirname(dirname(dirname(dirname(__FILE__))));

require_once($ROOT.'/Panel/class/General/General.class.php');

class UserGroups {

    /*
     * Status: 1 -> Enable
     * Status: 0 -> Disable
     * Privilege[PrivilegeName]
     */
    public function AddUserGroup($Name, array $Privilege)
    {
        $General = new General();

        $con = $General->Connect();

        mysqli_autocommit($con, FALSE);

        mysqli_query($con, "INSERT INTO `usergroups_hdr` VALUES(NULL, '$Name', '1')");
        if (mysqli_affected_rows($con) > 0) {
            $HdrID = mysqli_insert_id($con);

            $Values = '';
            for ($i = '0'; $i < count($Privilege); $i++) {
                if ($Values != '') {
                    $Values = $Values . ',';
                }
                $Values = $Values . "(NULL,'$HdrID','$Privilege[$i]')";
            }
            mysqli_query($con, "INSERT INTO `usergroups_dtl` VALUES $Values");
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
     * Privilege[CurrentID][PrivilegeName]
     */
    public function EditUserGroup($ID, $Name, $Status, array $Privilege)
    {
        $General = new General();

        $con = $General->Connect();

        mysqli_autocommit($con, FALSE);

        $query = mysqli_query($con, "UPDATE `usergroups_hdr` SET `Name`='$Name', `Status`='$Status' WHERE (`ID`='$ID')");                //UPDATE Hdr
        if ($query) {

            $query = mysqli_query($con,"DELETE FROM `usergroups_dtl` WHERE (`HdrID`='$ID')");               //Delete old Dtl values
            if($query){

                $Values = '';
                for ($i = '0'; $i < count($Privilege); $i++) {
                    if ($Values != '') {
                        $Values = $Values . ',';
                    }
                    $Values = $Values . "(NULL,'$ID','$Privilege[$i]')";
                }
                $query = mysqli_query($con, "INSERT INTO `usergroups_dtl` VALUES $Values");
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

    public function DeleteUserGroup($ID)
    {
        $General = new General();

        $con = $General->Connect();

        $query = mysqli_query($con, "DELETE FROM `usergroups_hdr` WHERE (`ID`='$ID')");
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

    public function SelectUserGroups($Hdr,$Privilege,$ID,$Status,$PartID,$ORDER_BY,$ORDER_TYPE,$LIMIT){              //لیست گروه های کاربری
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
            if($Status != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`Status`='$Status')";
            }
            if($Condition != '') {
                $Query = mysqli_query($con, "SELECT * FROM `usergroups_hdr` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `usergroups_hdr` $ORDER_BY $ORDER_TYPE $LIMIT");
            }
        }
        elseif($Privilege == '1'){
            if($ID != '') {
                $Condition = " (`ID`='$ID')";
            }
            if($PartID != '') {
                if($Condition != '') {
                    $Condition = $Condition . ' AND ';
                }
                $Condition = $Condition . "(`PartID`='$PartID')";
            }
            if($Condition != '') {
                $Query = mysqli_query($con, "SELECT * FROM `privileges` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
            }
            else{
                $Query = mysqli_query($con, "SELECT * FROM `privileges` $ORDER_BY $ORDER_TYPE $LIMIT");
            }
        }

        return $Query;
    }

    public function CheckGroupAndPrivilegeRelation($GroupID,$Privilege){                //بررسی وجود داشتن دسترسی در یک گروه
        $General = new General();
        $con = $General->Connect();

        $check = mysqli_query($con,"SELECT `ID` FROM `usergroups_dtl` WHERE (`HdrID` = '$GroupID' AND `Privilege` = '$Privilege') LIMIT 1");
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