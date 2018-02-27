<?php
require_once ('Panel/class/Features/Features.class.php');
require_once ('Panel/class/Invoice/Invoice.class.php');
require_once ('Panel/class/Package/Package.class.php');
require_once ('Panel/class/UserGroups/UserGroups.class.php');
require_once ('Panel/class/Users/Users.class.php');
$Features = new Features();
$Invoice = new Invoice();
$Package = new Package();
$UserGroups = new UserGroups();
$Users = new Users();

if(isset($_POST['Request']) AND $_POST['Request'] != ''){
    $Request = $_POST['Request'];

    if($Request == 'SelectFeatures'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Features->Select($ID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $Result[$row['ID']]['ID'] = $row['ID'];
            $Result[$row['ID']]['Name'] = $row['Name'];
            $Result[$row['ID']]['Desc'] = $row['Desc'];
            $Result[$row['ID']]['Price'] = $row['Price'];
            $Result[$row['ID']]['CategoryID'] = $row['CategoryID'];
            $Result[$row['ID']]['Status'] = $row['Status'];
        }

        $JsonArray = json_encode($Result);

    }
    elseif($Request == 'SelectFeaturesCategories'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Features->SelectCategory($ID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $Result[$row['ID']]['ID'] = $row['ID'];
            $Result[$row['ID']]['Name'] = $row['Name'];
            $Result[$row['ID']]['Desc'] = $row['Desc'];
            $Result[$row['ID']]['Status'] = $row['Status'];
        }

        $JsonArray = json_encode($Result);

    }
    elseif($Request == 'SelectInvoice'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['UserID'])){
            $UserID = $_POST['UserID'];
        }
        else{
            $UserID = '';
        }

        if(isset($_POST['PackageID'])){
            $PackageID = $_POST['PackageID'];
        }
        else{
            $PackageID = '';
        }

        if(isset($_POST['FROM_OT'])){
            $FROM_OT = $_POST['FROM_OT'];
        }
        else{
            $FROM_OT = '';
        }

        if(isset($_POST['TO_OT'])){
            $TO_OT = $_POST['TO_OT'];
        }
        else{
            $TO_OT = '';
        }

        if(isset($_POST['CorroborantID'])){
            $CorroborantIDD = $_POST['CorroborantID'];
        }
        else{
            $CorroborantID = '';
        }

        if(isset($_POST['FROM_CT'])){
            $FROM_CT = $_POST['FROM_CT'];
        }
        else{
            $FROM_CT = '';
        }

        if(isset($_POST['TO_CT'])){
            $TO_CT = $_POST['TO_CT'];
        }
        else{
            $TO_CT = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Invoice->SelectInvoice('1','','',$ID,$UserID,$PackageID,$FROM_OT,$TO_OT,$CorroborantID,$FROM_CT,$TO_CT,$Status,'','',$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $HdrID = $row['ID'];

            $Result[$row['ID']]['Hdr']['ID'] = $row['ID'];
            $Result[$row['ID']]['Hdr']['UserID'] = $row['UserID'];
            $Result[$row['ID']]['Hdr']['PackageID'] = $row['PackageID'];
            $Result[$row['ID']]['Hdr']['PageCount'] = $row['PageCount'];
            $Result[$row['ID']]['Hdr']['UserDuration'] = $row['UserDuration'];
            $Result[$row['ID']]['Hdr']['Price'] = $row['Price'];
            $Result[$row['ID']]['Hdr']['Desc'] = $row['Desc'];
            $Result[$row['ID']]['Hdr']['OT'] = $row['OT'];
            $Result[$row['ID']]['Hdr']['CorroborantID'] = $row['CorroborantID'];
            $Result[$row['ID']]['Hdr']['CorroborantDuration'] = $row['CorroborantDuration'];
            $Result[$row['ID']]['Hdr']['FinalPrice'] = $row['FinalPrice'];
            $Result[$row['ID']]['Hdr']['CorroborantDesc'] = $row['CorroborantDesc'];
            $Result[$row['ID']]['Hdr']['CT'] = $row['CT'];
            $Result[$row['ID']]['Hdr']['Status'] = $row['Status'];

            $ListDtl = $Invoice->SelectInvoice('','1','','','','','','','','','','',$HdrID,'','','','');
            while($row_Dtl = mysqli_fetch_assoc($ListDtl)){
                $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['ID'] = $row_Dtl['ID'];
                $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['HdrID'] = $row_Dtl['HdrID'];
                $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['FeatureID'] = $row_Dtl['FeatureID'];
            }

            $ListFiles = $Invoice->SelectInvoice('','','1','','','','','','','','','',$HdrID,'','','','');
            while($row_Files = mysqli_fetch_assoc($ListFiles)){
                $Result[$row['ID']]['Files'][$row_Files['ID']]['ID'] = $row_Files['ID'];
                $Result[$row['ID']]['Files'][$row_Files['ID']]['InvoiceHdrID'] = $row_Files['InvoiceHdrID'];
                $Result[$row['ID']]['Files'][$row_Files['ID']]['FileName'] = $row_Files['FileName'];
                $Result[$row['ID']]['Files'][$row_Files['ID']]['Type'] = $row_Files['Type'];
                $Result[$row['ID']]['Files'][$row_Files['ID']]['UserID'] = $row_Files['UserID'];
                $Result[$row['ID']]['Files'][$row_Files['ID']]['AdminID'] = $row_Files['AdminID'];
            }
        }

        $JsonArray = json_encode($Result);

    }
    elseif($Request == 'SelectPackage'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Package->SelectPackage('1','',$ID,'',$Status,'',$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $HdrID = $row['ID'];

            $Result[$row['ID']]['Hdr']['ID'] = $row['ID'];
            $Result[$row['ID']]['Hdr']['Name'] = $row['Name'];
            $Result[$row['ID']]['Hdr']['Price'] = $row['Price'];
            $Result[$row['ID']]['Hdr']['Status'] = $row['Status'];

            $ListDtl = $Package->SelectPackage('','1','','','',$HdrID,'','','');
            while($row_Dtl = mysqli_fetch_assoc($ListDtl)){
                $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['ID'] = $row_Dtl['ID'];
                $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['HdrID'] = $row_Dtl['HdrID'];
                $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['FeatureID'] = $row_Dtl['FeatureID'];
            }

        }

        $JsonArray = json_encode($Result);

    }
    elseif($Request == 'SelectAdmin'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['Username'])){
            $Username = $_POST['Username'];
        }
        else{
            $Username = '';
        }

        if(isset($_POST['GroupID'])){
            $GroupID = $_POST['GroupID'];
        }
        else{
            $GroupID = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Users->SelectAdmin($ID,$Username,$GroupID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $HdrID = $row['ID'];

            $Result[$row['ID']]['ID'] = $row['ID'];
            $Result[$row['ID']]['UserName'] = $row['UserName'];
            $Result[$row['ID']]['Name'] = $row['Name'];
            $Result[$row['ID']]['IsSuperadmin'] = $row['IsSuperadmin'];
            $Result[$row['ID']]['GroupID'] = $row['GroupID'];
            $Result[$row['ID']]['Status'] = $row['Status'];

        }

        $JsonArray = json_encode($Result);

    }
    elseif($Request == 'SelectUser'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['Email'])){
            $Email = $_POST['Email'];
        }
        else{
            $Email = '';
        }

        if(isset($_POST['Name'])){
            $Name = $_POST['Name'];
        }
        else{
            $Name = '';
        }

        if(isset($_POST['Family'])){
            $Family = $_POST['Family'];
        }
        else{
            $Family = '';
        }

        if(isset($_POST['RT_FROM'])){
            $RT_FROM = $_POST['RT_FROM'];
        }
        else{
            $RT_FROM = '';
        }

        if(isset($_POST['RT_TO'])){
            $RT_TO = $_POST['RT_TO'];
        }
        else{
            $RT_TO = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Users->SelectUser($ID,$Email,$Name,$Family,$Status,$RT_FROM,$RT_TO,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $HdrID = $row['ID'];

            $Result[$row['ID']]['ID'] = $row['ID'];
            $Result[$row['ID']]['Email'] = $row['Email'];
            $Result[$row['ID']]['Name'] = $row['Name'];
            $Result[$row['ID']]['Family'] = $row['Family'];
            $Result[$row['ID']]['PIN'] = $row['PIN'];
            $Result[$row['ID']]['Status'] = $row['Status'];
            $Result[$row['ID']]['RT'] = $row['RT'];

        }

        $JsonArray = json_encode($Result);

    }
    elseif($Request == 'SelectUserGroups'){

        if(isset($_POST['ID'])){
            $ID = $_POST['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($_POST['Status'])){
            $Status = $_POST['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($_POST['ORDER_BY'])){
            $ORDER_BY = $_POST['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($_POST['ORDER_TYPE'])){
            $ORDER_TYPE = $_POST['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($_POST['LIMIT'])){
            $LIMIT = $_POST['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $UserGroups->SelectUserGroups('1','',$ID,$Status,'',$ORDER_BY,$ORDER_TYPE,$LIMIT);
        while($row = mysqli_fetch_assoc($List)){
            $HdrID = $row['ID'];

            $Result[$row['ID']]['ID'] = $row['ID'];
            $Result[$row['ID']]['Name'] = $row['Name'];
            $Result[$row['ID']]['Status'] = $row['Status'];

        }

        $JsonArray = json_encode($Result);

    }

    print_r($JsonArray);

}
?>