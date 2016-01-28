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

$id = (int)$_GET['id'];
$dbc = mysqli_connect('localhost', 'xmltest', 'kluivert', 'testxml')
		or die('Error establishing connection');


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
	$relevance=$row['relevance'];
	
	
	//Keyword highlight
	include 'keywords.php';
		foreach ($negKeyw as $nkey){
				$abstract=preg_replace("/($nkey)/i","<span style='color:tomato; font-weight:bold'>$1</span>",$abstract);
				$title=preg_replace("/($nkey)/i","<span style='color:tomato; font-weight:bold'>$1</span>",$title);
				$keyword=preg_replace("/($nkey)/i","<span style='color:tomato; font-weight:bold'>$1</span>",$keyword);
		}
		foreach ($posKeyw as $pkey){
				$abstract=preg_replace("/($pkey)/i","<span style='color:royalblue; font-weight:bold'>$1</span>",$abstract);
				$title=preg_replace("/($pkey)/i","<span style='color:royalblue; font-weight:bold'>$1</span>",$title);
				$keyword=preg_replace("/($pkey)/i","<span style='color:royalblue; font-weight:bold'>$1</span>",$keyword);
		}
	//End of keyword highlight
	
	echo '<p>Search for: keywords will be here on 09.10.2013</p>';
	echo '<h2>', $lastname,' ',$firstname, '</h2>';
	echo '<p></strong>',$secondauthor2, ' ',$secondauthor1,'</strong></p>';
	echo '<h3>', $email, '</h3>';
?>
<p>Enter email address:</p>
	<form action="forsearchprocess.php" method="post">
	<input type="text" name="email"/><br/>
	<input type="hidden" name="id" value="<?php echo $id ?>"/>
	<input type="submit"/>
	</form>
<?php	
	
	echo '<p><strong>', $country, '</strong></p>';
	echo '<p><b>Affiliation</b> ', $affiliation, '</p>';
	echo '<p><b>Journal: </b>',$journal, '</p>';
	echo '<p><b>Year: </b>',$journalyear, '</p>';
	echo '<h3>', $title, '</h3>';
	echo '<p><strong>Pubmed link: </strong> <a href="http://www.ncbi.nlm.nih.gov/pubmed/',$pmid,'" target="_blank">Go to article:</a></p>';
	echo '<div id="abstract"><p><b>Abstract:</b> ', $abstract, '</p></div>';
	echo '<p><b>Keyword difference:</b>', $relevance, '</p>';
	echo '<p><b>Keywords by authors:</b> ',$keyword, '</p>';
	
	
?>
<table border="1" cellpadding="10">
	<tr>
		<td><b><a href="/playground/forsearchindex.php">Back</b></td>
		<td><b><a href="/playground">Main page</b></td>
	</tr>
</table>
</div>
</body>
</html>






