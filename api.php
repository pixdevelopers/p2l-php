<?php

header("Content-Type: application/json; charset=UTF-8");
$Parameters = json_decode(file_get_contents('php://input'), true);

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

if(isset($Parameters['Request']) AND $Parameters['Request'] != ''){
    $Request = $Parameters['Request'];

    if($Request == 'SelectFeatures'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Features->Select($ID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
                $Result[$row['ID']]['ID'] = $row['ID'];
                $Result[$row['ID']]['Name'] = $row['Name'];
                $Result[$row['ID']]['Desc'] = $row['Desc'];
                $Result[$row['ID']]['Price'] = $row['Price'];
                $Result[$row['ID']]['CategoryID'] = $row['CategoryID'];
                $Result[$row['ID']]['Status'] = $row['Status'];
            }

            $JsonArray = json_encode($Result);
        }

    }
    elseif($Request == 'SelectFeaturesCategories'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Features->SelectCategory($ID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
                $Result[$row['ID']]['ID'] = $row['ID'];
                $Result[$row['ID']]['Name'] = $row['Name'];
                $Result[$row['ID']]['Desc'] = $row['Desc'];
                $Result[$row['ID']]['Status'] = $row['Status'];
            }

            $JsonArray = json_encode($Result);
        }

    }
    elseif($Request == 'SelectInvoice'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['UserID'])){
            $UserID = $Parameters['UserID'];
        }
        else{
            $UserID = '';
        }

        if(isset($Parameters['PackageID'])){
            $PackageID = $Parameters['PackageID'];
        }
        else{
            $PackageID = '';
        }

        if(isset($Parameters['FROM_OT'])){
            $FROM_OT = $Parameters['FROM_OT'];
        }
        else{
            $FROM_OT = '';
        }

        if(isset($Parameters['TO_OT'])){
            $TO_OT = $Parameters['TO_OT'];
        }
        else{
            $TO_OT = '';
        }

        if(isset($Parameters['CorroborantID'])){
            $CorroborantIDD = $Parameters['CorroborantID'];
        }
        else{
            $CorroborantID = '';
        }

        if(isset($Parameters['FROM_CT'])){
            $FROM_CT = $Parameters['FROM_CT'];
        }
        else{
            $FROM_CT = '';
        }

        if(isset($Parameters['TO_CT'])){
            $TO_CT = $Parameters['TO_CT'];
        }
        else{
            $TO_CT = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Invoice->SelectInvoice('1','','',$ID,$UserID,$PackageID,$FROM_OT,$TO_OT,$CorroborantID,$FROM_CT,$TO_CT,$Status,'','',$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
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

                $ListDtl = $Invoice->SelectInvoice('', '1', '', '', '', '', '', '', '', '', '', '', $HdrID, '', '', '', '');
                while ($row_Dtl = mysqli_fetch_assoc($ListDtl)) {
                    $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['ID'] = $row_Dtl['ID'];
                    $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['HdrID'] = $row_Dtl['HdrID'];
                    $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['FeatureID'] = $row_Dtl['FeatureID'];
                }

                $ListFiles = $Invoice->SelectInvoice('', '', '1', '', '', '', '', '', '', '', '', '', $HdrID, '', '', '', '');
                while ($row_Files = mysqli_fetch_assoc($ListFiles)) {
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

    }
    elseif($Request == 'SelectPackage'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Package->SelectPackage('1','',$ID,'',$Status,'',$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
                $HdrID = $row['ID'];

                $Result[$row['ID']]['Hdr']['ID'] = $row['ID'];
                $Result[$row['ID']]['Hdr']['Name'] = $row['Name'];
                $Result[$row['ID']]['Hdr']['Price'] = $row['Price'];
                $Result[$row['ID']]['Hdr']['Status'] = $row['Status'];

                $ListDtl = $Package->SelectPackage('', '1', '', '', '', $HdrID, '', '', '');
                while ($row_Dtl = mysqli_fetch_assoc($ListDtl)) {
                    $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['ID'] = $row_Dtl['ID'];
                    $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['HdrID'] = $row_Dtl['HdrID'];
                    $Result[$row['ID']]['Dtl'][$row_Dtl['ID']]['FeatureID'] = $row_Dtl['FeatureID'];
                }

            }

            $JsonArray = json_encode($Result);
        }

    }
    elseif($Request == 'SelectAdmin'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['Username'])){
            $Username = $Parameters['Username'];
        }
        else{
            $Username = '';
        }

        if(isset($Parameters['GroupID'])){
            $GroupID = $Parameters['GroupID'];
        }
        else{
            $GroupID = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Users->SelectAdmin($ID,$Username,$GroupID,$Status,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
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

    }
    elseif($Request == 'SelectUser'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['Email'])){
            $Email = $Parameters['Email'];
        }
        else{
            $Email = '';
        }

        if(isset($Parameters['Name'])){
            $Name = $Parameters['Name'];
        }
        else{
            $Name = '';
        }

        if(isset($Parameters['Family'])){
            $Family = $Parameters['Family'];
        }
        else{
            $Family = '';
        }

        if(isset($Parameters['RT_FROM'])){
            $RT_FROM = $Parameters['RT_FROM'];
        }
        else{
            $RT_FROM = '';
        }

        if(isset($Parameters['RT_TO'])){
            $RT_TO = $Parameters['RT_TO'];
        }
        else{
            $RT_TO = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $Users->SelectUser($ID,$Email,$Name,$Family,$Status,$RT_FROM,$RT_TO,$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
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

    }
    elseif($Request == 'SelectUserGroups'){

        if(isset($Parameters['ID'])){
            $ID = $Parameters['ID'];
        }
        else{
            $ID = '';
        }

        if(isset($Parameters['Status'])){
            $Status = $Parameters['Status'];
        }
        else{
            $Status = '';
        }

        if(isset($Parameters['ORDER_BY'])){
            $ORDER_BY = $Parameters['ORDER_BY'];
        }
        else{
            $ORDER_BY = '';
        }

        if(isset($Parameters['ORDER_TYPE'])){
            $ORDER_TYPE = $Parameters['ORDER_TYPE'];
        }
        else{
            $ORDER_TYPE = '';
        }

        if(isset($Parameters['LIMIT'])){
            $LIMIT = $Parameters['LIMIT'];
        }
        else{
            $LIMIT = '';
        }

        $List = $UserGroups->SelectUserGroups('1','',$ID,$Status,'',$ORDER_BY,$ORDER_TYPE,$LIMIT);
        if(mysqli_num_rows($List)>0) {
            while ($row = mysqli_fetch_assoc($List)) {
                $HdrID = $row['ID'];

                $Result[$row['ID']]['ID'] = $row['ID'];
                $Result[$row['ID']]['Name'] = $row['Name'];
                $Result[$row['ID']]['Status'] = $row['Status'];

            }

            $JsonArray = json_encode($Result);
        }

    }
    elseif($Request == 'AddFeature'){

        $JsonArray = $Features->Add($Parameters['Name'],$Parameters['Desc'],$Parameters['Price'],$Parameters['CategoryID']);

    }
    elseif($Request == 'EditFeature'){

        $JsonArray = $Features->Edit($Parameters['ID'],$Parameters['Name'],$Parameters['Desc'],$Parameters['Price'],$Parameters['CategoryID'],$Parameters['Status']);

    }
    elseif($Request == 'DeleteFeature'){

        $JsonArray = $Features->Delete($Parameters['ID']);

    }
    elseif($Request == 'AddFeatureCategory'){

        $JsonArray = $Features->AddCategory($Parameters['Name'],$Parameters['Desc']);

    }
    elseif($Request == 'EditFeatureCategory'){

        $JsonArray = $Features->EditCategory($Parameters['ID'],$Parameters['Name'],$Parameters['Desc'],$Parameters['Status']);

    }
    elseif($Request == 'DeleteFeatureCategory'){

        $JsonArray = $Features->DeleteCategory($Parameters['ID']);

    }
    elseif($Request == 'AddInvoice'){

        $JsonArray = $Invoice->AddInvoice($Parameters['UserID'],$Parameters['PackageID'],$Parameters['PageCount'],$Parameters['UserDuration'],$Parameters['Price'],$Parameters['Desc'],$Parameters['Features'],$Parameters['Files']);

    }
    elseif($Request == 'CorroborantInvoice'){

        $JsonArray = $Invoice->CorroborantInvoice($Parameters['ID'],$Parameters['CorroborantID'],$Parameters['CorroborantDuration'],$Parameters['FinalPrice'],$Parameters['CorroborantDesc']);

    }
    elseif($Request == 'AddPackage'){

        $JsonArray = $Package->AddPackage($Parameters['Name'],$Parameters['Price'],'0',$Parameters['Features']);

    }
    elseif($Request == 'EditPackage'){

        $JsonArray = $Package->EditPackage($Parameters['ID'],$Parameters['Name'],$Parameters['Price'],'0',$Parameters['Status'],$Parameters['Features']);

    }
    elseif($Request == 'DeletePackage'){

        $JsonArray = $Package->DeletePackage($Parameters['ID']);

    }
    elseif($Request == 'AddUserGroup'){

        $JsonArray = $UserGroups->AddUserGroup($Parameters['Name'],$Parameters['Privilege']);

    }
    elseif($Request == 'EditUserGroup'){

        $JsonArray = $UserGroups->EditUserGroup($Parameters['ID'],$Parameters['Name'],$Parameters['Status'],$Parameters['Privilege']);

    }
    elseif($Request == 'DeleteUserGroup'){

        $JsonArray = $UserGroups->DeleteUserGroup($Parameters['ID']);

    }
    elseif($Request == 'AddAdmin'){

        $JsonArray = $Users->AddAdmin($Parameters['Username'],$Parameters['Password'],$Parameters['Name'],$Parameters['IsSuperadmin'],$Parameters['GroupID']);

    }
    elseif($Request == 'EditAdmin'){

        $JsonArray = $Users->EditAdmin($Parameters['ID'],$Parameters['Username'],$Parameters['Name'],$Parameters['IsSuperadmin'],$Parameters['GroupID'],$Parameters['Status']);

    }
    elseif($Request == 'DeleteAdmin'){

        $JsonArray = $Users->DeleteAdmin($Parameters['ID']);

    }
    elseif($Request == 'AddUser'){

        $JsonArray = $Users->AddUser($Parameters['Email'],$Parameters['Password'],$Parameters['Name'],$Parameters['Family']);

    }
    elseif($Request == 'VerifyUserEmail'){

        $JsonArray = $Users->VerifyEmail($Parameters['Email'],$Parameters['PIN']);

    }
    elseif($Request == 'EditUser'){

        $JsonArray = $Users->EditUser($Parameters['ID'],$Parameters['Email'],$Parameters['Name'],$Parameters['Family'],$Parameters['Status']);

    }
    elseif($Request == 'DeleteUser'){

        $JsonArray = $Users->DeleteUser($Parameters['ID']);

    }
    elseif($Request == 'RequestPIN'){

        $JsonArray = $Users->RequestPIN($Parameters['Email'],$Parameters['PIN'],'1');

    }
    elseif($Request == 'RequestVerificationEmail'){

        $JsonArray = $Users->RequestVerificationEmail($Parameters['Email']);

    }

    if(isset($JsonArray)) {
        print_r($JsonArray);
    }

}
?>