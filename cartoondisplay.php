<html>
<head>
</head>
<body>
<?php

mysql_connect ("localhost", "root", "root") or die('Error: . . .');
//echo "Connected to server <br />";
mysql_select_db ("dissertation");
//echo "Connected to database <br />";
echo "<br />";
?>

<?php include("functions.php"); ?>
<p>Attempt at combining MySQL queries</p>
<?php 
$recent_char = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, characters.actor_no, characters.actor, cartoon_events.fk_toon_no, cartoon_events.fk_event_no, events.event_no, events.event "
."FROM cartoon_characters, characters, cartoon_events, events "
."WHERE cartoon_characters.fk_toon_no = 67 " 
."AND cartoon_events.fk_toon_no = 67 " 
."HAVING cartoon_characters.fk_actor_no = characters.actor_no "
."AND cartoon_events.fk_event_no = events.event_no";


if ( ($recent_char_result=mysql_query($recent_char)) ) {

?>

<br />
<table border='1'>
	<tr>
    	<th>Cartoon ID</th>
    	<th>Actor ID</th>
    	<th>Actor(s)</th>
    	<th>Event ID</th>
    	<th>Event</th>
  	</tr>
<?php while (($row=mysql_fetch_array($recent_char_result)) ) { ?>
	<tr>
		<td><?php echo $row['fk_toon_no'];?></td>
		<td><?php echo $row['fk_actor_no'];?></td>
		<td><?php echo $row['actor'];?></td>
		<td><?php echo $row['fk_event_no'];?></td>
		<td><?php echo $row['event'];?></td>
	</tr>
<?php 
} // closes while loop 
} // closes if statement
?>
</table>
<br />
<p>Problem: It's repeating the Event for each character line</p>
<br />
<?php
$recent_theme = ("SELECT cartoon_themes.fk_toon_no, cartoon_themes.fk_theme_no, themes.theme_no, themes.theme "
."FROM cartoon_themes, themes "
."WHERE cartoon_themes.fk_toon_no = 67" 
." HAVING cartoon_themes.fk_theme_no = themes.theme_no");
$recent_theme_result=mysql_query($recent_theme);

$recent_keyword = ("SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
."FROM cartoon_keywords, keywords "
."WHERE cartoon_keywords.fk_toon_no = 67" 
." HAVING cartoon_keywords.fk_keyw_no = keywords.keyw_no");
$recent_keyword_result=mysql_query($recent_keyword);


?>
<p>Attempt: Combining two arrays into one</p>

<table border='1'>
	<tr>
	   	<th>Theme ID</th>
    	<th>Theme</th>
    	<th>Keyword ID</th>
    	<th>Keyword(s)</th>
  	</tr>
<?php while ($line = array_merge(mysql_fetch_array($recent_theme_result), $row=mysql_fetch_array($recent_keyword_result))) { ?>
	<tr>
		<td><?php echo $line['fk_theme_no'];?></td>
		<td><?php echo $line['theme'];?></td>
		<td><?php echo $line['fk_keyw_no'];?></td>
		<td><?php echo $line['keyword'];?></td>
	</tr>
<?php 
} // closes while loop 


 ?>
</table>
<p>Problem: There are more than one keyword</p>
</body>
</html>