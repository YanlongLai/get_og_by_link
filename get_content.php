<?php
//fixed link
$link="http://tw.leaderg.com/article/index?sn=9735";
//GET link
if($link=null)
  $link=$_GET["link"];
//POST link
if($link=null)
  $link=$_POST["link"];

$og1=new og;
class og{
  var $image_link;
  var $des;
  function og()
  {
    $this->image_link = "none";
    $this->des = "none";
  }
  function show_og_content(){
    echo $this->image_link.",".$this->des;
  }
}
$og1->show_og_content();
?>
