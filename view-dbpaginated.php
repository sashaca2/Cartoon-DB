<div class='heading'><h2>View Cartoons</h2></div>
                
<?php
	// connect to the database
    include('connect-real-db.php');
                        
    // number of results to show per page
    $per_page = 100;
                                        
    // figure out the total pages in the database
    if ($result = $mysqli->query("SELECT * FROM cartoons ORDER BY p_date desc")) {
		
		if ($result->num_rows != 0) {
		
			$total_results = $result->num_rows;
            	// ceil() returns the next highest integer value by rounding up value if necessary
            	$total_pages = ceil($total_results / $per_page);
                                                        
                	// check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)
                    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
						$show_page = $_GET['page'];
                                                                
						// make sure the $show_page value is valid
                        if ($show_page > 0 && $show_page <= $total_pages) {
							$start = ($show_page -1) * $per_page;
                            $end = $start + $per_page; 
                        } else {
                        	// error - show first set of results
                            $start = 0;
                            $end = $per_page; 
                        }               
                    } else {
                    	// if page isn't set, show first set of results
                        $start = 0;
                        $end = $per_page; 
                    }
                                                        
                    // display pagination
                    echo "<p><a href='DissDBTable.php'>View All</a> | <b>View Page:</b> ";
                    for ($i = 1; $i <= $total_pages; $i++) {
						if (isset($_GET['page']) && $_GET['page'] == $i) {
							echo $i . " ";
                        } else {
                            echo "<a href='DissDBTablePage.php?page=$i'>$i</a> ";
                        }
                    }
                    echo "</p>";
                                                        
                    // display data in table
                    echo "<table border='1' cellpadding='10'>";
                    echo "<tr><th>ID</th><th>Artist ID</th><th>Pub Date</th><th>Caption</th><th></th><th></th></tr>";
                                                
                    // loop through results of database query, displaying them in the table 
                    for ($i = $start; $i < $end; $i++) {
						// make sure that PHP doesn't try to show results that don't exist
                        if ($i == $total_results) { break; }
                                                        
                        // find specific row
                        $result->data_seek($i);
                        $row = $result->fetch_row();
            
                        $p_date=$row[2];
                            $pub_date=explode('-', $p_date);
                            $mysqlPDate = $pub_date[1].'/'.$pub_date[2].'/'.$pub_date[0];
                                                                        
                        // echo out the contents of each row into a table
                        echo "<tr>";
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $mysqlPDate . '</td>';
                        echo '<td>' . $row[3] . '</td>';
                        echo "<td><a href='DissCartoonMeta.php?toon_no=" . $row[0] . "'>View Toon Meta</a></td>";
                        echo "<td><a href='DissCartoonForm.php?toon_no=" . $row[0] . "'>Edit Toon</a></td>";
                        echo "</tr>";
                    }

                    // close table>
                    echo "</table>";
        } else {
            echo "No results to display!";
        } 
    
    } else {
    	// error with the query
        echo "Error: " . $mysqli->error;
    }
                                                
        // close database connection
        $mysqli->close();            
?>
                
              <p><a href="DissCartoonForm.php">Add New Record</a></p>
              <p><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a></p>