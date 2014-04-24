<?php
//fixed link
//GET link
$link=@urldecode($_GET["link"]);


//Test link list
//$link="http://atedev.wordpress.com/2007/11/23/%E6%AD%A3%E8%A6%8F%E8%A1%A8%E7%A4%BA%E5%BC%8F-regular-expression/";
//$link="http://api.jquery.com/keyup/";
//$link="http://tw.yahoo.com";
//$link=urldecode("http%3a%2f%2fgoo.gl%2fLZbaPp");

//Main code
$og1=new og;
ob_start();
if(test_link($link))
parser_link($link, $result);
$og1->show_og_content();
ob_end_flush();
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
    $result = fread($dh,8192);
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
  //$link_page=file_get_contents($link);
  //preg_match_all('#<meta (property|name)=[\'"]([^>]*)[\'"][ |\n]content=[\'"]([^>]*)[\'"][^"]*>#', $link_page, $og_infos, PREG_SET_ORDER);
  preg_match_all('#<meta (property|name)=[\'"]([^>]*)[\'"][ |\n]content=[\'"]([^>]*)[\'"][^"]*>#', $result, $og_infos, PREG_SET_ORDER);
  //echo $link_page;
  //preg_match_all('#<meta property=[\'"]([^>]*)[\'"] content=[\'"]([^>]*)[\'"].>#i', $link_page, $og_infos, PREG_SET_ORDER);
  foreach ($og_infos as $og_info){
    if (stripos ($og_info[2], "image")!==false)
      $og1->image=$og_info[3];
    if (stripos ($og_info[2], "title")!==false)
      $og1->title=$og_info[3];
    else if (stripos ($og_info[2], "author")!==false)
      $og1->title=$og_info[3];
    if (stripos ($og_info[2], "site_name")!==false)
      $og1->site_name=$og_info[3];
    else if(stripos ($og_info[2], "generator")!==false)
      $og1->site_name=$og_info[3];
    if (stripos ($og_info[2], "description")!==false)
      $og1->description=$og_info[3];
    //print($og_info[3]."\n");
    //print_r($og_unit);
  }
  //Find the First image
  if($og1->image=="none"){
    if(preg_match_all('#<img src=[\'"]([^\'"]*)[\'"] [^>]*>#', $link_page, $og_imgs, PREG_SET_ORDER))
      $og1->image=$og_imgs[0][1];
    if($og1->image==null)
      $og1->image="none";
  }
}
/*
if (in_array($argv[1], array('-log'))) {
  print_r($og_infos);
}
*/

?>
