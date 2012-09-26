<?php
        /*
                Allows the user to both create new records and edit existing records
        */

        // connect to the database
        include("connect-db.php");

        // creates the new/edit record form
        // since this form is used multiple times in this file, I have made it a function that is easily reusable
        function renderForm($artist_id = '', $pub_date ='', $caption = '', $id = '', $error = '')
        { ?>
                <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                <html>
                        <head>  
                                <title>
                                        <?php if ($id != '') { echo "Edit Cartoon"; } else { echo "New Record"; } ?>
                                </title>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        </head>
                        <body>
                                <h1><?php if ($id != '') { echo "Edit Cartoon"; } else { echo "New Record"; } ?></h1>
                                <?php if ($error != '') {
                                        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
                                                . "</div>";
                                } ?>
                                
						<form action="" method="post">
						<div>
								Select Cartoonist: *<br />
				
									<?php $sql = mysql_query("SELECT fk_artist_no FROM cartoons WHERE toon_no=".$id);
									$result = mysql_fetch_array($sql);
									$artist_id = $result['fk_artist_no'];
									$query = mysql_query("SELECT * FROM cartoonists"); ?>

								<select name='fk_artist_no'>
									<?php while ($accessrow = mysql_fetch_array($query)) { ?>
										<option value="<?php echo $accessrow['artist_no']; ?>" selected="<?php if ($artist_id == $accessrow['artist_no']) { echo 'selected'; } ?>">
											<?php echo $accessrow['f_name'] ." " .$accessrow['l_name'] .": " ,$accessrow['paper']; ?>
										</option>
									<?php } 
/*									?>
				
				            	<select name="fk_artist_no">
            						<?php $artistq = "SELECT artist_no, f_name, l_name, paper FROM cartoonists";
									$artistr = mysql_query($artistq) or die(mysql_error());
										while($row = mysql_fetch_assoc($artistr)) {
											echo "<option value='{$row['artist_no']}'>{$row['f_name']} {$row['l_name']}: {$row['paper']}</option>";
										}
										echo "<br />"; 
*/									?>
								</select><br />
				
								<br />Enter Cartoon Publication Date: <em>(mm/dd/yyyy)</em> *
										<input type="text" name="p_date" size="10" value="<?php echo $pub_date; ?>"/><br />

								<br />Enter Caption for Cartoon: *<br />
										<textarea name='title' cols=50 rows=4><?php echo $caption; ?></textarea><br />
					
								<br /><input type="submit" name="submit" value="Submit" />
 						</div>
        				</form>
        				</body>
        				</html>
<?php } // ends function
		 
 
		// EDIT RECORD
		// if the 'id' variable is set in the URL, we know that we need to edit a record
        if (isset($_GET['toon_no'])) {

                // if the form's submit button is clicked, we need to process the form
                if (isset($_POST['submit'])) {

                        // make sure the 'id' in the URL is valid
                        if (is_numeric($_POST['toon_no'])) {
//							echo "Add code to update, insert and delete db";
							
							// get 'id' from URL
                            $id = $_GET['toon_no'];
						}
                        
                        // if the 'id' variable is not valid, show an error message
                        else {
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
                                        
                    	    	    // show the form
                    	    	    renderForm($artist_id, $p_date, $caption, $id,  NULL);
                    	                    
                        		    $stmt->close();
                				}
                        
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
                $artist_id =mysql_real_escape_string($_POST['fk_artist_no']);
				$caption =mysql_real_escape_string($_POST['title']);
				$pub_date =$_POST['p_date'];
						
					// check that required fields are not empty
                    if ($artist_id == '' || $caption == '' || $pub_date == '') {
                    
                    	// if they are empty, show an error message and display the form
                        $error = 'ERROR: Please fill in all required fields!';
                        renderForm($artist_id, $pub_date, $caption, $error);
                    
                    } else {
                    	
                    	// explode date and reformat in MySQL order	
                    	$pub_date=explode('/', $pub_date);
						$mysqlPDate = $pub_date[2].'-'.$pub_date[0].'-'.$pub_date[1];	
                                
                        // insert the new record into the database
                        $new_toon = "INSERT INTO cartoons (toon_no, fk_artist_no, p_date, title) 
								VALUES ('NULL', '".$artist_id."', '".$mysqlPDate."', '".$caption."')";
						mysql_query($new_toon) or die('Error adding new cartoon ');

						$new_toon_id = mysql_insert_id();
         				
         				// redirec the user
	                    header("Location: viewcartoons.php");
	                }
            // if the form hasn't been submitted yet, show the form
        	} else {
                        renderForm();
            }
        }
        
        // close the mysqli connection
//        $mysqli->close();
?> 