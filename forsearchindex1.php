<!DOCTYPE html>
<html>
<head>
<title>Neurostar contacts
</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php

$countryselect=$_POST['countryselect'];

include 'sort1.php';
echo '<a href="forsearchindex.php">View all countries</a>';

$dbc = mysqli_connect('localhost', 'xmltest', 'kluivert', 'testxml')
		or die('Error establishing connection');
		
$query="select * from playground where aut1email = 'No emails found' and country='$countryselect'";
$result=mysqli_query($dbc, $query);

echo '<table border="1" cellpadding="10">';
echo '<tr><th>Last name</th><th>First name</th><th>Email</th><th>Country</th><th>Affiliation</th><th>Journal</th><th>Year</th><th>Action</th>';
while($row = mysqli_fetch_array($result)){


	$id=$row['id'];
	$firstname=$row['aut1firstname'];
	$lastname=$row['aut1lastname'];
	$affiliation=$row['affiliation'];
	$country=$row['country'];
	$email=$row['aut1email'];
	$journal=$row['journal'];
	$journalyear=$row['journalyear'];
	
	echo '<tr>';
	echo '<td>',$lastname,'</td>';
	echo '<td>',$firstname,'</td>';
	echo '<td>',$email,'</td>';
	echo '<td>',$country,'</td>';
	echo '<td>',$affiliation,'</td>';
	echo '<td>',$journal,'</td>';
	echo '<td>',$journalyear,'</td>';
	echo '<td><a href="forsearchrecord.php?id=' . $row[19] . '">View</a></td>';
	echo '</tr>';
}
mysqli_close($dbc);
?>
</body>
</html>