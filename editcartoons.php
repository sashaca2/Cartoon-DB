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
                                        <?php if ($id != '') { ?>
                                                <input type="hidden" name="toon_no" value="<?php echo $id; ?>" />
                                                <p>Cartoon ID: <?php echo $id; ?></p>
                                        <?php } ?>
                                        
                                        <strong>Artist ID: *</strong> <input type="text" name="fk_artist_no"
                                                value="<?php echo $artist_id; ?>"/><br/>
                                        <strong>Pub Date: <em>YYYY-MM-DD</em> *</strong> <input type="text" name="p_date"
                                                value="<?php echo $pub_date; ?>"/><br />
                                        <strong>Caption: *</strong><br />
                                        		<textarea name='caption' cols=50 rows=4><?php echo $caption; ?></textarea><br />
                                        <input type="submit" name="submit" value="Submit" />
                                </div>
                                </form>
                                <br /><a href="viewcartoons.php">Return to All Cartoons</a>
                                 <br /><a href="formdev.php">Add New Record</a>
                <br /><a href="https://github.com/sashaca2/Cartoon-DB">See the Code</a>
<br /><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a>
                        </body>
                </html>
                
        <?php }



        /*

           EDIT RECORD

        */
        // if the 'id' variable is set in the URL, we know that we need to edit a record
        if (isset($_GET['toon_no']))
        {
                // if the form's submit button is clicked, we need to process the form
                if (isset($_POST['submit']))
                {
                        // make sure the 'id' in the URL is valid
                        if (is_numeric($_POST['toon_no']))
                        {
                                // get variables from the URL/form
                                $id = $_POST['toon_no'];
                                $artist_id = htmlentities($_POST['fk_artist_no'], ENT_QUOTES);
                                $pub_date = htmlentities($_POST['p_date'], ENT_QUOTES);
                                $caption = htmlentities($_POST['caption'], ENT_QUOTES);
                                
                                // check that firstname and lastname are both not empty
                                if ($artist_id == '' || $pub_date == '' || $caption == '')
                                {
                                        // if they are empty, show an error message and display the form
                                        $error = 'ERROR: Please fill in all required fields!';
                                        renderForm($artist_id, $pub_date, $caption, $error, $id);
                                }
                                else
                                {
                                        // if everything is fine, update the record in the database
                                        if ($stmt = $mysqli->prepare("UPDATE cartoons SET fk_artist_no = ?, p_date = ?, title = ?
                                                WHERE toon_no=?"))
                                        {
                                                $stmt->bind_param("issi", $artist_id, $pub_date, $caption, $id);
                                                $stmt->execute();
                                                $stmt->close();
                                        }
                                        // show an error message if the query has an error
                                        else
                                        {
                                                echo "ERROR: could not prepare SQL statement.";
                                        }
                                        
                                        // redirect the user once the form is updated
                                        header("Location: viewcartoons.php");
                                }
                        }
                        // if the 'id' variable is not valid, show an error message
                        else
                        {
                                echo "Error!";
                        }
                }
                // if the form hasn't been submitted yet, get the info from the database and show the form
                else
                {
                        // make sure the 'id' value is valid
                        if (is_numeric($_GET['toon_no']) && $_GET['toon_no'] > 0)
                        {
                                // get 'id' from URL
                                $id = $_GET['toon_no'];
                                
                                // get the record from the database
                                if($stmt = $mysqli->prepare("SELECT * FROM cartoons WHERE toon_no=?"))
                                {
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        
                                        $stmt->bind_result($id, $artist_id, $pub_date, $caption);
                                        $stmt->fetch();
                                        
                                        // show the form
                                        renderForm($artist_id, $pub_date, $caption, $id,  NULL);
                                        
                                        $stmt->close();
                                }
                                // show an error if the query has an error
                                else
                                {
                                        echo "Error: could not prepare SQL statement";
                                }
                        }
                        // if the 'id' value is not valid, redirect the user back to the view.php page
                        else
                        {
                                header("Location: viewcartoons.php");
                        }
                }
        }

?>
