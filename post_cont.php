<?php
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/global.php");

$sn = (int)GtInput_Secure($_GET["dirsn"]);
if($sn == NULL) {
  $sn = 1;
}
//$name = GtInput_Secure($parameters["name"]);
//$desc = GtInput_SecureForArticle($parameters["desc"]);

$accountSn = GtAccount_GetSn();
$accountType = GtAccount_GetType($accountSn);
$og_image=$_GET["og_image"];
$website=$_GET["website"];
$og_title=GtInput_Secure($_GET["og_title"]);
$og_description=GtInput_SecureForArticle($_GET["og_description"]);
$og_site_name=GtInput_Secure($_GET["og_site_name"]);
$userCont=GtInput_SecureForArticle($_GET["userCont"]);

$timeSec = GtTime_GetGmtTimeSec();
$sqlForum = "INSERT INTO forum SET dirSn = '$sn', website='$website', subject='$og_site_name',  userCont='$userCont', imageUrl='$og_image', type = '$GT_DIR_TYPE_ARTICLE', name = '$og_title', description = '$og_description', status = '1', createAccountSn = '$accountSn', createTimeSec = '$timeSec', lang = '$lang'";
$resultForum = mysql_query($sqlForum, $dbLink);


//$og_image=$_GET["og_image"];
$json_e = json_encode($sqlForum);
echo $json_e;
//

//success
//echo 1;
?>
