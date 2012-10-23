<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
        <head>  
                <title>View Records</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        </head>
        <body>
                
                <h1>View Records</h1>

                <p><a href="newForm.php">Add New Record</a></p>
                
                <p><b>View All</b> | <a href="view-paginated.php">View Paginated</a></p>
                
                <?php
                        // connect to the database
                        include('connect-db.php');
                        
                        // get the records from the database
                        if ($result = $mysqli->query("SELECT * FROM cartoons ORDER BY toon_no desc"))
                        {
                                // display records if there are records to display
                                if ($result->num_rows > 0)
                                {
                                        // display records in a table
                                        echo "<table border='1' cellpadding='10'>";
                                        
                                        // set table headers
                                        echo "<tr><th>ID</th><th>Artist ID</th><th>Pub Date</th><th>Caption</th><th></th><th></th></tr>";
                                        
                                        while ($row = $result->fetch_object())
                                        {
                                                // set up a row for each record
                                                echo "<tr>";
                                                echo "<td>" . $row->toon_no . "</td>";
                                                echo "<td>" . $row->fk_artist_no . "</td>";
                                                echo "<td>" . $row->p_date . "</td>";
                                                echo "<td>" . $row->title . "</td>";
                                                echo "<td><a href='viewmeta.php?toon_no=" . $row->toon_no . "'>View Toon Meta</a></td>";
                                                echo "<td><a href='newForm.php?toon_no=" . $row->toon_no . "'>Edit Toon</a></td>";
                                                echo "</tr>";
                                        }
                                        
                                        echo "</table>";
                                }
                                // if there are no records in the database, display an alert message
                                else
                                {
                                        echo "No results to display!";
                                }
                        }
                        // show an error if there is an issue with the database query
                        else
                        {
                                echo "Error: " . $mysqli->error;
                        }
                        
                        // close database connection
                        $mysqli->close();
                
                ?>
                
                <p><a href="newForm.php">Add New Record</a></p>
        </body>
</html>