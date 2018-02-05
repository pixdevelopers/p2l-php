<?php
/**
 * Created by Mohammad reza Moshaver.
 * Date: 1/22/2018 AD
 * Time: 08:37
 */
$ROOT = dirname(dirname(dirname(dirname(__FILE__))));

require_once($ROOT.'/Panel/class/General/General.class.php');

class Features {

    /*
     * Status: 1 -> Enable
     * Status: 0 -> Disable
     */
    public function Add($Name, $Desc, $Price, $CategoryID)
    {
        $General = new General();

        $con = $General->Connect();

        mysqli_query($con, "INSERT INTO `features` VALUES(NULL, '$Name','$Desc','$Price','$CategoryID', '1')");
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

    public function Edit($ID,$Name, $Desc, $Price, $CategoryID, $Status)
    {
        $General = new General();

        $con = $General->Connect();

        $query = mysqli_query($con, "UPDATE `features` SET `Name`='$Name', `Desc`='$Desc', `Price`='$Price', `CategoryID`='$CategoryID', `Status`='$Status' WHERE (`ID`='$ID')");
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

    public function Delete($ID)
    {
        $General = new General();

        $con = $General->Connect();

        $query = mysqli_query($con, "DELETE FROM `features` WHERE (`ID`='$ID')");
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

    public function Select($ID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT)
    {
        $General = new General();
        $con = $General->Connect();

        if ($LIMIT != '') {
            $LIMIT = "LIMIT $LIMIT";
        }
        if ($ORDER_BY != '') {
            $ORDER_BY = "ORDER BY $ORDER_BY";
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Status`='$Status')";
        }
        if ($Condition != '') {
            $Query = mysqli_query($con, "SELECT * FROM `features` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
        } else {
            $Query = mysqli_query($con, "SELECT * FROM `features` $ORDER_BY $ORDER_TYPE $LIMIT");
        }


        return $Query;
    }

    /*
     * Status: 1 -> Enable
     * Status: 0 -> Disable
     */
    public function AddCategory($Name, $Desc)
    {
        $General = new General();

        $con = $General->Connect();

        mysqli_query($con, "INSERT INTO `feature_category` VALUES(NULL, '$Name','$Desc', '1')");
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

    public function EditCategory($ID,$Name, $Desc, $Status)
    {
        $General = new General();

        $con = $General->Connect();

        $query = mysqli_query($con, "UPDATE `feature_category` SET `Name`='$Name', `Desc`='$Desc', `Status`='$Status' WHERE (`ID`='$ID')");
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

    public function DeleteCategory($ID)
    {
        $General = new General();

        $con = $General->Connect();

        $query = mysqli_query($con, "DELETE FROM `feature_category` WHERE (`ID`='$ID')");
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

    public function SelectCategory($ID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT)
    {
        $General = new General();
        $con = $General->Connect();

        if ($LIMIT != '') {
            $LIMIT = "LIMIT $LIMIT";
        }
        if ($ORDER_BY != '') {
            $ORDER_BY = "ORDER BY $ORDER_BY";
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition = $Condition . ' AND ';
            }
            $Condition = $Condition . "(`Status`='$Status')";
        }
        if ($Condition != '') {
            $Query = mysqli_query($con, "SELECT * FROM `feature_category` WHERE $Condition $ORDER_BY $ORDER_TYPE $LIMIT");
        } else {
            $Query = mysqli_query($con, "SELECT * FROM `feature_category` $ORDER_BY $ORDER_TYPE $LIMIT");
        }


        return $Query;
    }


}

?>