<?php
//fixed link
//GET link
$link=urldecode($_GET["link"]);
//$link="http://atedev.wordpress.com/2007/11/23/%E6%AD%A3%E8%A6%8F%E8%A1%A8%E7%A4%BA%E5%BC%8F-regular-expression/";
$link="http://api.jquery.com/keyup/";
//$link="http://tw.yahoo.com";
//$link=urldecode("http%3a%2f%2fgoo.gl%2fLZbaPp");
//POST link
/*
if($link==null)
  $link=$_POST["link"];
 */
$og1=new og;
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

$link_page=file_get_contents($link);
preg_match_all('#<meta (property|name)=[\'"]([^>]*)[\'"][ |\n]content=[\'"]([^>]*)[\'"][^"]*>#', $link_page, $og_infos, PREG_SET_ORDER);
//echo $link_page;
//preg_match_all('#<meta property=[\'"]([^>]*)[\'"] content=[\'"]([^>]*)[\'"].>#i', $link_page, $og_infos, PREG_SET_ORDER);
foreach ($og_infos as $og_info){
  if (stripos ($og_info[2], "image"))
  $og1->image=$og_info[3];
  if (stripos ($og_info[2], "title"))
  $og1->title=$og_info[3];
  if (stripos ($og_info[2], "site_name"))
    $og1->site_name=$og_info[3];
  else if(stripos ($og_info[2], "tor"))
    $og1->site_name=$og_info[3];
  if (stripos ($og_info[2], "tion"))
  $og1->description=$og_info[3];
  print($og_info[3]."\n");
  //print_r($og_unit);
}
if($og1->image=="none"){
  if(preg_match_all('#<img src=[\'"]([^\'"]*)[\'"] [^>]*>#', $link_page, $og_imgs, PREG_SET_ORDER))
  $og1->image=$og_imgs[0][1];
  if($og1->image==null)
    $og1->image="none";
}
//print_r($og_imgs);

//$json_d=json_decode($json_e);
//print_r($json_d);
print_r($og_infos);
/*
if (in_array($argv[1], array('-log'))) {
  print_r($og_infos);
}
 */
//$comicVol=count($match2[0]);

$og1->show_og_content();
?>
