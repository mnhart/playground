<!DOCTYPE html>
<head>
<title>
</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php

//upload file
//$info = pathinfo($_FILES['myFile']['name']);
//$ext = $info['extension']; // get the extension of the file
//$nname = $info['filename'];
//$newname = $nname.'.'.$ext; 
//$target = 'C:/wamp/www/playground/uploads/'.$newname;
//move_uploaded_file( $_FILES['myFile']['tmp_name'], $target);
//end of upload file

//get search query and date
//$searchquery=$_POST['searchquery']; //goes to database
$date = date('m/d/Y'); //goes to database
$searchquery='subthalamic from 2010';

//load file
$content = utf8_encode(file_get_contents('subthalamicfrom20102.xml'));
$xml = simplexml_load_string($content);

foreach ($xml->PubmedArticle as $PubmedArticle) {

$dbc = mysqli_connect('localhost', 'xmltest', 'kluivert', 'testxml')
		or die('Error establishing connection');
		
$date= date('m/d/Y');
		
//Article Title
	$articletitle=$PubmedArticle->MedlineCitation->Article->ArticleTitle;
	//echo  '<h2>', $articletitle, '</h2>'; //Goes to Database
	//End of Article Title
	
	//Abstract
	$abstract=$PubmedArticle->MedlineCitation->Article->Abstract->AbstractText;
	$abstractbackup=$abstract;
	
	//Relevance count words

	include 'keywords.php';
	$b=0;
	$d=0;
	foreach ($negKeyw as $nkey){
		$a=substr_count($abstract, $nkey);
		//$abstract=preg_replace("/($nkey)/i","<span style='color:red; font-weight:bold'>$1</span>",$abstract);
		$b=$b+$a;
		}
	
	//Search for negative keywords in article title too
	foreach ($negKeyw as $nkey){
		$a=substr_count($articletitle, $nkey);
		//$abstract=preg_replace("/($nkey)/i","<span style='color:red; font-weight:bold'>$1</span>",$abstract);
		$b=$b+$a;
		} //end of search in article title
	
	foreach ($posKeyw as $pkey){
		$c=substr_count($abstract, $pkey);
		//$abstract=preg_replace("/($pkey)/i","<span style='color:blue; font-weight:bold'>$1</span>",$abstract);
		$d=$d+$c;
		}
	
	//Search for positive keywords in article title too
	foreach ($posKeyw as $pkey){
		$c=substr_count($articletitle, $pkey);
		//$abstract=preg_replace("/($pkey)/i","<span style='color:blue; font-weight:bold'>$1</span>",$abstract);
		$d=$d+$c;
		}
	$relevance=$d-$b;
	//echo '<h3>Relevance of article: ',$relevance,'</h3>';
	
	//End of highlight words */
	
	
	//echo '<p>', $abstract, '</p>'; //Goes to Database
	//End of abstract
	
	//Keyword_list
	$keyword=' ';
	if ($PubmedArticle->MedlineCitation->KeywordList !=''){
	foreach ($PubmedArticle->MedlineCitation->KeywordList->Keyword as $keyz) {
			$keyz.=', ';
			$keyword.=$keyz;
			}
			}
	//echo '<p> Keyword list: </p>', $keyword,'</p>'; //Goes to database
	//End of keyword list
	
	
	//Year
	$pubdate=$PubmedArticle->MedlineCitation->Article->ArticleDate->Year;
	//echo  '<p>', 'Year: ', $pubdate, '</p>'; //Goes to Database
	//End of year
	
	
	//Affiliation in full
	$affiliation=$PubmedArticle->MedlineCitation->Article->Affiliation;
	//echo  '<p>', 'Affiliation: ', $affiliation, '</p>'; //Goes to Database
	//End of affiliation
	
	
	//First Author name
	$aut1firstname=$PubmedArticle->MedlineCitation->Article->AuthorList->Author->ForeName;
	//echo  'First author name: ', $aut1firstname, ' '; //Goes to Database
	
	$aut1lastname=$PubmedArticle->MedlineCitation->Article->AuthorList->Author->LastName;
	//echo  $aut1lastname, ';'; //Goes to Database
	//End of first author name
	
	
	//Extracting emails from affiliation variable //create array
		$result='No emails found';
		if (!empty($affiliation))
			{
				$res = preg_match_all(
					"/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
					$affiliation,
					$matches
				);
				if ($res)
				{
					foreach(array_unique($matches[0]) as $email)
					{
						$result=$email;
					}
				}
				else
				{
						$result='No emails found';
				}
			}
		//echo '<p>', 'Email: ', '<b>',$result, '</b>', '</p>'; //Goes to Database

	//End of email extract part
	
	//Second author name
	$numar=count($PubmedArticle->MedlineCitation->Article->AuthorList->Author)- 1;
	$aut2firstname=$PubmedArticle->MedlineCitation->Article->AuthorList->Author[$numar]->ForeName;
	//echo ' Last author name: ',$aut2firstname, ' '; //Goes to Database
	
	$aut2lastname=$PubmedArticle->MedlineCitation->Article->AuthorList->Author[$numar]->LastName;
	//echo  $aut2lastname, '<br>'; //Goes to Database
	//End of second author name
	
	//Splitting Affiliation into many parts;
	
	$resultdep='No department';
	$resultcollege='No college';
	$resultuniv='No university';
	$resultinst='No institute';
	$resultschool='No school';
	
	$possib = explode(',', $affiliation);
	foreach ($possib as $tst) {
		$deppos=strpos($tst, 'Department');
		if ($deppos >0){
			$resultdep=$tst;
			}
		}
	//echo '<h3>', $resultdep, '</h3>'; //Department Goes to Database
	
	$possib = explode(',', $affiliation);
	foreach ($possib as $tst) {
		$deppos=strpos($tst, 'College');
		if ($deppos >0){
			$resultcollege=$tst;
			}
		}
	//echo '<h3>', $resultcollege, '</h3>'; //College Goes to Database
	
	
	$possib = explode(',', $affiliation);
	foreach ($possib as $tst) {
		$deppos=strpos($tst, 'Univ');
		if ($deppos >0){
			$resultuniv=$tst;
			}
		}
	//echo '<h3>', $resultuniv, '</h3>'; //University Goes to Database
	
	$possib = explode(',', $affiliation);
	foreach ($possib as $tst) {
		$deppos=strpos($tst, 'Institut');
		if ($deppos >0){
			$resultinst=$tst;
			}
		}
	//echo '<h3>', $resultinst, '</h3>'; //Institute Goes to Database
	
	
	$possib = explode(',', $affiliation);
	foreach ($possib as $tst) {
   
	$deppos=strpos($tst, 'School');
	if ($deppos >0){
		$resultschool=$tst;
		}
	}
	//echo '<h3>', $resultschool, '</h3>'; //School Goes to Database
	
	//End of splitting
	
	//Country
	include 'country.php';
	
	$cntry = explode(',', $affiliation);
	$resultcountry='No country given';
	foreach ($cntry as $checkif){ 
			foreach ($countryList as $country) {
					$deppos=strpos($checkif, $country);
					if ($deppos >0){
					$resultcountry=$country;
					}
			}
	}
	//echo '<b>', 'Country: ','</b>',$resultcountry; //Goes to Database

	//End of country
	
	//City
	$cityaff=str_replace($result, '', $affiliation);
	$cityarray=explode(',', $affiliation);
	$cityarr=array_pop($cityarray);
	
	if (($resultcountry == 'USA') or ($resultcountry == 'Canada') or ($resultcountry == 'Australia')) {
		$countrypop=array_pop($cityarray);
		}
	
	$resultcity=array_pop($cityarray); //Goes to Database
	$patern='/[^a-zA-Z_]/';
	$resultcity=preg_replace($patern,'',$resultcity);
	//echo '<br><b> City: </b>', $resultcity;
	//End of city
	
	//Journal
	$journal=$PubmedArticle->MedlineCitation->Article->Journal->Title; 
	$journalyear=$PubmedArticle->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year;
	//echo '<br> <b> Journal: </b>', $journal; //goes to database;
	//echo '<br> <b> Year: </b>', $journalyear; //goes to database;
	
	//End of Journal
	
	//PMID
	
	$pmid=$PubmedArticle->MedlineCitation->PMID; //Goes to database
	//echo '<br><strong>URL: </strong> <a href="http://www.ncbi.nlm.nih.gov/pubmed/',$pmid,'">Go to article</a>';
	
	//End of PMID
	
	//Write variables to database;
	
	$abstracts=preg_replace("/[^0-9a-zA-Z ,-]/", "", $abstractbackup);
	$affiliation=preg_replace("/[^0-9a-zA-Z ,-]/", "", $affiliation);
	$articletitle=preg_replace("/[^0-9a-zA-Z ,-]/", "", $articletitle);
	
	if (/*$result!=='No emails found' &&*/ $relevance>0){
		$dbc = mysqli_connect('localhost', 'xmltest', 'kluivert', 'testxml')
			or die('Error establishing connection');
		$articletitle=mysql_real_escape_string($articletitle);	
		$abstractsafe=mysql_real_escape_string($abstract);
		$affiliation=mysql_real_escape_string($affiliation);
		$aut1firstname=mysql_real_escape_string($aut1firstname);
		$aut1lastname=mysql_real_escape_string($aut1lastname);
		$result=mysql_real_escape_string($result);
		$resultcity=mysql_real_escape_string($resultcity);
		$country=mysql_real_escape_string($country);
		$journalsafe=mysql_real_escape_string($journal);
		$keyword=mysql_real_escape_string($keyword);
		$query = "insert into playground(articletitle, abtsract, pubdate, affiliation, aut1firstname, aut1lastname, aut1email, city, country, journal, relevance, keywords, journalyear, pmid, aut2firstname, aut2lastname, searchquery, data)" .
		"values('$articletitle','$abstracts', '$pubdate', '$affiliation', '$aut1firstname', '$aut1lastname', '$result', '$resultcity', '$resultcountry', '$journal', '$relevance', '$keyword', '$journalyear', '$pmid', '$aut2firstname', '$aut2lastname', '$searchquery', '$date')";
		$dbcwrite = mysqli_query($dbc, $query)
			or die('<h1>what the fuck is wrong with it</h1>'); 

	}

	}
?>

<div id="wrapper1">
	<h2>Your file was processed succesfully. You may now view the results</h2>
	<a href="/playground">Main page</a>
</div>