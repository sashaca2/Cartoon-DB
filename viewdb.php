<div class='heading'><h2>View Records</h2></div>

        <p><a href="DissCartoonForm.php">Add New Record</a></p>
                
        <p><b>View All</b> | <a href="DissDBTablePage.php">View Paginated</a></p>
                
        <?php
        // connect to the database
        include('connect-real-db.php');
                        
        // get the records from the database
        if ($result = $mysqli->query("SELECT * FROM cartoons ORDER BY p_date desc")) {
            // display records if there are records to display
            if ($result->num_rows > 0) {
                // display records in a table
                echo "<table border='1' cellpadding='10'>";
                                        
                // set table headers
                echo "<tr><th>ID</th><th>Artist ID</th><th>Pub Date</th><th>Caption</th><th></th><th></th></tr>";
                                        
                while ($row = $result->fetch_object()) {
                    $p_date=$row->p_date;
                    $pub_date=explode('-', $p_date);
                        $mysqlPDate = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];
                    // set up a row for each record
                    echo "<tr>";
                    echo "<td>" . $row->toon_no . "</td>";
                    echo "<td>" . $row->fk_artist_no . "</td>";
                    echo "<td>" . $mysqlPDate . "</td>";
                    echo "<td>" . $row->title . "</td>";
                    echo "<td><a href='DissCartoonMeta.php?toon_no=" . $row->toon_no . "'>View Toon Meta</a></td>";
                    echo "<td><a href='DissCartoonForm.php?toon_no=" . $row->toon_no . "'>Edit Toon</a></td>";
                    echo "</tr>";
                }
                                        
                echo "</table>";
            } // if there are no records in the database, display an alert message
            else {
                echo "No results to display!";
            }
        } // show an error if there is an issue with the database query
        else {
            echo "Error: " . $mysqli->error;
        }
                        
        // close database connection
        $mysqli->close();
                
        ?>
                
    <p><a href="DissCartoonForm.php">Add New Record</a></p>
    <p><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a></p>

    </body>
</html>