<?php 
include('connect-real-db.php');
                                        
echo "<div class='heading'><h2>Search</h2></div>";

echo "<form method='get' action='DissSearchResults.php'>";

echo "<div id='leftside'>";
echo "<p>Choose Character</p>";
	$characters = mysql_query("SELECT * FROM characters ORDER BY actor asc");
		echo "<select name='actors'>";
			while ($row = mysql_fetch_array($characters)) {
				echo "<option value="; 
					echo $row['actor_no']; 
    			echo ">";
        			echo $row['actor'];
    			echo "</option>";
    		}
		echo "</select>";
echo "</div>";

echo "<div id='rightside'>";
echo "<p>Choose Keyword</p>";
	$keyword = mysql_query("SELECT * FROM keywords ORDER BY keyword asc");
		echo "<select name='keywords'>";
			while ($row = mysql_fetch_array($keyword)) {
				echo "<option value="; 
					echo $row['keyw_no']; 
    			echo ">";
        			echo $row['keyword'];
    			echo "</option>";
    		}
		echo "</select>";
echo "</div>";

echo "<div class='clearfloat'></div>";
echo "<br />";
echo "<br /><input type='submit' value='Submit' />"; 
echo "<br />";

echo "</form>";
echo "<br />";

?>