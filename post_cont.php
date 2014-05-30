<?php
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/global.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET") {
	$parameters = $_GET;
} else if($requestMethod == "POST") {
	$parameters = $_POST;
}

$sn = (int)GtInput_Secure($parameters["dirsn"]);
if($sn == NULL) {
  $sn = 1;
}
//$name = GtInput_Secure($parameters["name"]);
//$desc = GtInput_SecureForArticle($parameters["desc"]);

$accountSn = GtAccount_GetSn();
$accountType = GtAccount_GetType($accountSn);

$og_image = GtInput_Secure($parameters["og_image"]);
$website = GtInput_Secure($parameters["website"]);
$og_title=GtInput_Secure($parameters["og_title"]);
$og_description=GtInput_SecureForArticle($parameters["og_description"]);
$og_site_name=GtInput_Secure($parameters["og_site_name"]);
$userCont=GtInput_SecureForArticle($parameters["userCont"]);

if($og_title=="none")
  $og_title = substr($userCont, 0, 20);
if(strlen($og_title)>20)
  $og_title = $og_title."...";

$timeSec = GtTime_GetGmtTimeSec();
$sqlForum = "INSERT INTO forum SET dirSn = '$sn', website='$website', subject='$og_site_name', userCont='$userCont', imageUrl='$og_image', type = '$GT_DIR_TYPE_ARTICLE', name = '$og_title', description = '$og_description', status = '1', createAccountSn = '$accountSn', createTimeSec = '$timeSec', lang = '$lang'";
$resultForum = mysql_query($sqlForum, $dbLink);


//$og_image=$_GET["og_image"];
//$json_e = json_encode("og_image = $og_image, website = $website, og_title = $og_title, og_description = $og_description, og_site_name = $og_site_name, userCont = $userCont");
//echo $json_e;
//

//success
//echo 1;
?>
