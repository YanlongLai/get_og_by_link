<?php
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/global.php");
//Get image link
$remote_source_root = @urldecode($_GET["og_image"]);
//parameter------
$accountSn = GtAccount_GetSn();
$timeSec = GtTime_GetGmtTimeSec();
//echo "account=".$accountSn.", timesec=".$timeSec."\n";

//global
global $serverUploadDir;
global $sn;
global $accountSn;
global $serverTimeZone;
global $dbLink;
//Test
//$remote_source_root = "http://tw-leaderg.leadergstaging.com/forum/thumb/8680443-3426524.jpg";
//$remote_source_root = "http://s2.imgs.cc/img/bs29zpq.jpg";
//$remote_source_root = "http://t0.thumb.ckcdn.com/22/52/2982252_f.jpg";
//$remote_source_root = "http://udn.com/NEWS/MEDIA/8682091-3427396.jpg";

if(@file($remote_source_root)){
    $image = file_get_contents($remote_source_root);
    $parts = basename($remote_source_root);
    $serverFileName = GtTime_GetGmtDateTimeMicro() . "-" . $accountSn . ".enc";
    $encType = 0;
    $encKey = hash("sha256", rand().rand().rand().rand(), true);
    $encKeySql = mysql_real_escape_string($encKey);
    $imageSrc = getimagesize($remote_source_root);
    //print_r($imageSrc);
    $imageSrcWidth = $imageSrc[0];
    $imageSrcHeight = $imageSrc[1];
    $fileNames = explode("/", $imageSrc["mime"]);
    $nameExt = $fileNames[1];
    //find forum sn by image link
    $sql = "SELECT sn FROM forum WHERE imageUrl = '$remote_source_root' ORDER BY 'createTimeSec' desc";
    $resultFile = mysql_query($sql, $dbLink);
    $rowFile = mysql_fetch_array($resultFile);
    $forumSn = $rowFile[sn];
    //echo "dblink=".$dblink;
    //echo "forumSn=".$forumSn;

    //insert new image
    //insert new image to file table
    $sql = "INSERT INTO file SET type = '4', name = '".mysql_real_escape_string($parts)."', nameExt = '$nameExt', forumSn = '$forumSn', rank = '0', createTimeSec = '$timeSec', createAccountSn = '$accountSn', encType = '$encType', encKey = '$encKeySql', encName = '$serverFileName', status = '1', width = '$imageSrcWidth', height = '$imageSrcHeight'";
    //echo $sql."\n";
    $resultFile = mysql_query($sql, $dbLink);

    
    //insert new image to uploader
    file_put_contents($serverUploadDir.'/'.$serverFileName, $image);
    //get new image sn
    $sqlFile = "SELECT sn, encName, type FROM file WHERE encName = '$serverFileName'";
    $resultFile = mysql_query($sqlFile, $dbLink);
    $rowFile = mysql_fetch_array($resultFile);
    $fileSn = $rowFile[sn];
    $imageUrl = "/api/file/download_photo.php?sn=".$fileSn;
    //update forum imageUrl
    $sql = "UPDATE forum SET imageUrl='$imageUrl' WHERE sn='$forumSn'";
    //echo $sql."\n";
    $resultFile = mysql_query($sql, $dbLink);

    $link_e=json_encode("/api/file/download_photo.php?sn=".$fileSn);
    echo $link_e;
  }
  else
    echo json_encode(-1);

    //echo json_encode("/api/file/download_photo.php?sn");
?>
