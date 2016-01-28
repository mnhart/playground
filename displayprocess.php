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
$name = $_POST['name'];
$emailcontent = $_POST['emailbody'];
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
	$searchquery=$row['searchquery'];
	$date=$row['data'];
$query = "insert into playcontact(articletitle, abtsract, affiliation, aut1firstname, aut1lastname, aut1email, city, country, journal, relevance, keywords, journalyear, pmid, aut2firstname, aut2lastname, assignedto, emailcontent, searchquery, data)" .
	"values('$title','$abstract', '$affiliation', '$firstname', '$lastname', '$email', '$city', '$country', '$journal', '$relevance', '$keyword', '$journalyear', '$pmid', '$secondauthor1', '$secondauthor2', '$name', '$emailcontent', '$searchquery', '$date')";
$result=mysqli_query($dbc, $query);
$query = "delete from playcontact where id='$id'";
$result=mysqli_query($dbc, $query);
echo '<p>Contacted by: ', $name, '</p>';
echo '<p>Email content: <br>', $emailcontent, '</p>';

?>
<a href="/playground">Main page</a>
</div>
</body>
</html>