<?php
//fixed link
$link="https://tw.news.yahoo.com/";
//GET link
if($link=null)
  $link=$_GET["link"];
//POST link
if($link=null)
  $link=$_POST["link"];

$og1=new og;
class og{
  var $image;
  var $title;
  var $site_name;
  var $description;
  function og()
  {
    $this->image = "none";
    $this->description = "none";
  }
  function show_og_content(){
    echo $this->image.",".$this->description;
  }
}
$og1->show_og_content();
?>
