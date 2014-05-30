<?php
$image_count=0;
//include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/global.php");
function formatUrlsInText($text){
  //$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
  $reg_exUrl = "(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)";
  if(preg_match_all($reg_exUrl, $text, $matches)) {
    preg_match_all($reg_exUrl, $text, $matches);
    $usedPatterns = array();
    foreach($matches[0] as $pattern){
      if(!array_key_exists($pattern, $usedPatterns)){
        $usedPatterns[$pattern]=true;
        //$text = str_replace($pattern, "<a class=userContent href='".$pattern."' target='_blank'>".$pattern."</a>", $text);
        $text = eregi_replace($pattern, "<a class=userContent href='".$pattern."' target='_blank'>".$pattern."</a>", $text);
      }
    }
    echo nl2br($text);
    //return $text;
  }
  else{
    $reg_exUrl = "/(^|[^\/])([a-zA-Z0-9\-\_]+\.[\S]+(\b|$))/";
    preg_match_all($reg_exUrl, $text, $matches);
    $usedPatterns = array();
    foreach($matches[0] as $pattern){
      if(!array_key_exists($pattern, $usedPatterns)){
        $usedPatterns[$pattern]=true;
        $text = str_replace($pattern, "<a class=userContent href='http:\/\/".$pattern."' target=_blank>".$pattern."</a>", $text);
      }
    }
    echo nl2br($text);
    //return $text;
  }
}
//
function userContent($displayname, $userCont, $imageUrl, $forumName, $desc, $subject, $accountPic, $website, $forumSn, $createAccountSn){
  global $image_count;
  //if()
  //$pos = strpos($userCont, PHP_EOL, 2);
  $enter = count( explode(PHP_EOL, $userCont) );
  $enter_limit = 1;
  if($enter > 3){
    $usrCont_a = explode(PHP_EOL,$userCont);
    foreach($usrCont_a as $key){
      if($enter_limit<=3)
        $usrCont_limit = $usrCont_limit.$key.PHP_EOL;
        $enter_limit++;
    }
    $userCont = $usrCont_limit;
  }
  if(strlen($userCont) > 191 || $enter > 3)
    $userCont = substr($userCont,0,191)."...";
  else
    $userCont = $userCont." ";
?>
  <div id=forum_<?php echo $forumSn;?> onmousemove='ShowDeleteForum(<?php echo $forumSn;?>,<?php echo $createAccountSn;?>)' onmouseout='HideDeleteForum(<?php echo $forumSn;?>)' class='wrap' style="margin: 10px 10px 0 20px; background-color:#FFF; width: 598px; padding: 20px 20px; border-bottom: 0; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;
border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;
border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5; min-height: 110px;">
<div class=account_image style="width: 114px; float: left; height: 114px; text-align: left; font-size: 15px; font-weight: bold;">
<img style="width: 114px;height: 114px;" id=account_img src="/api/file/download_photo.php?sn=<?php echo $accountPic;?>">
</div>
<div class="delete_forum"><a href="javascript:Delete_Forum(<?php echo $forumSn;?>)" id='forumDeleteBt_<?php echo $forumSn;?>' style="position: absolute; margin-left: 460px;display: none;"><img style="float: right;" src="/image/close.png"></a></div>
<div class="account" style="/* font-weight: bold; */ color: #444; line-height: 20px;position: absolute;/* margin-top: 95px; *//* text-align: center; */margin-left: 128px;margin-top: 6px;font-size: 14px;"><a href="/account/info?sn=<?php echo $createAccountSn;?>" target="_blank"><?php echo $displayname;?></a>:</div>
<div class="article" style="margin-bottom: 10px; width: 450px; height: 83px; text-align: left; background-color: #fff; float: left;padding: 30px 20px 0px 12px;border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5; font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;line-height: 16px;font-size: 12px;color: #141823;">
<?php
  //echo nl2br(formatUrlsInText($userCont));
  echo nl2br(makeClickableLinks($userCont));
  /*
  $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/g";
  if(preg_match_all($reg_exUrl, $userCont, $url)) {
    // make the urls hyper links
    //if(strlen($userCont) > 56)
      //$userCont_a = preg_replace($reg_exUrl, '<a class=userContent href="'.$url[0].'" target="_blank">'.substr($url[0],0,56).'...</a>', $userCont);
    //else
      $userCont_a = preg_replace($reg_exUrl, '<a class=userContent href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $userCont);
    echo nl2br($userCont_a);

  } else {
    $reg_exUrl = "/(^|[^\/])([a-zA-Z0-9\-\_]+\.[\S]+(\b|$))/";
    // if no urls in the text just return the text
    if(preg_match($reg_exUrl, $userCont, $url)){
    //if(strlen($userCont) > 56)
      //$userCont_a =  preg_replace($reg_exUrl, '<a class=userContent href="http://'.$url[0].'" target="_blank">'.substr($url[0],0,56).'...</a>', $userCont);
    //else
      $userCont_a =  preg_replace($reg_exUrl, '<a class=userContent href="http://'.$url[0].'" target="_blank">'.$url[0].'</a>', $userCont);
      echo nl2br($userCont_a);
    }
    else
    echo nl2br($userCont);

  }
   */
?>
</div>
<div class="more" style="/* font-weight: bold; */ color: #444; line-height: 20px;position: absolute;/* margin-top: 95px; *//* text-align: center; */margin-left: 520px;margin-top: 88px;font-size: 12px;"><a href="/forum/thread?sn=<?php echo $forumSn;?>" target="_blank">See More</a></div>
<a style="text-decoration:none;" target="_blank" href="<?php echo urldecode($website);?>">
<?php
  if($imageUrl!=NULL && $imageUrl!="none"){
  $parts = basename($imageUrl);
  if(file("thumb/".$parts)){
  echo '<div class="top" style=" background-color: #FFF;"><img id="img_'.$image_count.'" width="598px" src="thumb/'.$parts.'"></div>';
  }
  else{
  echo '<div class="top" style=" background-color: #FFF;"><img id="img_'.$image_count.'" width="598px" src="'.$imageUrl.'"></div>';
  }
  $image_count++;
}
?>
<div class='bottom' style="background-color: #FFF; ">
<div class="title" style="font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;font-size: 18px;font-weight: 500;line-height: 22px;margin-bottom: 4px;max-height: 44px;overflow: hidden;word-wrap: break-word;">
<?php if($forumName!=NULL && $forumName!="none") echo $forumName;?>
</div>
<div class="descriptipn" style=" font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;line-height: 16px;font-size: 12px;color: #141823; margin-bottom: 5px;">
<?php if($desc!=NULL && $desc!="none") echo $desc;?>
</div>
<div class="site_name" style="color: #adb2bb;font-size: 12px;">
<?php if($subject!=NULL && $subject!="none")echo $subject;?>
</div>
</div></a>
</div>
<?php
}
?>

<?php
function pcp($forumSn, $forumName, $accountSn, $lang, $likeButton, $dirDate, $accountCount, $numForumLikeAccount ){
?>
<div class="contentArea_pcp">
<span class="like_bt"><a id="likeButton_<?php echo $forumSn;?>" href="javascript:I_Like_This(<?php echo $forumSn.", ".$accountSn.", ".$lang;?>)"><?php echo $likeButton;?></a></span><!--like_bt-->
・<span class="share_cont"><a href="#" onclick="Share_Bt(<?php echo $forumSn;?>);return false;"><?php echo t("Share");?></a>
<span id="share_index_bt" class="share_index_bt_<?php echo $forumSn;?>" onmousemove="ShowShareBt(<?php echo $forumSn;?>)" onmouseout="HideShareBt(<?php echo $forumSn;?>)" style="display: none;">
<span class="share_fb">
<a target="_blank" href="http://www.facebook.com/share.php?u=http://tw-leaderg.leadergstaging.com/forum/thread?sn=<?php echo $forumSn;?>&amp;t=<?php echo $forumName;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<img src="/image/facebook_share_bt.png" alt="Share on Facebook"></a></span>
<span class="share_twitter">
<a href="http://twitter.com/share?text=<?php echo str_replace("#","%23",$forumName);?>&amp;url=http://tw-leaderg.leadergstaging.com/forum/thread?sn=<?php echo $forumSn;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<img src="/image/twitter_share_bt.png" alt="Share on Twitter"></a></span>
<span class="share_google">
<a href="https://plus.google.com/share?url=http://tw-leaderg.leadergstaging.com/forum/thread?sn=<?php echo $forumSn;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<img src="/image/google_share_bt.png" alt="Share on Google+"></a></span>
<span class="share_weibo">
<a href="http://v.t.sina.com.cn/share/share.php?title=<?php echo str_replace("#","%23",$forumName);?>&amp;url=http://tw-leaderg.leadergstaging.com/forum/thread?sn=<?php echo $forumSn;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<img src="/image/weibo_share_bt.png" alt="Share on Weibo"></a></span>
<span class="share_email">
<a target="_blank" href="mailto:?subject=<?php echo $forumName;?>&amp;body=http://tw-leaderg.leadergstaging.com/forum/thread?sn=<?php echo $forumSn;?>">
<img src="/image/email_share_bt.png" alt="Share on Email"></a></span>
</span><!--share_index_bt-->
</span><!--share_cont-->
<span id="like_count_<?php echo $forumSn;?>" class="like_count" <?php if ($numForumLikeAccount <= 0) echo "style=\"display:none;\"";?>>・
<span class="whoLike"><a class="wholikecbox" id="whoLike_<?php echo $forumSn;?>" href="/comment/forum/get_like_account?sn=<?php echo $forumSn;?>" alt="<?php echo $accountCount?>" title="<?php echo $accountCount?>">
<img src="/image/Fb_like_button.png" width="20" height="18"> <?php echo $numForumLikeAccount;?></a></span></span><!--like_count-->・
<span class="time_cont"><?php echo $dirDate;?></span></div>
<?php
}
?>
