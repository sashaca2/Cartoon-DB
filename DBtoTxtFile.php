<?php
$hostname = "localhost";   // eg. mysql.yourdomain.com (unique)
$username = "root";   // the username specified when setting-up the database
$password = "root";   // the password specified when setting-up the database
$database = "NuclearCartoons";   // the database name chosen when setting-up the database (unique)

$link = mysql_connect($hostname,$username,$password);
mysql_select_db($database) or die("Unable to select database");

$id=1;

while ($id<=110) {
echo "<br />";
print_r($id);
echo "<br />";
	$date_query = "SELECT p_date FROM cartoons WHERE toon_no = " .$id;
		$date_result = mysql_query($date_query);
			$row = mysql_fetch_assoc($date_result);
				$pub_date=$row['p_date'];
					$pub_date=explode('-', $pub_date);
                    	$titleDate = $pub_date[1].'-'.$pub_date[2].'-'.$pub_date[0];
print_r($titleDate);
echo "<br />";
//	$myFile = $titleDate .".txt";
//	$fh = fopen($myFile, 'w') or die("Can't open file");
		$keyword_query = "SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
			."FROM cartoon_keywords, keywords "
			."WHERE cartoon_keywords.fk_toon_no = " .$id
			." HAVING cartoon_keywords.fk_keyw_no = keywords.keyw_no
			ORDER BY keyword asc";
		$keyword_result = mysql_query($keyword_query);
			while ($row = mysql_fetch_assoc($keyword_result)) {
				$keyword_array[] = $row['keyword'];
			}
print_r($keyword_array);
/*		foreach ($keyword_array as $element) {
			fwrite($fh, $element ."\n");
		}
	fclose($fh);
*/
	$id++;
}

?>