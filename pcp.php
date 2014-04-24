<?php
function pcp($forumSn, $forumName, $accountSn, $lang, $likeButton ){
//$forumSn=6;
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
