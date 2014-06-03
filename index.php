<?php
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/global.php");
include("content.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET") {
	$parameters = $_GET;
} else if($requestMethod == "POST") {
	$parameters = $_POST;
}
$sn = (int)GtInput_Secure($parameters["sn"]);
if ($sn <= 0) {
	if ($lang == $GT_LANG_EN_US) {
		$sn = 1057;
	} else if ($lang == $GT_LANG_ZH_TW) {
		$sn = 1093;
	} else if ($lang == $GT_LANG_ZH_CN) {
		$sn = 1102;
	} 
}
$page = (int)GtInput_Secure($parameters["page"]);
if($page <= 0) {
	$page = 1;	
}
$gotoUrl = "/forum/index?sn=$sn";

$accountSn = GtAccount_GetSn();
$accountType = GtAccount_GetType($accountSn);

$sql = "SELECT name, keyword, subject FROM dir WHERE sn = '$sn' AND status = '$GT_DIR_STATUS_PUBLISH'";
$result = mysql_query($sql, $dbLink);
$row = mysql_fetch_array($result);
$name = $row[name];
$keyword = $row[keyword];
$subject = $row[subject];

$pageModule = t("FORUM");
$pageTitle = t($name);
$pageKeywords = t($keyword);
$pageDescription = t($subject);
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/header.php");

include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/nav.php");
?>
<style>
textarea {
max-width: 100%;
width: 634px;
margin: 0;
-webkit-appearance: none;
-webkit-border-radius: 0;
resize: none;
}
</style>
<link rel="stylesheet" type="text/css" href="/css/colorbox/colorbox.css" />
<script type="text/javascript" src="/js/colorbox/jquery.colorbox.js"></script>
<script type="text/javascript" src="/js/events.js"></script>
<!--<script type="text/javascript" src="/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="/js/jquery.infinitescroll.js"></script>
<script type="text/javascript" src="/js/all.js"></script>-->
<script type="text/javascript">
var accountSn=<?php echo $accountSn;?>;
var og_obj = new og;
var post_cont = "<?php echo t("Post");?>";
var serverIsStaging = "<?php echo $serverIsStaging;?>";
var og_count = 0;

var match_old = "";
var match = "";
var text = "";

function findFirstLink(text) {
	text = decodeURIComponent(text);
	var gotoUrl = "<?php echo $gotoUrl;?>";
	if (accountSn <= 0) {
		GtBrowser_GotoPage(gotoUrl, accountSn, lang);
	}
	//http....
	var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
	var match = exp.exec(text);
	//No http... but a link
	if(match==null){
	var exp = /(^|[^\/])([a-zA-Z0-9\-\_]+\.[\S]+(\b|$))/ig;
	var match = exp.exec(text);
	
	if(match!=""){
		if (typeof match !== 'undefined' && Array.isArray(match)){
		match[0]=match[0].replace(/(^[\s]*)|([\s]*$)/g, "");
		match[0]="http://"+match[0];
		alert(match[0]);
		}
	}
	
	
	}
	//No link
	if(match==null){
	return "None";
	}
	return match[0];
}

function response_del(){
		$('#link_response').hide();
		og_obj = new og;
		og_count = 0;
		match_old = "";
}

function og() {
        this.image = "none";
        this.title = "none";
        this.description = "none";
		this.site_name = "none";
}
	
function og_run(flag){
		//alert(og_count);
		if(og_count==0){
			og_count = 1;
			text = $('textarea#post_article').val();
			//text = text.replace("%20","");
			//detect text's link
			match = findFirstLink(encodeURI(text.replace(/(^[\s]*)|([\s]*$)/g, ""))).replace(/%20/g,"");
			//if text has a link
			//alert(match);
			if(match!="None"){
				//alert(match);
				//alert(match_old);
				//$( "#link_response" ).hide();
				//First It's different.
				//Second different or not
				//if(match_old != match)
				//get og information
				getOgInfo(match);
				match_old = match;			
			}
			else
			og_count = 0;
		}
		if(og_count==1)
		return;
}

function whoCommentLikeBox (thisId) {
	$(thisId).colorbox({rel:thisId, transition:"none", width:"40%", height:"50%"});
}

//og_obj.image, og_title:og_obj.title, og_description: og_obj.description, og_site_name: og_obj.site_name
$(document).ready(function(){	
	
	$(".wholikecbox").click(function(){
		var thisId = this.id;
		$("#" + thisId).colorbox({rel:thisId, transition:"none", width:"40%", height:"50%"});
		$("#click").click(function(){ 
			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
	
		//comment message
	var focusElement = {};
	$("textarea").focus(function(){
	   focusElement = this;
	});
	
	//ctrl+v
	$("#post_article").on('paste', function () {
		if(accountSn>0)
		setTimeout( function() { og_run(og_count); }, 100);
		//alert (og_count);
		//
		//alert("ctrl+v");	
	});
	
	$(".article").each(function(){
		//$(this).text($(this).text().substr(0, 200)+'...');
		var $limit = 180;
		var $str = $(this).html();
		var $str_text = $(this).text();
		var $str_text_length = $str_text.length;
		var $href = $(this).find("a").attr('href');
		
		
		var hrefs = new Array();
		var hrefs_length = new Array();
		var hrefs_index = new Array();
		
		var href_temp;
		var href_l;
		var href_start;
		var href_end;
		
		var user_content_limit = "";
		var $str_text_temp = $str_text;
		
		if($href==null){
			hrefs.push("");
			hrefs_length.push(0);
			hrefs_index.push(0);
		}
		else
		$(this).find('a[href]')  // only target <a>s which have a href attribute
        .each(function() {
						
			href_temp = this.href;
			href_l = href_temp.length;
			href_start = $str_text_temp.indexOf(href_temp);
			href_end = href_start + href_l;
			
			
			//console.log("str = "+$str_text_temp+". start = "+href_start+", end = "+href_end+", len = "+href_l+"\n");
			//$str_text_temp = $str_text_temp.substr(href_end, $limit);
			/*
			if(href_start < $limit){
				user_content_limit+=$str_text.substr(0, href_start);
			}
			*/
			
            hrefs.push(href_temp);
			//alert("href_temp="+ href_temp);
			
			hrefs_length.push(href_temp.length);
			hrefs_index.push($str_text.indexOf(href_temp));
        })
		//console.log(hrefs.join('\n')+", eln = "+hrefs_length.join('\n')+", Index = "+hrefs_index.join('\n'));
		//alert(hrefs_index.join('\n'));
		
		//console.log("html:"+$str+", href:"+$href+", text:"+$str_text);
		if($href==null)
		var $href_length = 0;
		else
		var $href_length = $href.length;
		
		
		var $href_index = $str_text.indexOf($href);
		var $href_end = $href_index + $href_length;
		//alert("html:"+$str+", href:"+$href+", text:"+$str_text);
		//alert("href:"+$href+", text:"+$str_text);
		if( $href_end > $limit)
		var $hide = 1;
		else
		var $hide = 0;
		if( $href_index > $limit)
		var $hide = 2;
		
		//alert("str_len:"+$str_text_length+", href_len:"+$href_length+", href_index:"+$href_index+", href_end:"+$href_end+", limit:"+$limit+", hide:"+$hide );
		
		if($hide==1){
			var $text1 = $str_text.substr(0, $href_index);
			var $hrefcut = $str_text.substr($href_index, $limit);
			//var $strtemp = $str_text.substr(0,$limit)+" ...";
			var $strtemp = $text1+"<a href="+$href+">"+$hrefcut+"...</a>";
		}
		else{
		var counter = 0;
		for (counter=0; counter<hrefs.length; counter++){
			
  			if(hrefs_index[counter]<$limit){
				
			}
		}
		var $strtemp = $str;
		}
		if($hide==2){
			var $strtemp = $str_text.substr(0, $limit)+"...";
		}
		
		//$str = $strtemp;
		//$(this).html($strtemp);
		$(this).find("a").css("word-break","break-all");
		
		//if($(this).text().length>150)
		//$(this).html($(this).text().substr(0, 170)+' Len:'+$(this).text().length);
		//$(this).html($(this).html()+' Len:'+$(this).text().length);
		
		
		
	});
	
	$(document).keydown(function(e) {
		/*
		if (e.which == 86) {
			alert("v");
		}*/
		var accountSn = "<?php echo $accountSn;?>";
		var lang = "<?php echo $lang;?>";
		var commentId = focusElement.id;
		
		if(commentId != "post_article"){
			if(typeof commentId !== 'undefined'){
			var commentSn = commentId.split("_");
			var message = document.getElementById(commentId).value;
			}
		}
		var postMsg = $("#post_article").val();
		
		//space and enter
		if (commentId == "post_article") {
			if(e.which == 32){
			if(accountSn>0)
			og_run(og_count);
			//alert("space");
			}
			
			if(e.which == 13){
			if(accountSn>0)
			og_run(og_count);
					//alert("enter");	
					//$("#post_article").val(postMsg+'\n');
			}
		}
		
		
		
		if (e.which == 13) {
			
			
			
			if (accountSn <= 0) {
				if (lang == 0) {
					alert("Please login!");
				} else if (lang == 1) {
					alert("請登入!");
				} else if (lang == 2) {
					alert("请登入!");
				}
				document.getElementById(commentId).value = null;
				return false;
			} else {
				//post_cont
				/*
				if ($.trim(postMsg) != "") {
					var postButton = $("input#post_cont").val();
					if(postButton!="Loading..."){
					
					  var post_cont_link = "/forum/post_cont.php";
					  var textarea= $('textarea#post_article').val();
					  var userLink= $("a.userLink").attr("href");
					  
					  $.ajax({
						url: post_cont_link,
						type: "GET",
						data: {og_image:og_obj.image, og_title:og_obj.title, og_description: og_obj.description, og_site_name: og_obj.site_name, dirsn: sn, userCont: textarea, website: userLink},
						cache:false,
						dataType: 'json'
						}).done(function(data){
							
							og_post = data;
							if (lang == 0) {
								setTimeout(function(){
								window.location.href = 'http://leaderg.leadergstaging.com/forum/index?sn=1057';
								},100);
							} else if (lang == 1) {
								setTimeout(function(){
								window.location.href = 'http://tw-leaderg.leadergstaging.com/forum/index?sn=1093';
								},100);
							} else if (lang == 2) {
								setTimeout(function(){
								window.location.href = 'http://cn-leaderg.leadergstaging.com/forum/index?sn=1102';
								},100);
							}
							
						})
						.fail(function() {
							
						});
						
					
					}
					
				
				}*/
				
				
				
				if ($.trim(message) != "" && commentId != "post_article") {
					if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					} else {// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange=function() {
						if (xmlhttp.readyState==4 && xmlhttp.status==200) {
							if(commentId != "post_article")
							document.getElementById(commentId).value = "";
							Reply(commentSn[2]);
						}
					}
					xmlhttp.open("GET","/comment/forum/comment?sn="+commentSn[2]+"&message="+message, true);
					xmlhttp.send();
				}
			}
		}
	});
	//comment message
	
	
	
	var sn="<?php echo $sn;?>";
	
	//textarea enter text
	
	/*
	
	$( 'textarea#post_article' ).keyup(function( event ) {
		//get textarea value
		text = $('textarea#post_article').val();
		//detect text's link
		match=findFirstLink(text);
		//if text has a link
		if(match!="None"){
			//alert(match_old);
			//$( "#link_response" ).hide();
			//First It's different.
			//Second different or not
			if(match_old!=match)
			//get og information
			getOgInfo(match);
			match_old=match;
		}
	}).keydown(function( event ) {
	  if ( event.which == 13 ) {
		event.preventDefault();
	  }
	});
	*/
	
	//setInterval("startRequest()",1000); 
	$('input#post_cont').click(function() {
		var serverUrl = "<?php echo $serverUrl;?>";
		//$('input#post_cont').one( "click", function() {
		//alert(og_obj.image);
		//post_cont.php
	
		var post_cont_link = "/forum/post_cont.php";
		var textarea= $('textarea#post_article').val();
		var userLink= decodeURI($("a.userLink").attr("href"));
		//var userLink = $("a.userLink").attr("href", decodeURI(match));
		//alert(og_obj.image);
		/*
		if (typeof(og_obj) == "undefined" && og_obj.image!=null)
		{
		var og_obj=[];
		og_obj.image = "";
		og_obj.title = "none";
		og_obj.description = "";
		og_obj.site_name = "none";
		alert("位定義");
		}
	*/
		if (accountSn <= 0) {
			if (lang == 0) {
				alert("Please login!");
			} else if (lang == 1) {
				alert("請登入!");
			} else if (lang == 2) {
				alert("请登入!");
			}
			return;
		}
	
		var postMsg = $("#post_article").val();
	
		if ($.trim(postMsg) != "") {
			$("#block").show();
			$.ajax({
				url: post_cont_link,
				type: "POST",
				data: {og_image:og_obj.image, og_title:og_obj.title, og_description: og_obj.description, og_site_name: og_obj.site_name, dirsn: sn, userCont: textarea, website: userLink},
				cache:false,
				dataType: 'text'
			}).done(function(data){
			//data_fix=data.replace(/\bNaN\b/g, "null")
			
			
			uploaderImg(og_obj.image);
		
			//20140502
			//$("input#post_cont").attr("disabled","disabled");
			og_post = data;
			//window.location.href = '';
		
			setTimeout(function(){
				if (lang == 0) {
					GtBrowser_GotoPage('/forum/index?sn=1057');
				} else if (lang == 1) {
					GtBrowser_GotoPage('/forum/index?sn=1093');
				} else if (lang == 2) {
					GtBrowser_GotoPage('/forum/index?sn=1102');
				}
			},100);
			//location.reload();
			
			//alert(og_post+" get!!");
			/*
			//replace
			$("#og_image").attr("src",og_obj.image);
			$('#link_title').text(og_obj.title);
			//alert(og_obj.description.length);
			$('#link_description').text(og_obj.description.substr(0,120)+"...");
			
			$('#link_site').text(og_obj.site_name);
			$( "#link_load" ).hide();
			if(og_obj.image!="none" && og_obj.title!="none"){
			$('#link_response').show();
			$("a.userLink").attr("href", match);
			}
			*/
		
			//else
			//$('#link_response').hide();
			//alert(JSON.stringify(og_obj, null, 4));
			//alert(og_obj.image);
			}).fail(function() {
				//$( "#link_load" ).hide();
			});
		}
	});
	/*
	$('input#post_bt').click(function() {
	$( "#link_response" ).hide();
	var text = $('textarea#post_article').val();
	var match=findFirstLink(text);
	//Get a link
	if(match!="None"){
	getOgInfo(match);
	}
	//alert(match);
	//send to server and process response
	});*/
});

function uploaderImg(image){
	$("input#post_cont").attr("disabled","disabled");
	var jsonUrl = "/forum/uploader?og_image="+ image;
	var jsonUrl_e = encodeURI(jsonUrl);
	//alert(jsonUrl);
	$.ajax({
	url: jsonUrl_e,
	type: "GET",
	cache:false,
	async:false,
	dataType: 'json'
	}).done(function(data){
		og_obj.image = data;
		//alert(JSON.stringify(data, null, 4));
	})
		.fail(function(data) {
		//alert(JSON.stringify(data, null, 4));
		//alert("fail");
    	//$("#og_image").attr("src",og_obj.image);
  	});
}

function getOgInfo(match) {
	//alert(match);
	$( "#link_load" ).show();
	$("input#post_cont").attr("disabled","disabled");
	$("input#post_cont").val("Loading...");
	var jsonUrl = "/forum/get_content?link="+ match;
	var jsonUrl_e = encodeURI(jsonUrl);
	$.ajax({
	url: jsonUrl_e,
	type: "GET",
	cache:false,
	dataType: 'json'
	}).done(function(data){
		//data_fix=data.replace(/\bNaN\b/g, "null")
		//alert(JSON.stringify(data, null, 4));
		og_obj = data;
		//replace
		//alert(og_obj.image);
		$("input#post_cont").val(post_cont);
		if(og_obj.image!="none")
		$("#og_image").attr("src",og_obj.image);
		else
		$("#og_image").attr("src","");
		
		$('#link_title').text(og_obj.title);
		//alert(og_obj.description.length);
		$('#link_description').text(og_obj.description.substr(0,120)+"...");
		/*
		if(match!=null){
			var link_site=match;
			link_site.replace(/http:\/\//,"");
			link_site.replace(/https:\/\//,"");
			link_site.replace(/ftp:\/\//,"");
		}*/
		$('#link_site').text(og_obj.site_name);
		$( "#link_load" ).hide();
		$("input#post_cont").removeAttr("disabled");
		if(og_obj.image!="none" || og_obj.title!="none" || og_obj.description!="none" || og_obj.site_name!="none"){
		$og_count = 1;
		$('#link_response').show();
		//$("a.userLink").attr("href", decodeURI(match));
		$("a.userLink").attr("href", decodeURI(match));
		}
		else{
		$og_count = 0;
		$('#link_response').hide();
		}
		//alert(JSON.stringify(og_obj, null, 4));
		//alert(og_obj.image);
	})
	.fail(function() {
    	$( "#link_load" ).hide();
		$("input#post_cont").removeAttr("disabled");
  	});
}




function ShowDeleteForum(forumSn, commentAccountSn) {
	var accountSn = "<?php echo $accountSn;?>";
	var accountType = "<?php echo $accountType;?>";
	if (accountSn == commentAccountSn || accountType == 4) {
		$("#forumDeleteBt_"+forumSn).css({'display':'inline'});
	}
}
function HideDeleteForum(forumSn) {
	$("#forumDeleteBt_"+forumSn).css({'display':'none'});
}

function ShowDeleteBt(cfSn, commentAccountSn) {
	var accountSn = "<?php echo $accountSn;?>";
	var accountType = "<?php echo $accountType;?>";
	if (accountSn == commentAccountSn || accountType == 4) {
		$("#commentDeleteBt_"+cfSn).css({'display':'inline'});
	}
}
function HideDeleteBt(cfSn) {
	$("#commentDeleteBt_"+cfSn).css({'display':'none'});
}

function Delete_Forum(forumSn) {
	var lang = "<?php echo $lang;?>";
	if (lang == 0) {
		var r = confirm("Are you sure you want to delete this topic?");
	} else if (lang == 1) {
		var r = confirm("你確定要刪除這個主題嗎？");
	} else if (lang == 2) {
		var r = confirm("你确定要删除这个主题吗？");
	}
	if (r == true) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				location.reload();
			}
		}
		xmlhttp.open("GET","/comment/forum/delete_forum?forumSn="+forumSn, true);
		xmlhttp.send();
	}
}

function Delete_Comment(cfSn, forumSn) {
	var lang = "<?php echo $lang;?>";
	if (lang == 0) {
		var r = confirm("Are you sure you want to delete this comment?");
	} else if (lang == 1) {
		var r = confirm("你確定要刪除這個留言嗎？");
	} else if (lang == 2) {
		var r = confirm("你确定要删除这个评论吗？");
	}
	if (r == true) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				Reply(forumSn);
			}
		}
		xmlhttp.open("GET","/comment/forum/delete_comment?sn="+cfSn, true);
		xmlhttp.send();
	}
}

function Reply(sn) {
	var jsonUrl = "/comment/forum/reply?sn="+ sn;
	$.ajax({
	url: jsonUrl,
	type: "GET",
	cache:false,
	dataType: 'html'
	}).done(function(data){
		document.getElementById("comment_"+sn).innerHTML = data;	
	});
}

//like bt
function I_Like_This(sn, accountSn, lang) {
	var gotoUrl = "<?php echo $gotoUrl;?>";
	if (accountSn <= 0) {
		GtBrowser_GotoPage(gotoUrl, accountSn, lang);
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			Get_Count(sn);
		}
	}
	xmlhttp.open("GET","/comment/forum/like?sn=" + sn, true);
	xmlhttp.send();
}

function I_Like_This_Comment(cfSn, likeCommentAccountSn, lang) {
	var accountSn = "<?php echo $accountSn;?>";
	var gotoUrl = "<?php echo $gotoUrl;?>";
	if (accountSn <= 0) {
		GtBrowser_GotoPage(gotoUrl, accountSn, lang);
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			Get_Comment_Count(cfSn, likeCommentAccountSn);
		}
	}
	xmlhttp.open("GET","/comment/dir/like_comment?sn=" + cfSn + "&accountSn=" + likeCommentAccountSn, true);
	xmlhttp.send();
}

//get like count
function Get_Count(sn) {
	var url = "/comment/forum/like_count?sn="+ sn;
	//alert(url);
	jQuery.ajaxSetup({ cache: false });
	$.get(url, function(data) {
		var json = data.toString();
		//alert(json);
		var obj = jQuery.parseJSON(json);
		var status = obj.status;
		var message = obj.message;
		var likeCount = obj.likeCount;
		var likeBt = obj.likeBt;
		var accountNames = obj.accountNames;
		
		document.getElementById("whoLike_"+ sn).innerHTML = "<img src=\"/image/Fb_like_button.png\" width=\"20\" height=\"18\"> " + likeCount;
		document.getElementById("likeButton_"+ sn).innerHTML = likeBt;
		$("#whoLike_"+ sn).attr("title", accountNames);
		if (likeCount > 0) {
			$("#like_count_"+sn).css({'display':'inline'});
		} else {
			$("#like_count_"+sn).css({'display':'none'});
		}
	});
}

function Get_Comment_Count(cfSn, likeCommentAccountSn) {
	var url = "/comment/dir/like_comment_count?sn="+ cfSn + "&accountSn=" + likeCommentAccountSn;
	//alert(url);
	jQuery.ajaxSetup({ cache: false });
	$.get(url, function(data) {
		var json = data.toString();
		//alert(json);
		var obj = jQuery.parseJSON(json);
		var status = obj.status;
		var message = obj.message;
		var likeCount = obj.likeCount;
		var likeBt = obj.likeBt;
		var accountNames = obj.accountNames;
		
		document.getElementById("whoCommentLike_"+ cfSn).innerHTML = " " + likeCount;
		document.getElementById("likeCommentBt_"+ cfSn).innerHTML = likeBt;	
		$("#whoCommentLike_"+ cfSn).attr("title", accountNames);	
		if (likeCount > 0) {
			$("#like_comment_count_"+cfSn).css({'display':'inline'});
		} else {
			$("#like_comment_count_"+cfSn).css({'display':'none'});
		}
	});
}


//get like count

function Share_Bt(sn) {
	$(".share_index_bt_"+sn).fadeToggle();
}
function ShowShareBt(sn) {
	$(".share_index_bt_"+sn).css({'display':'inline'});
}
function HideShareBt(sn) {
	$(".share_index_bt_"+sn).css({'display':'none'});
}
</script>
<div id="block" style="width: 100%; height: 100%;position: fixed; top: 0; left: 0;background: rgba(0,0,0,0.4);z-index: 99999;font-size: 68px;text-align: center;vertical-align: center;padding-top: 25%;color: whitesmoke; display:none;">Posting...</div>
<div id="article">
<?php

?>
<div id="leftCol">
<?php
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/left_menu.php");//任何一頁左邊選單內容
?>
</div><!--leftCol-->

<div id="controlCol">
    <div id="rightCol" role="complementary">
    <?php
    include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/right_menu.php");//任何一頁右邊選單內容
    ?>
    </div><!--rightCol-->
    
    <div id="contentArea_dir">
    <?php
	echo "<div id=\"contentArea_dir_tree\">";
	include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/breadbrumbs.php");
    echo "</div><!--contentArea_dir_tree-->";
			
	echo "<div id=\"create_forum\">";
    //echo "<input type=\"button\" value=\"".t("Post")."\" onClick=\"GtBrowser_GotoPage('create?sn=$sn', '$accountSn', '$lang');\" class=\"joinBt\">";
	?>
	<!--<input id=post_bt value="Post" type="button" class="joinBt">-->
    
    <div class="innerWrap">
    	<textarea id=post_article placeholder="What's on your mind?" cols="30" rows="5"></textarea>
        <div style="padding: 10px 20px 0 0; width:640px;overflow:auto;"><span id=link_load style="width:530px; display:none; float:left;"><img src=./loader_anim.gif></span><span style="float:right; width:110px;"><input id=post_cont value="<?php echo t("Post");?>" type="button" class="joinBt"></span></div>
        
        <div id=link_response style="display:none; width:640px;">
        <div id=link_image style="width: 154px; float: left; height: 154px; text-align: center; line-height: 250px; font-size: 15px;margin-top:10px; color: #ffffff; font-weight: bold; background-color: #000000;"><img style="width: 154px;height: 154px;" id=og_image src=""></div>
        
        <div id=link_content style="width: 452px; height: 142px; text-align: left; font-size: 15px; background-color: #fff; float: right;padding: 10px 20px 0 12px;margin-top:10px;border: 1px solid;border-top-color: rgb(229, 230, 233);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(223, 224, 228);border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(208, 209, 213);border-bottom-style: solid;border-bottom-width: 1px;border-left-color: rgb(223, 224, 228);border-left-style: solid;border-left-width: 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;">
        
		<a class="userLink" target="_blank">
        <div id=link_title style="width: 452px; font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;font-size: 18px;font-weight: 500;line-height: 22px;margin-bottom: 4px;max-height: 44px;overflow: hidden;word-wrap: break-word;">
Title</div></a>
		<div><a href="javascript:response_del()"><img style="float: right;position: relative;top: -30px;left: 10px;" src="/image/close.png"></a></div>
		 
        <div id=link_description style="width: 452px; height:80px; font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;line-height: 16px;font-size: 12px;color: #141823;">
Description</div>
		<a class="userLink" target="_blank">
		<div id=link_site style="color: #adb2bb;font-size: 12px;">
Link</div></a>
</div>
		
        </div>
    </div>
    
	<?php
    echo "</div><!--create_forum-->";
	?>
    
    <div id="contentArea" role="main">
    <?php	
	$itemPerPage = 10;
    $from = ($page -1) * $itemPerPage;
    $count = $itemPerPage;
    
    $sql = "SELECT sn, name, subject, website, imageUrl, description, createTimeSec, editTimeSec, createAccountSn, userCont FROM forum WHERE dirSn = '$sn' AND status = '$GT_DIR_STATUS_PUBLISH' AND lang = '$lang' ORDER BY createTimeSec DESC LIMIT $from, $count";
    $result = mysql_query($sql, $dbLink);
	//$num = mysql_num_rows($result);
    while ($row = mysql_fetch_array($result)) {
        $forumSn = $row[sn];
		//account displayname
		$createAccountSn = $row[createAccountSn];
		$displayname = GtAccount_GetNameDisplay($createAccountSn);
		//GtAccount_GetPic
		$accountPic = GtAccount_GetPic($createAccountSn);
		//userCont
		$userCont = $row[userCont];
		//website link
		$website = $row[website];
		//meta title
		$forumName = $row[name];
		//meta site-name
        $subject = $row[subject];
		//meta image
		$imageUrl = $row[imageUrl];
		//meta description
        $desc = $row[description];
		//create
		$createTimeSec = $row[createTimeSec];
		$editTimeSec = $row[editTimeSec];
		if ($editTimeSec != 0) {
			$dirDate = GtTime_GetDateTime2(GtTime_ConvertToBrowserTimeSec($editTimeSec));
		} else {
			$dirDate = GtTime_GetDateTime2(GtTime_ConvertToBrowserTimeSec($createTimeSec));
		}
    
        echo "<div id=\"contentArea_cont\">";
		
		 /*
        echo "<a href=\"/forum/thread?sn=$forumSn\">";
        echo "<div class=\"contentArea_sub\">";
        echo "<span class=\"contentArea_sub\">";
        echo "$forumName";
        echo "</span>";
        echo "</div><!--contentArea_sub-->";
        echo "</a>";
        
        echo "<div class=\"contentArea_desc\">";
        echo cut_word($subject, $lang);
        echo "</div><!--contentArea_desc-->";
        
        echo "<a href=\"/forum/thread2?sn=$forumSn\">";	
			
		$sqlFile = "SELECT sn FROM file WHERE forumSn = '$forumSn' AND type = '$GT_FILE_TYPE_PHOTO' ORDER BY rank DESC LIMIT 1";
		$resultFile = mysql_query($sqlFile, $dbLink);
		$rowFile = mysql_fetch_array($resultFile);
		$fileSn = $rowFile[sn];
		if ($fileSn != 0) {
        	echo "<div class=\"contentArea_img\">";
            $sqlFile = "SELECT name, width, height FROM file WHERE sn = '$fileSn'";
            $resultFile = mysql_query($sqlFile, $dbLink);
            $rowFile = mysql_fetch_array($resultFile);
            $fileName = $rowFile[name];
            $fileHeight = $rowFile[height];
            $fileWidth = $rowFile[width];
            $imageDestWidth = 640;
            $imageDestHeight = $fileHeight * (640 / $fileWidth);
            echo "<img src=\"/api/file/download_photo?sn=$fileSn\" width=\"557\" height=\"$imageDestHeight\">";
        	echo "</div><!--contentArea_img-->";
		}
        echo "</a>";
        */
        $sqlForumLike = "SELECT sn FROM forumLike WHERE accountSn = '$accountSn' AND forumSn = '$forumSn' AND status = '1'";
        $resultForumLike = mysql_query($sqlForumLike, $dbLink);
        $rowForumLike = mysql_fetch_array($resultForumLike);
        if ($rowForumLike != FALSE) {
            $likeButton = t("Unlike");
        } else {
            $likeButton = t("Like");
        }
		
		$accountCount = "";
		$i = 0;
		$sqlLikeAccount = "SELECT accountSn FROM forumLike WHERE forumSn = '$forumSn' AND status = '1'";
		$resultLikeAccount = mysql_query($sqlLikeAccount, $dbLink);
		$numLikeAccount = mysql_num_rows($resultLikeAccount);
		while ($rowLikeAccount = mysql_fetch_array($resultLikeAccount)) {
			$i++;
			$likeAccountSn = $rowLikeAccount[accountSn];
			$nameDisplay = GtAccount_GetNameDisplay($likeAccountSn);
			
			$accountCount .= $nameDisplay;
			if ($numLikeAccount > 1 && $i != $numLikeAccount) {
				$accountCount .= ", ";
			}
		}
		
        $sqlForumLikeAccount = "SELECT accountSn FROM forumLike WHERE forumSn = '$forumSn' AND status = '1'";
        $resultForumLikeAccount = mysql_query($sqlForumLikeAccount, $dbLink);
        $numForumLikeAccount = mysql_num_rows($resultForumLikeAccount);
        if ($numForumLikeAccount == 0) {
            $numForumLikeAccount = "";
        }
		userContent($displayname, $userCont, $imageUrl, $forumName, $desc, $subject, $accountPic, $website, $forumSn, $createAccountSn);
		pcp($forumSn, $forumName, $accountSn, $lang, $likeButton, $dirDate, $accountCount, $numForumLikeAccount);
		//echo $forumSn."@@";
		
		$sqlCommentCount = "SELECT COUNT(*) AS c FROM commentForm WHERE forumSn = '$forumSn'";	
		$resultCommentCount = mysql_query($sqlCommentCount, $dbLink);
		$rowCommentCount = mysql_fetch_array($resultCommentCount);
		$commentCount = $rowCommentCount[c];
		
		echo "<div style=\"padding:0 20px 0 20px;\">";
		//echo "<div id = commentCount>CommentCount: ".$commentCount."</div>";
		echo "<div class=\"comment_article\" id=\"comment_$forumSn\">";	
		$comment_flag = 0;
		$sqlCF = "SELECT sn, message, accountSn, createTimeSec FROM commentForm WHERE forumSn = '$forumSn'";
		$resultCF = mysql_query($sqlCF, $dbLink);
		while ($rowCF = mysql_fetch_array($resultCF)) {
			$cfSn = $rowCF[sn];
			$cfMessage = $rowCF[message];
			$cfAccountSn = $rowCF[accountSn];
			$cfAccountType = GtAccount_GetType($cfAccountSn);
			$cfCreateDate = GtTime_GetDateTime2(GtTime_ConvertToBrowserTimeSec($rowCF[createTimeSec]));
			
			$comment_flag++;
					
		if ($cfAccountType == $GT_ACCOUNT_TYPE_FACEBOOK_USER) {
			$sqlAccount = "SELECT fbPictureUrl FROM account WHERE sn = '$cfAccountSn'";
			$resultAccount = mysql_query($sqlAccount, $dbLink);
			$rowAccount = mysql_fetch_array($resultAccount);
			$accFbPictureUrl = $rowAccount[fbPictureUrl];
			$pictureUrl = $accFbPictureUrl;
		} else {
			$sqlFile = "SELECT sn FROM file WHERE accountSn = '$cfAccountSn'";
			$resultFile = mysql_query($sqlFile, $dbLink);
			$rowFile = mysql_fetch_array($resultFile);
			$fileSn = $rowFile[sn];
			$pictureUrl = "/api/file/download_photo?sn=$fileSn";
		}
		echo "<div id=\"comment_info_$forumSn\" class=\"comment_info\" onmousemove=\"ShowDeleteBt($cfSn, $cfAccountSn)\" onmouseout=\"HideDeleteBt($cfSn)\">";
		echo "<div class=\"comment_img\"><img src=\"$pictureUrl\" width=\"32\" height=\"32\"></div>";
		echo "<div class=\"comment_cont_data\">";
		echo "<div class=\"comment_user\"><a href=\"/account/info?sn=$cfAccountSn\" target=\"_blank\"><font color=\"#3b5998\">".GtAccount_GetNameDisplay($cfAccountSn)."</font></a> ".makeClickableLinks($cfMessage)."</div>";
		echo "<div class=\"comment_time\">$cfCreateDate</div>";
		
		//user comment like
		$sqlCommentLike = "SELECT sn FROM commentLike WHERE likeCommentAccountSn = '$cfAccountSn' AND accountSn = '$accountSn' AND commentFormSn = '$cfSn' AND status = '1'";
		$resultCommentLike = mysql_query($sqlCommentLike, $dbLink);
		$rowCommentLike = mysql_fetch_array($resultCommentLike);
		if ($rowCommentLike != FALSE) {
			$likeCommentBt = t("Unlike");
		} else {
			$likeCommentBt = t("Like");
		}
		
		$accountCount = "";
		$i = 0;
		$sqlCommentLike = "SELECT accountSn FROM commentLike WHERE  likeCommentAccountSn = '$cfAccountSn' AND commentFormSn = '$cfSn' AND status = '1'";
		$resultCommentLike = mysql_query($sqlCommentLike, $dbLink);
		$numCommentLike = mysql_num_rows($resultCommentLike);
		while ($rowCommentLike = mysql_fetch_array($resultCommentLike)) {
			$i++;
			$likeCommentAccountSn = $rowCommentLike[accountSn];
			$nameDisplay = GtAccount_GetNameDisplay($likeCommentAccountSn);
			
			$accountCount .= $nameDisplay;
			if ($numCommentLike > 1 && $i != $numCommentLike) {
				$accountCount .= ", ";
			}
		}
		
		$sqlCommentLike = "SELECT accountSn FROM commentLike WHERE likeCommentAccountSn = '$cfAccountSn' AND commentFormSn = '$cfSn' AND status = '1'";
		$resultCommentLike = mysql_query($sqlCommentLike, $dbLink);
		$rowCommentLike = mysql_fetch_array($resultCommentLike);
		$numCommentLike = mysql_num_rows($resultCommentLike);
		if ($numCommentLike == 0) {
			$numCommentLike = "";
		}
		
		echo "<span class=\"like_comment\">";
		echo "・";
		echo "<span class=\"like_comment_bt\"><a id=\"likeCommentBt_$cfSn\" href=\"javascript:I_Like_This_Comment($cfSn, $cfAccountSn, $lang)\">$likeCommentBt</a></span><!--like_comment_bt-->";
		echo "<span id=\"like_comment_count_$cfSn\" class=\"like_comment_count\"";
		if ($numCommentLike <= 0) {
			echo " style=\"display:none;\"";
		}
		echo ">";
		echo "・";
		echo "<img src=\"/image/Fb_like_button.png\" width=\"15\" height=\"13\">";
		//echo "<span class=\"whoCommentLike\"><a id=\"whoCommentLike_$cfSn\" href=\"#\" alt=\"$accountCount\" title=\"$accountCount\">&nbsp;$numCommentLike</a></span><!--whoCommentLike-->";
		echo "<span class=\"whoCommentLike\"><a id=\"whoCommentLike_$cfSn\" class=\"whoCommentLikeBox\" href=\"/comment/dir/get_like_comment?sn=$cfSn\" alt=\"$accountCount\" title=\"\" onclick=\"whoCommentLikeBox(whoCommentLike_$cfSn);\">&nbsp;$numCommentLike</a></span><!--whoCommentLike-->";
		echo "</span><!--like_comment_count-->";
		echo "</span><!--like_comment-->";
		//user comment like	
		echo "</div><!--comment_cont_data-->";
		echo "<div class=\"comment_delete\">";
		echo "<a id=\"commentDeleteBt_$cfSn\" class=\"commentDeleteArticleBt\" href=\"javascript:Delete_Comment($cfSn, $forumSn)\"><img src=\"/image/close.png\"></a>";
		echo "</div><!--comment_delete-->";
		
		echo "</div><!--comment_info-->";
		if($comment_flag==2) break;
	}
	if($comment_flag==2){
	echo "<span style=\"color: #3b5998; text-align: left; font-size: small;position: relative; margin-left: 10px;\"><a href=\"/forum/thread?sn=".$forumSn."\" target=\"_blank\"><img src=message.png> View More Comments</a></span>";
	echo "<span style=\"color: gray;font-size: 12px;float: right;position: relative; margin-right: 10px;\">".$comment_flag." of ".$commentCount."</span>";
	}
	echo "<div class=\"comment_info\">";
	echo "<div class=\"comment_img\">";
	if ($accountType == $GT_ACCOUNT_TYPE_FACEBOOK_USER) {
		$sqlAccount = "SELECT fbPictureUrl FROM account WHERE sn = '$accountSn'";
		$resultAccount = mysql_query($sqlAccount, $dbLink);
		$rowAccount = mysql_fetch_array($resultAccount);
		$accFbPictureUrl = $rowAccount[fbPictureUrl];
		echo "<img src=\"$accFbPictureUrl\" width=\"32\" height=\"32\">";
	} else {
		$sqlFile = "SELECT sn FROM file WHERE accountSn = '$accountSn'";
		$resultFile = mysql_query($sqlFile, $dbLink);
		$rowFile = mysql_fetch_array($resultFile);
		$fileSn = $rowFile[sn];
		
		if ($fileSn > 0) {
			echo "<img src=\"/api/file/download_photo?sn=$fileSn\" width=\"32\" height=\"32\">";
		} else {
			if (GtAccount_GetGender($accountSn) == 1) {
				echo "<img src=\"/image/user_profile_man.jpeg\" width=\"32\" height=\"32\">";
			} elseif (GtAccount_GetGender($accountSn) == 2) {
				echo "<img src=\"/image/user_profile_women.jpeg\" width=\"32\" height=\"32\">";
			} else {
				echo "<img src=\"/image/user_profile_man.jpeg\" width=\"32\" height=\"32\">";
			}
		}
	}
	echo "</div>";
	echo "<div class=\"comment_message\">";
	echo "<textarea name=\"add_comment_text\" id=\"comment_text_$forumSn\" class=\"comment_text\" title=\"".t("Write a comment...")."\" placeholder=\"".t("Write a comment...")."\"></textarea>";
	echo "</div>";
	echo "</div><!--comment_info-->";
	echo "</div><!--comment_article-->";
	echo "</div>";
		//userComment($accountSn, $forumSn);
		
        /*
        echo "<div class=\"contentArea_pcp\">";
		
        echo "<span class=\"like_bt\"><a id=\"likeButton_$forumSn\" href=\"javascript:I_Like_This($forumSn, $accountSn, $lang)\">$likeButton</a></span><!--like_bt-->";
        
       echo "・";
		echo "<span class=\"share_cont\">";
		echo "<a href=\"#\" onclick=\"Share_Bt($forumSn);return false;\">".t("Share")."</a>";
		echo "<span id=\"share_index_bt\" class=\"share_index_bt_$forumSn\" onmousemove=\"ShowShareBt($forumSn)\" onmouseout=\"HideShareBt($forumSn)\">";
		echo "<span class=\"share_fb\"><a target=\"_blank\" href=\"http://www.facebook.com/share.php?u=http://$serverUrl/forum/thread?sn=$forumSn&t=$forumName\" onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/image/facebook_share_bt.png\" alt=\"Share on Facebook\"></a></span>";
		echo "<span class=\"share_twitter\"><a href=\"http://twitter.com/share?text=".str_replace("#","%23",$forumName)."&url=http://$serverUrl/forum/thread?sn=$forumSn\" onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/image/twitter_share_bt.png\" alt=\"Share on Twitter\"></a></span>";
		echo "<span class=\"share_google\"><a href=\"https://plus.google.com/share?url=http://$serverUrl/forum/thread?sn=$forumSn\" onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/image/google_share_bt.png\" alt=\"Share on Google+\"/></a></span>"; 
		 echo "<span class=\"share_weibo\"><a href=\"http://v.t.sina.com.cn/share/share.php?title=".str_replace("#","%23",$forumName)."&url=http://$serverUrl/forum/thread?sn=$forumSn\" onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"/image/weibo_share_bt.png\" alt=\"Share on Weibo\"/></a></span>"; 
		echo "<span class=\"share_email\"><a target=\"_blank\" href=\"mailto:?subject=$forumName&body=http://$serverUrl/forum/thread?sn=$forumSn\"><img src=\"/image/email_share_bt.png\" alt=\"Share on Email\"></a></span>";
		echo "</span><!--share_index_bt-->";
		echo "</span><!--share_cont-->";
		
        echo "<span id=\"like_count_$forumSn\" class=\"like_count\"";
		if ($numForumLikeAccount <= 0) {
			echo " style=\"display:none;\"";
		}
		echo ">";
		echo "・";
		echo "<span class=\"whoLike\"><a class=\"wholikecbox\" id=\"whoLike_$forumSn\" href=\"/comment/forum/get_like_account?sn=$forumSn\" alt=\"$accountCount\" title=\"$accountCount\"><img src=\"/image/Fb_like_button.png\" width=\"20\" height=\"18\"> $numForumLikeAccount</a></span>";
        echo "</span><!--like_count-->";
		echo "・";
		echo "<span class=\"time_cont\">$dirDate</span>";
        echo "</div><!--contentArea_pcp-->";
		 */
        echo "</div><!--contentArea_cont-->";
		//echo "pcp($forumSn, $forumName, $accountSn, $lang, $likeButton)";
    }
    ?>
    <div id="contentArea_load">
    <?php
   	//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
	$startRow_records = ($page -1) * $itemPerPage;
	//未加限制顯示筆數的SQL敘述句
	$sql_query = "SELECT sn, name, subject, website, description, createTimeSec, editTimeSec FROM forum WHERE dirSn = '$sn' AND status = '$GT_DIR_STATUS_PUBLISH' AND lang = '$lang'";
	//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
	$sql_query_limit = $sql_query." LIMIT ".$startRow_records.", ".$itemPerPage;
	//以加上限制顯示筆數的SQL敘述句查詢資料到 $result 中
	$result = mysql_query($sql_query_limit);
	//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_result 中
	$all_result = mysql_query($sql_query, $dbLink);
	//計算總筆數
	$total_records = mysql_num_rows($all_result);
	//計算總頁數=(總筆數/每頁筆數)後無條件進位。
	$total_pages = ceil($total_records/$itemPerPage);
	?>
    <table border="0" align="center">
    <tr><td>                       
    <?php
	if ($total_pages > 1) {
		// 顯示的頁數範圍
		$range = 4;
		// 若果正在顯示第一頁，無需顯示「前一頁」連結
		if ($page > 1) {
			// 前一頁的頁數
			$prevpage = $page - 1;
			// 使用 < 連結回到前一頁
			echo " <a href={$_SERVER['PHP_SELF']}?sn=$sn&page=".$prevpage."><img src=\"/image/icon-left.png\"></a> ";
		} // end if
		  
		// 顯示當前分頁鄰近的分頁頁數
		for ($x = (($page - $range) - 1); $x < (($page + $range) + 1); $x++) {
			// 如果這是一個正確的頁數...
			if (($x > 0) && ($x <= $total_pages)) {
				// 如果這一頁等於當前頁數...
				if ($x == $page) {
					// 不使用連結, 但用高亮度顯示
					echo " [<b>".$x."</b>] ";
					// 如果這一頁不是當前頁數...
				} else {
					// 顯示連結
					echo " <a href=index.php?sn=$sn&page=".$x.">".$x."</a> ";
				} // end else
			} // end if
		} // end for
		  
		// 如果不是最後一頁, 顯示跳往下一頁及最後一頁的連結
		if ($page != $total_pages) {
			// 下一頁的頁數
			$nextpage = $page + 1;
			// 顯示跳往下一頁的連結
			echo " <a href={$_SERVER['PHP_SELF']}?sn=$sn&page=".$nextpage."><img src=\"/image/icon-right.png\"></a> ";
			// 顯示跳往最後一頁的連結
		} // end if
	}
    ?>
    </td></tr>
    </table>
    </div><!--contentArea_load-->
    
    </div><!--contentArea-->
    
    </div><!--contentArea_dir-->
</div><!--controlCol-->

</div><!--article-->
<?php
function cut_word ($desc, $lang) {
	global $GT_LANG_EN_US;
	
	if ($lang == $GT_LANG_EN_US) {
		$cutSpace = explode(" ",$desc);
		//echo count($cutSpace)." ";
		if (count($cutSpace) > 8) {
			for($i = 0; $i < 8; $i++) {
				$cutDesc .= $cutSpace[$i];
				if ($i < 8) {
					$cutDesc .= " ";
				}
			}
			$cutDesc .= "...";
		} else {
			$cutDesc = $desc;
		}
	} else {
		$len = 2;
		$totalLen = 40;
		$textlen = $totalLen * $len;  //例如:utf-8的中文字占3byte,若要顯示20個字元,則$textlen=60(60/3=20)
		//$str = "這裡是要顯示的字串";
		if (strlen($desc) > $textlen) {
			for($i = 0; $i < $textlen; $i++) {
				$ch= substr($desc, $i, 1);
				
				if(ord($ch) > 127)
					$i += 2;
			}
			$cutDesc = substr($desc, 0, $i);    
			$cutDesc = $desc."...";//如果字串超出20個字，就取前20個字並加...字串     
		} else {
			$cutDesc = $desc;
			//echo $cutDesc;//如果字串未超過20個字,則顯示所有的字串
		}
	}
		
	return $cutDesc;
}

$sql = "UPDATE dir SET viewCount = viewCount + 1 WHERE sn = '$sn'";
$result = mysql_query($sql, $dbLink);

GtLog_I($GT_LOG_TYPE_VIEW, $accountSn);
include(getenv("DOCUMENT_ROOT")."/includePUX4QF93/footer.php");
?>