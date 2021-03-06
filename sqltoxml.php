<?php
$username="root";
$password="";
$database="tracker";

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}


// Opens a connection to a MySQL server
$connection=mysqli_connect ('localhost', $username, $password, $database);
if(!$connection) {
  die('Not connected : ' . mysqli_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM vehicles";
$result = mysqli_query($connection,$query);
if (!$result) {
  die('Invalid query: ');
}
Header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'id="' . $row['id'] . '" ';
  echo 'vtype="' . $row['vtype'] . '" ';
  
  echo 'lat="' . $row['lat'] . '" ';
  echo 'log="' . $row['log'] . '" ';
  echo 'vid="' . parseToXML($row['vehicleidno']) . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file

echo '</markers>';

?>
