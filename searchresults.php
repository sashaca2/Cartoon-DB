<?php 
include('connect-real-db.php');

/*foreach($_GET['actors'] as $actor) {
		echo $actor."\n";
}
*/
$actors=$_GET['actors'];
$keywords=$_GET['keywords'];

$headerq1= "SELECT * FROM characters WHERE actor_no=".$actors;
$q1_result=mysql_query($headerq1);
$row=mysql_fetch_array($q1_result);
$header_actor=$row['actor'];
$headerq2="SELECT * FROM keywords WHERE keyw_no=".$keywords;
$q2_result=mysql_query($headerq2);
$row=mysql_fetch_array($q2_result);
$header_keyword=$row['keyword'];

echo "<div class='heading'><h2>All Cartoons With: </h2></div> <br /><h3>Character: " .$header_actor ." and Keyword: " .$header_keyword ."</h3>";

$query = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no "
."FROM cartoon_characters, cartoon_keywords "
."WHERE cartoon_characters.fk_actor_no=" .$actors
." AND cartoon_keywords.fk_keyw_no=" .$keywords
." HAVING cartoon_characters.fk_toon_no=cartoon_keywords.fk_toon_no";


/*
$query = "SELECT * FROM cartoon_characters WHERE fk_actor_no=" .$actors;
*/
$result=mysql_query($query);
while($q1=  mysql_fetch_assoc($result)){    
	$array2[]= $q1['fk_toon_no'];
}

//print_r($array2);

if (!empty($array2)) {
	echo "<table border='1' cellpadding='10'>";
	echo "<tr><th>ID</th><th>Artist ID</th><th>Pub Date</th><th>Caption</th><th>Description</th><th>View Toon Meta</th></tr>";
	foreach ($array2 as $element) {
		$query2 = "SELECT * FROM cartoons WHERE toon_no=" .$element;
		$result2 = mysql_query($query2);
			while ($row=mysql_fetch_array($result2)) {
					$p_date=$row['p_date'];
						$pub_date=explode('-', $p_date);
						$mysqlPDate = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];
				echo "<tr>";
				echo "<td>" . $row['toon_no'] . "</td>";
				echo "<td>" . $row['fk_artist_no'] . "</td>";
				echo "<td>" . $mysqlPDate . "</td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td>" . $row['description'] . "</td>";
				echo "<td><a href='DissCartoonMeta.php?toon_no=" . $row['toon_no'] . "'>View Toon Meta</a></td>";
				echo "</tr>";	
			}
	}
	echo "</table>";
}

?>

