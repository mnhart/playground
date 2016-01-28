<!DOCTYPE html>
<html>
<head>
<title>Neurostar contacts
</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="wrapper">
<?php

$dbc = mysqli_connect('localhost', 'xmltest', 'kluivert', 'testxml')
		or die('Error establishing connection');
$id = $_POST['id'];
$name = $_POST['email'];
$query="select * from playground where id = '$id'";
$result=mysqli_query($dbc, $query);

$row=mysqli_fetch_assoc($result);
	$firstname=$row['aut1firstname'];
	$lastname=$row['aut1lastname'];
	$secondauthor1=$row['aut2firstname'];
	$secondauthor2=$row['aut2lastname'];
	$affiliation=$row['affiliation'];
	$city=$row['city'];
	$country=$row['country'];
	$email=$row['aut1email'];
	$title=$row['articletitle'];
	$abstract=$row['abtsract'];
	$keyword=$row['keywords'];
	$relevance=$row['relevance'];
	$journal=$row['journal'];
	$journalyear=$row['journalyear'];
	$pmid=$row['pmid'];
	$pmid='http://www.ncbi.nlm.nih.gov/pubmed/'.$pmid;
	$relevance=$row['relevance'];
$query = "update playground set aut1email = '$name' where id = '$id'";
$result=mysqli_query($dbc, $query);
echo '<h2>New email address stored: ', $name,'</h2>';

?>
<a href="/playground">Main page</a>
</div>
</body>
</html>