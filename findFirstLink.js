<script>
function findFirstLink(text) {
  //http....
  var exp = /(\b(https?exp|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  var match = exp.exec(text);
  //No http... but a link
  if(match==null){
    var exp = /(^|[^\/])([a-zA-Z0-9\-\_]+\.[\S]+(\b|$))/gim;
    var match = exp.exec(text);
  }
  //No link
  if(match==null){
    return "None";
  }

  return match[0];
}
</script>
