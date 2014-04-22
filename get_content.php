<?php
//fixed link
//GET link
$link=urldecode($_GET["link"]);
//$link="https://tw.yahoo.com/";
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
    echo $json_e;
  }
}

$link_page=file_get_contents($link);
preg_match_all('#<meta (property|name)=[\'"]([^>]*)[\'"] content=[\'"]([^>]*)[\'"][^"]*>#i', $link_page, $og_infos, PREG_SET_ORDER);
//preg_match_all('#<meta property=[\'"]([^>]*)[\'"] content=[\'"]([^>]*)[\'"].>#i', $link_page, $og_infos, PREG_SET_ORDER);
foreach ($og_infos as $og_info){
  if (strpos ($og_info[2], "image"))
  $og1->image=$og_info[3];
  else if (strpos ($og_info[2], "Image"))
  $og1->image=$og_info[3];

  if (strpos ($og_info[2], "title"))
  $og1->title=$og_info[3];
  if (strpos ($og_info[2], "site_name"))
  $og1->site_name=$og_info[3];
  if (strpos ($og_info[2], "description"))
  $og1->description=$og_info[3];
  //print_r($og_unit);
}
//$json_d=json_decode($json_e);
//print_r($json_d);
//print_r($og_infos);

//$comicVol=count($match2[0]);

$og1->show_og_content();
?>
