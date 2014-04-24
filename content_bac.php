<?php
function userContent(){
?>
<div class='wrap' style="margin: 10px 10px 0 20px; background-color:#FFF; width: 548px; padding: 20px 20px; border-bottom: 0; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;
border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;
border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;">
<div class=account_image style="width: 114px; float: left; height: 114px; text-align: left; font-size: 15px; font-weight: bold;">
<img style="width: 114px;height: 114px;" id=account_img src="http://tw-leaderg.leadergstaging.com/image/LEADERG-logo.jpg">
</div>
<div class='article' style="margin-bottom: 10px; width: 400px; height: 102px; text-align: left; font-size: 15px; background-color: #fff; float: left;padding: 10px 20px 0 12px;border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;">
<div class=account>Yanlong:</div>
【悲慘世界在泰國 7歲童打職業泰拳】
http://goo.gl/1I8e4w
</div>
<div class='top' style=" background-color: #FFF;"><img width="548px" src="
http://img.chinatimes.com/newsphoto/2014-04-24/656/20140424002943.jpg
"></div>
<div class='bottom' style="background-color: #FFF; ">
<div class="descriptipn">
據英國《每日郵報》4月22日報導，英國第四頻道即將播出名為「無人報案的世界」紀錄片，曝光泰國兒童冒著腦損傷甚至死亡的危險參加職業拳賽的內幕。這些孩子為了緩解家庭貧困、為了錢參加比賽，最小的年僅7歲。
</div>
<hr>
<div class="site_name">
中時電子報
</div>
</div>
</div>
<?php
}
?>

<?php
function pcp($forumSn, $forumName, $accountSn, $lang, $likeButton ){
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
<span id="like_count_<?php echo $forumSn;?>" class="like_count" style="display: inline;">・<span class="whoLike"><a class="wholikecbox" id="whoLike_<?php echo $forumSn;?>" href="/comment/forum/get_like_account?sn=6" alt="" title="Yanlong"><img src="/image/Fb_like_button.png" width="20" height="18"> 1</a></span></span><!--like_count-->・
<span class="time_cont">2014-04-11 23:54:38</span></div>
<?php
}
?>
