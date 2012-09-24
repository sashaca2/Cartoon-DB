<html>
<head>
<title>Update Cartoon Database</title>
</head>

<body>
<h2>Add New Cartoon to Database</h2>
<p><em>On this form you can select which cartoonist "drew" your cartoon, what date it was published, and what the caption was.</em></p>
<p><em>You can also create as many new characters as you want, select existing characters from previous cartoon entries or any combination thereof.</em></p>
<p><em>This is populating a dummy database so do not fear, it will not alter my real data. This is also an ongoing form.</em></p>
<p>COMING SOON: Themes, Events, and Keywords!</p>
<p>* required</p>
<form method="post" action="updatedev.php">

<?php include 'connect-db.php'?>

<?php
echo "<br />";
$artistq = "SELECT artist_no, f_name, l_name, paper FROM cartoonists";

	$artistr = mysql_query($artistq) or die(mysql_error());
		echo "Select Cartoonist: *<br />";
	$artistdd = "<select name='artist' size='4'>";
		while($row = mysql_fetch_assoc($artistr)) 
		{$artistdd .="\r\n<option value='{$row['artist_no']}'>{$row['f_name']} {$row['l_name']}: {$row['paper']}</option>";
		}
	$artistdd .= "\r\n</select>";
echo $artistdd;
echo "<br />";
?>
<br />Enter Cartoon Publication Date: <em>(mm/dd/yyyy)</em> *
<input type="text" name="pub_date" size="10" /><br />

<br />Enter Caption for Cartoon: *<br />
<textarea  name='caption' cols=50 rows=4></textarea>

<br /></br />Add New Character(s): <em>use comma ', ' for multiple entries</em><br />
<input type="text" name="new_actors" size="50"/><br />

<br />and/or Choose Character(s): <em>command or control for multiple entries</em></br />
<select name="actors[]" multiple="yes" size="10">
<option value="empty">  --- </option>
<?php 
$actorq = "SELECT actor_no, actor FROM characters ORDER BY actor asc";

	$actorr = mysql_query($actorq) or die(mysql_error());

	while($row = mysql_fetch_assoc($actorr)) {
		echo "<option value='{$row['actor_no']}'>{$row['actor']}</option>";
		}
?>
</select></br />

</br />Add New Event:<br />
<input type="text" name="new_event" size="50"/><br />

<br />or Choose Event:</br />
<select name="event" size="10">
<option value="">  --- </option>
<?php 
$eventq = "SELECT event_no, event FROM events ORDER BY event asc";

	$eventr = mysql_query($eventq) or die(mysql_error());

	while($row = mysql_fetch_assoc($eventr)) {
		echo "<option value='{$row['event_no']}'>{$row['event']}</option>";
		}
?>
</select></br />

</br />Add New Theme:<br />
<input type="text" name="new_theme" size="50"/><br />

<br />or Choose Theme:</br />
<select name="theme" size="10">
<option value="">  --- </option>
<?php 
$themeq = "SELECT theme_no, theme FROM themes ORDER BY theme asc";

	$themer = mysql_query($themeq) or die(mysql_error());

	while($row = mysql_fetch_assoc($themer)) {
		echo "<option value='{$row['theme_no']}'>{$row['theme']}</option>";
		}
?>
</select></br />

<br /></br />Add New Keywords(s): <em>use comma ', ' for multiple entries</em><br />
<input type="text" name="new_keywords" size="50"/><br />

<br />and/or Choose Keywords(s): <em>command or control for multiple entries</em></br />
<select name="keywords[]" multiple="yes" size="10">
<option value="empty">  --- </option>
<?php 
$keywordq = "SELECT keyw_no, keyword FROM keywords ORDER BY keyword asc";

	$keywordr = mysql_query($keywordq) or die(mysql_error());

	while($row = mysql_fetch_assoc($keywordr)) {
		echo "<option value='{$row['keyw_no']}'>{$row['keyword']}</option>";
		}
?>
</select></br />

<br /><input type='submit' value='SUBMIT'/><br />
<br />
* required
</form>
<br /><a href="viewcartoons.php">Edit Database</a>
<br /><a href="https://github.com/sashaca2/Cartoon-DB">See the Code</a>
<br /><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a>

</body>
</html>