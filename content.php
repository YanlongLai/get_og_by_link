<?php
$image_count=0;
//include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/global.php");
function userContent($displayname, $userCont, $imageUrl, $forumName, $desc, $subject, $accountPic, $website, $forumSn, $createAccountSn){
  global $image_count;
?>
  <div id=forum_<?php echo $forumSn;?> onmousemove='ShowDeleteForum(<?php echo $forumSn;?>,<?php echo $createAccountSn;?>)' onmouseout='HideDeleteForum(<?php echo $forumSn;?>)' class='wrap' style="margin: 10px 10px 0 20px; background-color:#FFF; width: 548px; padding: 20px 20px; border-bottom: 0; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;
border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;
border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5; min-height: 110px;">
<div class=account_image style="width: 114px; float: left; height: 114px; text-align: left; font-size: 15px; font-weight: bold;">
<img style="width: 114px;height: 114px;" id=account_img src="/api/file/download_photo.php?sn=<?php echo $accountPic;?>">
</div>
<div class='article' style="margin-bottom: 10px; width: 400px; height: 112px; text-align: left; background-color: #fff; float: left;padding: 0px 20px 0px 12px;border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5; font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;line-height: 16px;font-size: 12px;color: #141823;">
<div class=account style="font-weight: bold; line-height: 25px;"><?php echo $displayname;?>:
<a href="javascript:Delete_Forum(<?php echo $forumSn;?>)" id='forumDeleteBt_<?php echo $forumSn;?>' style="display:none;"><img style="float: right;" src="/image/close.png"></a></div>
<?php 
  $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
  if(preg_match($reg_exUrl, $userCont, $url)) {
    // make the urls hyper links
    echo preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="_blank">'.$url[0].'</a>', $userCont);

  } else {
    $reg_exUrl = "/(^|[^\/])([a-zA-Z0-9\-\_]+\.[\S]+(\b|$))/";
    // if no urls in the text just return the text
    if(preg_match($reg_exUrl, $userCont, $url)){
    echo preg_replace($reg_exUrl, '<a href="http://'.$url[0].'" rel="_blank">'.$url[0].'</a>', $userCont);
    }
    else
    echo $userCont;

  }
?>
</div>
<a style="text-decoration:none;" target="_blank" href="<?php echo $website;?>">
<?php
  if($imageUrl!=NULL){
  $parts = basename($imageUrl);
  if(file("thumb/".$parts)){
  echo '<div class="top" style=" background-color: #FFF;"><img id="img_'.$image_count.'" width="548px" src="thumb/'.$parts.'"></div>';
  //echo '<script type="text/javascript">$("#img_'.$image_count.'").attr("src","'.$imageUrl.'");</script>';
  }
  else{
  echo '<div class="top" style=" background-color: #FFF;"><img id="img_'.$image_count.'" width="548px" src="'.$imageUrl.'"></div>';
  //echo '<script type="text/javascript">$("#img_'.$image_count.'").attr("src","'.$imageUrl.'");</script>';
  }
  $image_count++;
}
?>
<div class='bottom' style="background-color: #FFF; ">
<div class="title" style="font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;font-size: 18px;font-weight: 500;line-height: 22px;margin-bottom: 4px;max-height: 44px;overflow: hidden;word-wrap: break-word;">
<?php echo $forumName;?>
</div>
<div class="descriptipn" style=" font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;line-height: 16px;font-size: 12px;color: #141823; margin-bottom: 5px;">
<?php echo $desc;?>
</div>
<div class="site_name" style="color: #adb2bb;font-size: 12px;">
<?php echo $subject;?>
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
