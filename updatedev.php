<html>
<head>
<title>Updated Cartoon Database</title>
</head>

<body>

<?php include ("connect-db.php"); ?>

<?php include("functions.php"); ?>

<?php
// This section of code is validating that all required fields are populated and if they are
// It is generating a new cartoon entry and creating/getting it's primary key
		$artist_id =mysql_real_escape_string($_POST['artist']);
		$caption =mysql_real_escape_string($_POST['caption']);
		$date =$_POST['pub_date'];
			
if ($caption == "") {
		die('Error you must add a caption<br /><a href="http://www.digitalpraxis.sashahoffman.org/formdev.php">Return to entry form</a>');
}

if ($date == "") {
	die('Error you must add a date<br /><a href="http://www.digitalpraxis.sashahoffman.org/formdev.php">Return to entry form</a>');
} else {
		$date=explode('/', $date);
		$mysqlPDate = $date[2].'-'.$date[0].'-'.$date[1];
}

if ($artist_id == 0) {
		die('Error you must select a cartoonist<br /><a href="http://www.digitalpraxis.sashahoffman.org/formdev.php">Return to entry form</a>');
	} elseif ($artist_id >= 1) {
		$new_toon = "INSERT INTO cartoons (toon_no, fk_artist_no, p_date, title) 
			VALUES ('NULL', '".$artist_id."', '".$mysqlPDate."', '".$caption."')";
				mysql_query($new_toon) or die('Error adding new cartoon ');

		$new_toon_id = mysql_insert_id();
//		echo "<br />Cartoon (" .$new_toon_id .") with the caption - \"" .$caption ."\" - successfully added to CARTOONS table<br />";
	} else {
		die('Error you must add a new cartoon<br /><a href="http://www.digitalpraxis.sashahoffman.org/formdev.php">Return to entry form</a>');
} ?>

<?php new_char_table(); ?>

<?php
// This code creates array of existing characters and function puts those values into joiner table with new cartoon 
$cartoon_actors=($_POST['actors']);

foreach($cartoon_actors as $cartoon_actor) {
  	if ($cartoon_actor >= 1) { 
  	join_table('cartoon_characters', 'fk_actor_no', $cartoon_actor);
//  	echo "<br />New cartoon (" .$new_toon_id .") and existing character (" .$cartoon_actor .") successfully added to CARTOON_CHARATERS table<br />";
//	} else {
//	  echo "<br />No Existing Character Added to Joining Table<br />";
	}
} ?>

<?php all_event_tables(); ?>

<?php all_theme_tables(); ?>

<?php new_keyword_table(); ?>

<?php
// This code creates array of existing keywords and function puts those values into joiner table with new cartoon 
$cartoon_keywords=($_POST['keywords']);

foreach($cartoon_keywords as $cartoon_keyword) {
  	if ($cartoon_keyword >= 1) { 
  	join_table('cartoon_keywords', 'fk_keyw_no', $cartoon_keyword);
//  	echo "<br />New cartoon (" .$new_toon_id .") and existing keyword (" .$cartoon_keyword .") successfully added to CARTOON_KEYWORDS table<br />";
//	} else {
//	  echo "<br />No Existing Keyword Added to Joining Table<br />";
	}
} ?>

<?php
$recent_cartoon = "SELECT * FROM cartoons WHERE toon_no=" .$new_toon_id; 
	 
$cartoon_result = mysql_query($recent_cartoon) or die('Error getting query');


$row = mysql_fetch_array($cartoon_result) or die('Error returning array');
//echo "<br />";
//echo $row['toon_no']. " - ". $row['fk_artist_no']. " - ". $row['p_date']. " - ". $row['title'];
?>

<br />
Artist ID Key
<table border="1">
  <tr>
    <th>Herblock</th><th>Conrad-Denver</th><th>Conrad-LA</th><th>Miller</th>
  </tr>
  <tr>
    <td>1</td><td>2</td><td>3</td><td>4</td>
  </tr>
</table>

<br />
<p>You Have Successfully Entered the Following Cartoon & Metadata:</p>
<br />

<table border="1">
  <tr>
    <th>Cartoon ID</th><th>Artist ID</th><th>Pub Date</th><th>Caption</th>
  </tr>
  <tr>
    <td><?php echo $row['toon_no'];?></td>
    <td><?php echo $row['fk_artist_no'];?></td>
    <td><?php echo $row['p_date'];?></td>
    <td><?php echo $row['title'];?></td>
  </tr>
</table>

<?php 
$recent_char = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, characters.actor_no, characters.actor "
."FROM cartoon_characters, characters "
."WHERE cartoon_characters.fk_toon_no = " .$new_toon_id
." HAVING cartoon_characters.fk_actor_no = characters.actor_no";

$recent_event = "SELECT cartoon_events.fk_toon_no, cartoon_events.fk_event_no, events.event_no, events.event "
."FROM cartoon_events, events "
."WHERE cartoon_events.fk_toon_no = " .$new_toon_id
." HAVING cartoon_events.fk_event_no = events.event_no";

$recent_theme = "SELECT cartoon_themes.fk_toon_no, cartoon_themes.fk_theme_no, themes.theme_no, themes.theme "
."FROM cartoon_themes, themes "
."WHERE cartoon_themes.fk_toon_no = " .$new_toon_id
." HAVING cartoon_themes.fk_theme_no = themes.theme_no";

$recent_keyword = "SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
."FROM cartoon_keywords, keywords "
."WHERE cartoon_keywords.fk_toon_no = " .$new_toon_id
." HAVING cartoon_keywords.fk_keyw_no = keywords.keyw_no";

if ( ($recent_char_result=mysql_query($recent_char)) && ($recent_event_result=mysql_query($recent_event)) && ($recent_theme_result=mysql_query($recent_theme)) && ($recent_keyword_result=mysql_query($recent_keyword)) ) {

?>

<br />
<table border='1'>
	<tr>
    	<th>Cartoon ID</th>
    	<th>Actor ID</th>
    	<th>Actor(s)</th>
    	<th>Event ID</th>
    	<th>Event</th>
    	<th>Theme ID</th>
    	<th>Theme</th>
    	<th>Keyword ID</th>
    	<th>Keyword(s)</th>
  	</tr>
<?php while (($row=mysql_fetch_array($recent_char_result)) || ($row=mysql_fetch_array($recent_event_result)) || ($row=mysql_fetch_array($recent_theme_result)) || ($row=mysql_fetch_array($recent_keyword_result))) { ?>
	<tr>
		<td><?php echo $row['fk_toon_no'];?></td>
		<td><?php echo $row['fk_actor_no'];?></td>
		<td><?php echo $row['actor'];?></td>
		<td><?php echo $row['fk_event_no'];?></td>
		<td><?php echo $row['event'];?></td>
		<td><?php echo $row['fk_theme_no'];?></td>
		<td><?php echo $row['theme'];?></td>
		<td><?php echo $row['fk_keyw_no'];?></td>
		<td><?php echo $row['keyword'];?></td>
	</tr>
<?php 
} // closes while loop 
} // closes if statement
?>
</table>

<?php 
// Everything below this creates just one table from one query for one category of metadata
// Would have to repeat and have 4 separate tables if used this method

/* $recent_char = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, characters.actor_no, characters.actor "
."FROM cartoon_characters, characters "
."WHERE cartoon_characters.fk_toon_no = " .$new_toon_id
." HAVING cartoon_characters.fk_actor_no = characters.actor_no";

$recent_char_result = mysql_query($recent_char) or die(mysql_error());

*/?>


<!-- <br /><table border='1'><tr>
    <th>Cartoon ID</th>
    <th>Actor ID</th>
    <th>Actor</th>
  </tr> -->
<?php /* while($row = mysql_fetch_array($recent_char_result)){ */ ?>
<!-- <tr>
<td><?php echo $row['fk_toon_no'];?></td>
<td><?php echo $row['fk_actor_no'];?></td>
<td><?php echo $row['actor'];?></td>
</tr> -->
<?php
// } 
?>
<!-- </table> -->


<br /><a href="http://www.digitalpraxis.sashahoffman.org/formdev.php">Return to entry form</a>

<br /><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a>

<br /><a href="https://gist.github.com/3735366">See the Code</a>

</body>
</html>