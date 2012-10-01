<?php
// Allows the user to both create new records and edit existing records

// connect to the database
include("connect-db.php");

function renderForm($artist_id = '', $pub_date ='', $caption = '', $id = '', $error = '', $actor_id = '', $events_id ='', $themes_id = '', $keywords_id = '') { ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>  
    <title><?php if ($id != '') { echo "Edit Cartoon"; } else { echo "New Record"; } ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
                
    <h1><?php if ($id != '') { echo "Edit Cartoon"; } else { echo "New Record"; } ?></h1>
        <?php if ($error != '') {
            echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error. "</div>";
        } ?>
                                
    <form action="" method="post">
        <div>
            <?php if ($id != '') { ?>
                <input type="hidden" name="toon_no" value="<?php echo $id; ?>" />
                    <p>Cartoon ID: <?php echo $id; ?></p>
            <?php } ?>
                    
                    <p>Select Cartoonist: *</p>
                        <?php $artists = mysql_query("SELECT * FROM cartoonists"); ?>
                        <select name='fk_artist_no'>
                            <?php while ($row = mysql_fetch_array($artists)) { ?>
                                <option value="<?php echo $row['artist_no']; ?>"<?php if ($artist_id == $row['artist_no']) { echo 'selected'; } ?>>
                                    <?php echo $row['f_name'] ." " .$row['l_name'] .": " ,$row['paper']; ?>
                                </option>
                            <?php } ?>
                        </select>
                
                    <p>Enter Cartoon Publication Date: <em>(mm/dd/yyyy)</em> *
                        <input type="text" name="p_date" size="10" value="<?php echo $pub_date; ?>"/></p>

                    <p>Enter Caption for Cartoon: *</p>
                        <textarea name='title' cols=50 rows=4><?php echo $caption; ?></textarea>
                    
                    <p>Add New Character(s): <em>use comma ', ' for multiple entries</em></p>
                        <input type="text" name="new_actors" size="50"/>

                    <p>and/or Choose Character(s): <em>command or control for multiple entries</em></p>
                        <?php $characters = mysql_query("SELECT * FROM characters ORDER BY actor asc");?>
                        <select name="actors[]" multiple="yes" size="10">
                            <option value="">  --- </option>
                            <?php while ($row = mysql_fetch_array($characters)) { ?>
                                <option value="<?php echo $row['actor_no']; ?>"
                                    <?php if ($id != '') { foreach ($actor_id as $char_id) { 
                                        if ($char_id == $row['actor_no']) { 
                                        echo 'selected'; } } }?>>
                                    <?php echo $row['actor'];?>
                                </option>
                            <?php } ?>
                        </select>

                    <p>Add New Event:
                        <input type="text" name="new_event" size="50"/></p>

                    <p>or Choose an Event:
                        <?php $events = mysql_query("SELECT * FROM events ORDER BY event asc");?>
                        <select name="events">
                            <option value="">  --- </option>
                            <?php while ($row = mysql_fetch_array($events)) { ?>
                                <option value="<?php echo $row['event_no']; ?>"
                                    <?php if ($id != '') { foreach ($events_id as $event_id) { 
                                        if ($event_id == $row['event_no']) { 
                                        echo 'selected'; } } }?>>
                                    <?php echo $row['event'];?>
                                </option>
                            <?php } ?>
                        </select></p>

                    <p>Add New Theme:
                        <input type="text" name="new_theme" size="50"/></p>

                    <p>or Choose a Theme:
                        <?php $themes = mysql_query("SELECT * FROM themes ORDER BY theme asc");?>
                        <select name="themes">
                            <option value="">  --- </option>
                                <?php while ($row = mysql_fetch_array($themes)) { ?>
                                <option value="<?php echo $row['theme_no']; ?>"
                                    <?php if ($id != '') { foreach ($themes_id as $theme_id) { 
                                        if ($theme_id == $row['theme_no']) { 
                                        echo 'selected'; } } }?>>
                                    <?php echo $row['theme'];?>
                                </option>
                            <?php } ?>
                        </select></p>

                    <p>Add New Keyword(s): <em>use comma ', ' for multiple entries</em></p>
                        <input type="text" name="new_keywords" size="50"/>

                    <p>and/or Choose Keyword(s): <em>command or control for multiple entries</em></p>
                        <?php $keywords = mysql_query("SELECT * FROM keywords ORDER BY keyword asc");?>
                        <select name='keywords[]' multiple='yes' size='10'>
                            <option value=''>  --- </option>                           
                                <?php while ($row = mysql_fetch_array($keywords)) { ?>
                                <option value="<?php echo $row['keyw_no']; ?>"
                                    <?php if ($id != '') { foreach ($keywords_id as $keyword_id) { 
                                        if ($keyword_id == $row['keyw_no']) { 
                                        echo 'selected'; } } }?>>
                                    <?php echo $row['keyword'];?>
                                </option>  
                                <?php } ?>
                        </select> 

                    <br /><input type="submit" name="submit" value="Submit" />
        </div>
    </form>
    </body>
    </html>
<?php } // ends function renderForm

/*function option_select ($query, $pk_field, $array, $category_name, $id) {
    echo "<option value=''>  --- </option>"; 
    while ($row = mysql_fetch_array($query)) {
        echo "<option value =$row[$pk_field]" ;
            if ($id != '') {
                foreach ($array as $element) {
                    if ($element == $row[$pk_field]) {
                        echo "selected";
                    }
                }
            }
        echo ">";
        echo $row[$category_name];
        echo "</option>";
    }
    echo "</select>";
} // ends function
*/
function delete_meta($delete_table_name, $id) {
    $delete_meta="DELETE FROM " .$delete_table_name ." WHERE fk_toon_no=".$id;
        mysql_query($delete_meta) or die('Error deleting joiner table');
} // end function delete_meta

function new_char_table($char_to_add, $new_toon_id){
    $new_char_arr = explode(', ', $char_to_add);
        foreach ($new_char_arr as $new_char_add) {
            if (!empty($new_char_add)) {
                $new_char = "INSERT INTO characters (actor_no, actor) VALUES ('NULL', '".$new_char_add."')";
                        mysql_query($new_char) or die('Error adding new character');
                $new_char_id = mysql_insert_id();
                $new_cartoon_actor = "INSERT INTO cartoon_characters (fk_toon_no, fk_actor_no) VALUES 
                            ('".$new_toon_id."', '".$new_char_id."')"; 
                        mysql_query($new_cartoon_actor) or die('Error updating cartoon_characters table with new actor');
            }
        }
} // end function new_char_table

function join_table($join_table_name, $FK_field_name, $array_element, $new_toon_id) { 
    $existing_entry = "INSERT INTO " .$join_table_name ." (fk_toon_no, " .$FK_field_name .") VALUES
                  ('".$new_toon_id."', '".$array_element."')";
                          mysql_query($existing_entry) or die('Error updating joiner table');
} //ends function join_table

function all_event_tables($new_event, $cartoon_event, $new_toon_id) {
    if (!empty($new_event)) {
        $new_eventq = "INSERT INTO events (event_no, event) VALUES ('NULL', '".$new_event."')";
            mysql_query($new_eventq) or die('Error adding new event');
        $new_event_id = mysql_insert_id();
        $new_cartoon_event = "INSERT INTO cartoon_events (fk_toon_no, fk_event_no) VALUES ('".$new_toon_id."', '".$new_event_id."')"; 
            mysql_query($new_cartoon_event) or die('Error updating cartoon_events table with new event');
    } else {
        join_table('cartoon_events', 'fk_event_no', $cartoon_event, $new_toon_id);
    }
} //ends all_event_tables function

function all_theme_tables($new_theme, $cartoon_theme, $new_toon_id) {
    if (!empty($new_theme)){
        $new_themeq = "INSERT INTO themes (theme_no, theme) VALUES ('NULL', '".$new_theme."')";
            mysql_query($new_themeq) or die('Error adding new theme');
        $new_theme_id = mysql_insert_id();
        $new_cartoon_theme = "INSERT INTO cartoon_themes (fk_toon_no, fk_theme_no) VALUES ('".$new_toon_id."', '".$new_theme_id."')"; 
            mysql_query($new_cartoon_theme) or die('Error updating cartoon_themes table with new theme');
    } else {
        join_table('cartoon_themes', 'fk_theme_no', $cartoon_theme, $new_toon_id);
    }
} //ends all_theme_tables function

function new_keyword_table($keyword_to_add, $new_toon_id){
    $new_keyword_arr = explode(', ', $keyword_to_add);
        foreach ($new_keyword_arr as $new_keyword_add) {
            if (!empty($new_keyword_add)) {
                $new_keyword = "INSERT INTO keywords (keyw_no, keyword) VALUES ('NULL', '".$new_keyword_add."')";
                        mysql_query($new_keyword) or die('Error adding new keyword');
                $new_keyword_id = mysql_insert_id();
                $new_cartoon_keyword = "INSERT INTO cartoon_keywords (fk_toon_no, fk_keyw_no) VALUES 
                            ('".$new_toon_id."', '".$new_keyword_id."')"; 
                        mysql_query($new_cartoon_keyword) or die('Error updating cartoon_keywords table with new keyword');
            }
        }
} // ends new_keyword_table function




// EDIT RECORD
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['toon_no'])) {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
        // make sure the 'id' in the URL is valid
        if (is_numeric($_POST['toon_no'])) {
            // get variables from the URL/form
            $id = $_POST['toon_no'];
            $artist_id = $_POST['fk_artist_no'];
            $pub_date =$_POST['p_date'];
            $caption = htmlentities($_POST['title'], ENT_QUOTES);
            $new_actors = htmlentities($_POST['new_actors'], ENT_QUOTES);
            $cartoon_actors=$_POST['actors'];
            $new_event = htmlentities($_POST['new_event'], ENT_QUOTES);
            $cartoon_event=$_POST['events'];
            $new_theme = htmlentities($_POST['new_theme'], ENT_QUOTES);
            $cartoon_theme=$_POST['themes'];
            $new_keywords = htmlentities($_POST['new_keywords'], ENT_QUOTES);
            $cartoon_keywords=$_POST['keywords'];
                // check that required fields are not empty
                if ($artist_id == '' || $pub_date == '' || $caption == '') {
                    // if they are empty, show an error message and display the form
                    $error = 'ERROR: Please fill in all required fields!';
                    renderForm($artist_id, $pub_date, $caption, $error, $id);
                } else {
                        // explode date and reformat in MySQL order 
                        $pub_date=explode('/', $pub_date);
                        $mysqlPDate = $pub_date[2].'-'.$pub_date[0].'-'.$pub_date[1];          
                    // if everything is fine, update the record in the database
                    if ($stmt = $mysqli->prepare("UPDATE cartoons SET fk_artist_no = ?, p_date = ?, title = ? WHERE toon_no=?")) {
                        $stmt->bind_param("issi", $artist_id, $mysqlPDate, $caption, $id);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        // show an error message if the query has an error
                        echo "ERROR: could not prepare SQL statement.";
                    }
                    delete_meta('cartoon_characters', $id);
                    foreach($cartoon_actors as $cartoon_actor) {
                        if ($cartoon_actor>= 1) {
                            join_table('cartoon_characters', 'fk_actor_no', $cartoon_actor, $id);
                        }
                    }
                    new_char_table ($new_actors, $id);
                    delete_meta('cartoon_events', $id);
                    all_event_tables($new_event, $cartoon_event, $id);
                    delete_meta('cartoon_themes', $id);
                    all_theme_tables($new_theme, $cartoon_theme, $id);
                    delete_meta('cartoon_keywords', $id);
                    foreach($cartoon_keywords as $cartoon_keyword) {
                        if ($cartoon_keyword >= 1) {
                            join_table('cartoon_keywords', 'fk_keyw_no', $cartoon_keyword, $id);
                        }
                    }
                    new_keyword_table ($new_keywords, $id);
                }
                // redirect the user once the form is updated
                    header("Location: viewcartoons.php");
        } else {
            // if the 'id' variable is not valid, show an error message
            echo "Error!";
        }
    }
    
    // if the form hasn't been submitted yet, get the info from the database and show the form
    else {
        // make sure the 'id' value is valid
        if (is_numeric($_GET['toon_no']) && $_GET['toon_no'] > 0) {
            // get 'id' from URL
            $id = $_GET['toon_no'];
                // get the record from the database
                if($stmt = $mysqli->prepare("SELECT * FROM cartoons WHERE toon_no=?")) {               
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($id, $artist_id, $pub_date, $caption);
                    $stmt->fetch();
                        $pub_date=explode('-', $pub_date);
                        $p_date = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];                 
                    $stmt->close();
                }
                // this creates an array of all the selected characters to pass to the form in a variable
                $actor_query = "SELECT * FROM cartoon_characters WHERE fk_toon_no=".$id;
                    $actor_array = mysql_query($actor_query);
                        while ($row = mysql_fetch_assoc($actor_array)) {
                            $actor_id[] = $row['fk_actor_no'];
                        }
                $event_query = "SELECT * FROM cartoon_events WHERE fk_toon_no=".$id;
                    $event_array = mysql_query($event_query);
                        while ($row = mysql_fetch_assoc($event_array)) {
                            $events_id[] = $row['fk_event_no'];
                        }
                $theme_query = "SELECT * FROM cartoon_themes WHERE fk_toon_no=".$id;
                    $theme_array = mysql_query($theme_query);
                        while ($row = mysql_fetch_assoc($theme_array)) {
                            $themes_id[] = $row['fk_theme_no'];
                        }
                $keyword_query = "SELECT * FROM cartoon_keywords WHERE fk_toon_no=".$id;
                    $keyword_array = mysql_query($keyword_query);
                        while ($row = mysql_fetch_assoc($keyword_array)) {
                            $keywords_id[] = $row['fk_keyw_no'];
                        }     
                // show the form
                renderForm($artist_id, $p_date, $caption, $id,  NULL, $actor_id, $events_id, $themes_id, $keywords_id);        
        // if the 'id' value is not valid, redirect the user back to the viewcartoons.php page
        } else {
            header("Location: viewcartoons.php");
        }
    }
}

// NEW RECORD 
// if the 'id' variable is not set in the URL, we must be creating a new record
else {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])){
        // get the form data
        $artist_id = $_POST['fk_artist_no'];
        $pub_date =$_POST['p_date'];
        $caption = htmlentities($_POST['title'], ENT_QUOTES);
        $new_actors = htmlentities($_POST['new_actors'], ENT_QUOTES);
        $cartoon_actors=$_POST['actors'];
        $new_event = htmlentities($_POST['new_event'], ENT_QUOTES);
        $cartoon_event=$_POST['events'];
        $new_theme=htmlentities($_POST['new_theme'], ENT_QUOTES);
        $cartoon_theme=$_POST['themes'];
        $new_keywords=htmlentities($_POST['new_keywords'], ENT_QUOTES);
        $cartoon_keywords=$_POST['keywords'];
            // check that required fields are not empty
            if ($artist_id == '' || $caption == '' || $pub_date == '') {
                // if they are empty, show an error message and display the form
                $error = 'ERROR: Please fill in all required fields!';
                renderForm($artist_id, $pub_date, $caption, $error);    
            } else {
                    // explode date and reformat in MySQL order 
                    $pub_date=explode('/', $pub_date);
                        $mysqlPDate = $pub_date[2].'-'.$pub_date[0].'-'.$pub_date[1];               
                // insert the new cartoon into the database
                $new_toon = "INSERT INTO cartoons (toon_no, fk_artist_no, p_date, title) 
                            VALUES ('NULL', '".$artist_id."', '".$mysqlPDate."', '".$caption."')";
                        mysql_query($new_toon) or die('Error adding new cartoon ');
                    $new_toon_id = mysql_insert_id();
                // inserts new character into database and joiner table
                new_char_table($new_actors, $new_toon_id);
                // inserts existing characters into joiner table
                foreach($cartoon_actors as $cartoon_actor) {
                    if ($cartoon_actor >= 1) { 
                        join_table('cartoon_characters', 'fk_actor_no', $cartoon_actor, $new_toon_id);
                    }
                } 
                // add new event or existing event into database
                all_event_tables($new_event, $cartoon_event, $new_toon_id);
                // add new theme or existing theme into database
                all_theme_tables($new_theme, $cartoon_theme, $new_toon_id);

                new_keyword_table($new_keywords, $new_toon_id);

                foreach($cartoon_keywords as $cartoon_keyword) {
                    if ($cartoon_keyword >= 1) { 
                        join_table('cartoon_keywords', 'fk_keyw_no', $cartoon_keyword, $new_toon_id);
                    }
                } 
            }
            // redirect the user
            header("Location: viewcartoons.php");
    // if the form hasn't been submitted yet, show the form
    } else {
        renderForm();
    }
}
        
        // close the mysqli connection
        $mysqli->close();
?> 