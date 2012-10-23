<html>
<head>  
<title>View Cartoon Meta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php $id = $_GET['toon_no']; 
// connect to the database
        include("connect-db.php");
?>

<?php
$recent_cartoon = "SELECT * FROM cartoons WHERE toon_no=" .$id; 
	 
$cartoon_result = mysql_query($recent_cartoon) or die('Error getting query');

$row = mysql_fetch_array($cartoon_result) or die('Error returning array');
?>

<h2>Artist ID Key</h2>
<table border="1">
  <tr>
    <th>Herblock</th><th>Conrad-Denver</th><th>Conrad-LA</th><th>Miller</th>
  </tr>
  <tr>
    <td>1</td><td>2</td><td>3</td><td>4</td>
  </tr>
</table>


<h2>Cartoon Metadata:</h2>

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
."WHERE cartoon_characters.fk_toon_no = " .$id
." HAVING cartoon_characters.fk_actor_no = characters.actor_no";

$recent_event = "SELECT cartoon_events.fk_toon_no, cartoon_events.fk_event_no, events.event_no, events.event "
."FROM cartoon_events, events "
."WHERE cartoon_events.fk_toon_no = " .$id
." HAVING cartoon_events.fk_event_no = events.event_no";

$recent_theme = "SELECT cartoon_themes.fk_toon_no, cartoon_themes.fk_theme_no, themes.theme_no, themes.theme "
."FROM cartoon_themes, themes "
."WHERE cartoon_themes.fk_toon_no = " .$id
." HAVING cartoon_themes.fk_theme_no = themes.theme_no";

$recent_keyword = "SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
."FROM cartoon_keywords, keywords "
."WHERE cartoon_keywords.fk_toon_no = " .$id
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
<form method="POST" action="">
<br /><input name="submit" type="submit" value="Delete Record" />
</form>

<?php
$id=$_GET['toon_no'];
if (isset($_POST['submit'])) {
    $delete_keyword="DELETE FROM cartoon_keywords WHERE fk_toon_no=".$id;
        mysql_query($delete_keyword) or die('Error deleting joiner table');
    $delete_theme="DELETE FROM cartoon_themes WHERE fk_toon_no=".$id;
        mysql_query($delete_theme) or die('Error deleting joiner table');
    $delete_event="DELETE FROM cartoon_events WHERE fk_toon_no=".$id;
        mysql_query($delete_event) or die('Error deleting joiner table');
    $delete_actor="DELETE FROM cartoon_characters WHERE fk_toon_no=".$id;
        mysql_query($delete_actor) or die('Error deleting joiner table');
    $delete_cartoon="DELETE FROM cartoons WHERE toon_no=".$id;
        mysql_query($delete_cartoon) or die('Error deleting joiner table');
    header("Location: viewcartoons.php");
}
?>
<p><a href="newForm.php">Add New Record</a></p>
<p><a href="viewcartoons.php">Return to Cartoons</a></p>
<p><a href="https://github.com/sashaca2/Cartoon-DB">See the Code</a></p>
<p><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a></p>
</body>
</html>