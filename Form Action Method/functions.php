<?php

//Function that adds new character to actor table and new character and new cartoon to joiner table
function new_char_table(){
	global $new_toon_id;
	$char_to_add=mysql_real_escape_string($_POST['new_actors']);
	$new_char_arr = explode(', ', $char_to_add);
		foreach ($new_char_arr as $new_char_add) 
		{
			if (!empty($new_char_add)) 
			{
				$new_char = "INSERT INTO characters (actor_no, actor) VALUES ('NULL', '".$new_char_add."')";
						mysql_query($new_char) or die('Error adding new character');

				$new_char_id = mysql_insert_id();
//					echo "<br />New character - " .$new_char_add ." (" .$new_char_id .") successfully added to CHARACTERS table<br />";
		
				$new_cartoon_actor = "INSERT INTO cartoon_characters (fk_toon_no, fk_actor_no) VALUES 
     						('".$new_toon_id."', '".$new_char_id."')"; 
						mysql_query($new_cartoon_actor) or die('Error updating cartoon_characters table with new actor');
//					echo "<br />New cartoon (" .$new_toon_id .") and new character (" .$new_char_id .") successfully added to CARTOON_CHARACTERS table<br />";
//			} else
//			{
//				echo "<br />No New Character Added to Database or Joining Table<br />";
			}
		}
}

// Function that puts existing elements into joiner table with new cartoon
function join_table($table_name, $table_field, $arr_element) { 
	global $new_toon_id;
	$existing_element = "INSERT INTO " .$table_name ." (fk_toon_no, " .$table_field .") VALUES
				  (".$new_toon_id.", ".$arr_element.")";
						  mysql_query($existing_element) or die('Error updating joiner table');
		  
} //ends function

// Function that adds new event to event table and new event and new cartoon to joiner table
// or if no new event checks if existing event selected and runs join_table function
function all_event_tables(){
	global $new_toon_id;
	$new_event_add=mysql_real_escape_string($_POST['new_event']);
	$cartoon_event=$_POST['event'];
		if (!empty($new_event_add)){
				$new_event = "INSERT INTO events (event_no, event) VALUES ('NULL', '".$new_event_add."')";
							mysql_query($new_event) or die('Error adding new event');

				$new_event_id = mysql_insert_id();
//					echo "<br />New event - " .$new_event_add ." (" .$new_event_id .") successfully added to EVENTS table<br />";
		
				$new_cartoon_event = "INSERT INTO cartoon_events (fk_toon_no, fk_event_no) VALUES 
     							('".$new_toon_id."', '".$new_event_id."')"; 
						mysql_query($new_cartoon_event) or die('Error updating cartoon_events table with new event');
//					echo "<br />New cartoon (" .$new_toon_id .") and new event (" .$new_event_id .") successfully added to CARTOON_EVENTS table<br />";	
		} elseif ($cartoon_event >= 1) {
	  			join_table('cartoon_events', 'fk_event_no', $cartoon_event);
//	  			echo "<br />New cartoon (" .$new_toon_id .") and existing event (" .$cartoon_event .") successfully added<br />";
		} else {
				echo "<br />No Events Joined to Cartoon<br />";
		}
} //ends function

// Function that adds new theme to themes table and new theme and new cartoon to joiner table
// or if no new theme checks if existing theme selected and runs join_table function
function all_theme_tables(){
	global $new_toon_id;
	$new_theme_add=mysql_real_escape_string($_POST['new_theme']);
	$cartoon_theme=$_POST['theme'];
		if (!empty($new_theme_add)){
				$new_theme = "INSERT INTO themes (theme_no, theme) VALUES ('NULL', '".$new_theme_add."')";
							mysql_query($new_theme) or die('Error adding new theme');

				$new_theme_id = mysql_insert_id();
//					echo "<br />New theme - " .$new_theme_add ." (" .$new_theme_id .") successfully added to THEMES table<br />";
		
				$new_cartoon_theme = "INSERT INTO cartoon_themes (fk_toon_no, fk_theme_no) VALUES 
     							('".$new_toon_id."', '".$new_theme_id."')"; 
						mysql_query($new_cartoon_theme) or die('Error updating cartoon_themes table with new theme');
//					echo "<br />New cartoon (" .$new_toon_id .") and new theme (" .$new_theme_id .") successfully added to CARTOON_THEMES table<br />";	
		} elseif ($cartoon_theme >= 1) {
	  			join_table('cartoon_themes', 'fk_theme_no', $cartoon_theme);
//	  			echo "<br />New cartoon (" .$new_toon_id .") and existing theme (" .$cartoon_theme .") successfully added to CARTOON_THEMES table<br />";
		} else {
				echo "<br />No Themes Joined to Cartoon<br />";
		}
} //ends function

//Function that adds new keyword to keywords table and new keyword and new cartoon to joiner table
function new_keyword_table(){
	global $new_toon_id;
	$keyword_to_add=mysql_real_escape_string($_POST['new_keywords']);
	$new_keyword_arr = explode(', ', $keyword_to_add);
		foreach ($new_keyword_arr as $new_keyword_add) 
		{
			if (!empty($new_keyword_add)) 
			{
				$new_keyword = "INSERT INTO keywords (keyw_no, keyword) VALUES ('NULL', '".$new_keyword_add."')";
						mysql_query($new_keyword) or die('Error adding new keyword');

				$new_keyword_id = mysql_insert_id();
//					echo "<br />New keyword - " .$new_keyword_add ." (" .$new_keyword_id .") successfully added to KEYWORDS table<br />";
		
				$new_cartoon_keyword = "INSERT INTO cartoon_keywords (fk_toon_no, fk_keyw_no) VALUES 
     						('".$new_toon_id."', '".$new_keyword_id."')"; 
						mysql_query($new_cartoon_keyword) or die('Error updating cartoon_keywords table with new keyword');
//					echo "<br />New cartoon (" .$new_toon_id .") and new keyword (" .$new_keyword_id .") successfully added to CARTOON_KEYWORDS table<br />";
//			} else
//			{
//				echo "<br />No New Keyword Added to Database or Joining Table<br />";
			}
		}
}

function display_meta($new_toon_id) {
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
<?php } // closes function 
