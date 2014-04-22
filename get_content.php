<?php
//fixed link
$link="https://tw.news.yahoo.com/";
//GET link
if($link==null)
  $link=$_GET["link"];
//POST link
if($link==null)
  $link=$_POST["link"];

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
    echo $this->image.",".$this->description;
  }
}

$link_page=file_get_contents($link);
preg_match_all('#<meta property=[\'"][^>]*[\'"] content=[^>]*>#i', $link_page, $og_info);
print_r($og_info);

//$comicVol=count($match2[0]);

//$og1->show_og_content();
?>
