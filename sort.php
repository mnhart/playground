<?php

$dbc = mysqli_connect('localhost', 'xmltest', 'kluivert', 'testxml')
		or die('Error establishing connection');
		
$query="select * from playground where aut1email <> 'No emails found'";
$result=mysqli_query($dbc, $query);
//print_r($result);

while($row = mysqli_fetch_array($result)){
   $countries[]=$row['country'];

}
$countries=array_unique($countries);
sort($countries);
?>
<form action="displayindex1.php" method="post">
<select name="countryselect">
<option value="">All</option>
<?php 
  
    foreach($countries as $country => $value) 
    {
       $category = htmlspecialchars($country); 
       echo '<option value="'. $value .'">'. $value .'</option>';
	   
    }
?>
</select>
<!--
<select name="sortby">
<option value="">ID</option>
<option value="journalyear">Pub Year</option>
<option value="relevance">Keyword difference</option>
</select>-->
<input type="submit" name="submit"/>
</form>

