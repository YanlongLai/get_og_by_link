<?php
//fixed link
//GET link
$link=@urldecode($_GET["link"]);


//Test link list
//$link="http://atedev.wordpress.com/2007/11/23/%E6%AD%A3%E8%A6%8F%E8%A1%A8%E7%A4%BA%E5%BC%8F-regular-expression/";
//$link="http://api.jquery.com/keyup/";
//$link="http://tw.yahoo.com";
//$link="http://www.ettoday.net/news/20140427/351031.htm";
//$link=urldecode("http%3a%2f%2fgoo.gl%2fLZbaPp");
//$link="https://www.facebook.com/robotclubtw";
//$link="http://tw-leaderg.leadergstaging.com/forum/index?sn=1093";
//$link="http://share.hothk.com/2014/05/blog-post_9622.html?m=1&_=1400228348899";
//$link="http://en.wikipedia.org/wiki/Caelum";
//$link="http://udn.com/NEWS/BREAKINGNEWS/BREAKINGNEWS9/8682091.shtml";
//$link="https://tw.news.yahoo.com/%E7%82%BA8%E5%8D%83%E5%85%83%E7%94%B7%E5%8B%92%E6%96%83%E5%A5%B3%E5%90%8C%E4%BA%8B-%E7%88%B6%E8%A6%AA%E7%97%9B%E6%89%B9-%E5%AF%A6%E5%9C%A8%E5%A4%AA%E5%8F%AF%E6%83%A1%E4%BA%86-080133415.html";
//$link="http://udn.com/NEWS/MAINLAND/MAI1/";

//Main code
$og1=new og;
//ob_start();

//Time test
//$time_start = microtime(true);

if(test_link($link))
parser_link($link, $result);

//$time_end = microtime(true);
//$time = $time_end - $time_start;
//echo "Function in $time seconds\n";

//$time_end2 = microtime(true);
//$time = $time_end2 - $time_end;
//echo "Function in $time seconds\n";

$og1->show_og_content();

if($og1->image!="none")
  $og1->get_og_image($og1->image);

//ob_end_flush();
//Test
//print_r($og_infos);
//print_r($og_imgs);

//build class og by Yanlong
class og{
  var $image;
  var $title;
  var $site_name;
  var $description;
  //constructor
  function og()
  {
    $this->image = "none";
    $this->title = "none";
    $this->site_name = "none";
    $this->description = "none";
  }
  function show_og_content(){
    $json_e = json_encode( (array) $this );
    //echo $this->image.",".$this->description;
    echo $json_e."\n";
  }
  function get_og_image($remote_source_root){
		global $serverUploadDir;
		global $accountSn;
	
    if(@file($remote_source_root))
    {
      $image=file_get_contents($remote_source_root);
      $parts = basename($remote_source_root);
      //echo 'thumb/'.$parts."\n";
      //copy($remote_source_root, 'thumb/'.$parts."\n");
      if(!stripos ($remote_source_root, "leaderg")){
        if(stripos ($parts, "?")){
          $parts_unit=explode("?", $parts);
          file_put_contents('thumb/'.$parts_unit[0], $image);
        }
        else
        file_put_contents('thumb/'.$parts, $image);
      }

    }
  }
}

//Test link or not
function test_link($url)
{
  global $result;
  ini_set('user_agent','Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36');
  $dh=@fopen("$url",'r');
  if($dh!=null)
  {
    //link ok
    //$result = fread($dh,8192);
    $result = fread($dh,256);
    return true;
  }
  else
  {
    return false;
  }
}

function parser_link($link, $result){
  global $og1;
  global $og_infos;
  global $og_imgs;
  $result=file_get_contents($link);
  //$result=iconv("big5","UTF-8",$result);
  //$result=html_entity_decode($result, ENT_XML1, 'UTF-8');
  //$result=html_entity_decode(file_get_contents($link), ENT_XML1, 'UTF-8');
  //$result=html_entity_decode(file_get_contents($link),ENT_QUOTES,"ISO-8859-1");
  //$result= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$result);
  //$result= utf8_encode ($result);
  //$result= utf8_decode ($result);
  //$result= preg_replace('/&#(\d+);/me',"chr(\\1)", $result);
  //$result= preg_replace('/;&#x/','\u', $result);
  //preg_match_all('#<meta (property|name)=[\'"]([^>]*)[\'"][ |\n]content=[\'"]([^>]*)[\'"][^"]*>#', $result, $og_infos, PREG_SET_ORDER);
  //echo $link_page;
  //preg_match_all('#<meta property=[\'"]([^>]*)[\'"] content=[\'"]([^>]*)[\'"].>#i', $link_page, $og_infos, PREG_SET_ORDER);
  
//  First SEARCH //
  
  preg_match_all('#<meta (property|name)=[\'"]([^>]*)[\'"][ |\n]content=[\'"]([^>]*)[\'"][^"]*>#', $result, $og_infos, PREG_SET_ORDER);
  foreach ($og_infos as $og_info){
  //encode
    if(!mb_detect_encoding($og_info[3], 'UTF-8'))
      $og_info[3]=iconv("big5","UTF-8",$og_info[3]);
  //Search
    if (strpos ($og_info[2], "og:image")!==false)
      $og1->image=$og_info[3];
    if (strpos ($og_info[2], "og:title")!==false)
      $og1->title=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
    if (strpos ($og_info[2], "og:site_name")!==false)
      $og1->site_name=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
    if (strpos ($og_info[2], "og:description")!==false)
      $og1->description=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');

  //Fuzzy search
    if (stripos ($og_info[2], "image")!==false && $og1->image=="none")
      $og1->image=$og_info[3];
    if (stripos ($og_info[2], "title")!==false && $og1->title=="none")
      $og1->title=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
      //$og1->title=$og_info[3];
    else if (stripos ($og_info[2], "author")!==false && $og1->title=="none")
      $og1->title=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
    if (stripos ($og_info[2], "site_name")!==false && $og1->site_name=="none")
      $og1->site_name=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
    else if(stripos ($og_info[2], "generator")!==false && $og1->site_name=="none")
      $og1->site_name=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
    if (stripos ($og_info[2], "description")!==false && $og1->description=="none")
      $og1->description=html_entity_decode($og_info[3], ENT_QUOTES, 'UTF-8');
    //print_r($og_info);
    //print_r($og_unit);
  }

//  Second SEARCH --- http://share.hothk.com/  //

  preg_match_all('#<meta content=[\'"]([^>]*)[\'"][ ](property|name)=[\'"]([^>]*)[\'"][^>]*>#', $result, $og_infos, PREG_SET_ORDER);
  foreach ($og_infos as $og_info){
  //encode
    if(!mb_detect_encoding($og_info[3], 'UTF-8'))
      $og_info[3]=iconv("big5","UTF-8",$og_info[3]);
  //Search
    if (strpos ($og_info[3], "og:image")!==false)
      $og1->image=$og_info[1];
    if (strpos ($og_info[3], "og:title")!==false)
      $og1->title=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
    if (strpos ($og_info[3], "og:site_name")!==false)
      $og1->site_name=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
    if (strpos ($og_info[3], "og:description")!==false)
      $og1->description=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');

  //Fuzzy search
    if (stripos ($og_info[3], "image")!==false && $og1->image=="none")
      $og1->image=$og_info[1];
    if (stripos ($og_info[3], "title")!==false && $og1->title=="none")
      $og1->title=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
      //$og1->title=$og_info[3];
    else if (stripos ($og_info[3], "author")!==false && $og1->title=="none")
      $og1->title=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
    if (stripos ($og_info[3], "site_name")!==false && $og1->site_name=="none")
      $og1->site_name=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
    else if(stripos ($og_info[3], "generator")!==false && $og1->site_name=="none")
      $og1->site_name=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
    if (stripos ($og_info[3], "description")!==false && $og1->description=="none")
      $og1->description=html_entity_decode($og_info[1], ENT_QUOTES, 'UTF-8');
    
    //des = title
    if($og1->description=="")
    $og1->description = $og1->title;

    //print_r($og_info);
    //print_r($og_unit);
  }

  //   Third SEARCH --- wiki //
  //
  //   title
  preg_match_all('#<title>([^<]*)</title>#', $result, $og_infos, PREG_SET_ORDER);
  foreach ($og_infos as $og_info){
  //encode
    if(!mb_detect_encoding($og_info[1], 'UTF-8'))
      $og_info[1]=iconv("big5","UTF-8",$og_info[1]);
  //Search
    if($og1->title=="none" || $og1->title==null)
      $og1->title=$og_info[1];
    //print_r($og_info);
  
  }
  //   des.
  preg_match_all('#<p>(.*)</p>#', $result, $og_infos, PREG_SET_ORDER);
  foreach ($og_infos as $og_info){
  //encode
    if(!mb_detect_encoding($og_info[1], 'UTF-8'))
      $og_info[1]=iconv("big5","UTF-8",$og_info[1]);
  //Search
    if($og1->description=="none")
      $og1->description=strip_tags($og_info[1]);
    //print_r($og_info);
  
  }

  preg_match_all('#<span dir=[\'"]([^>]*)[\'"][>]([^<]*)</span>#', $result, $og_infos, PREG_SET_ORDER);
  foreach ($og_infos as $og_info){
    if (strpos ($og_info[1], "auto")!==false  && ($og1->title=="none" || $og1->title==null))
      $og1->title=$og_info[2];
    //print_r($og_info);
  
  }

  //Find the First image
  if($og1->image=="none"){
    if(preg_match_all('#<img[^s]*\ssrc=[\'"]([^\'"]*)[\'"] [^>]*>#', $result, $og_imgs, PREG_SET_ORDER))
      $og1->image=$og_imgs[0][1];
    if($og1->image==null)
      $og1->image="none";
    //print_r($og_imgs);
  }
}
/*
if (in_array($argv[1], array('-log'))) {
  print_r($og_infos);
}
*/

?>
