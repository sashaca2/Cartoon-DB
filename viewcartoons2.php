<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
        <head>  
                <title>View Cartoons</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        </head>
        <body>
                
                <h1>View Cartoons</h1>
                
                <p><b>View All</b> | <a href="view-paginated.php">View Paginated</a></p>
                
                <?php
                        // connect to the database
  include('connect-db.php');

                        

								
                                
$all_cartoon_query = "SELECT * FROM cartoons ORDER BY toon_no";

$all_cartoon_result = mysql_query($all_cartoon_query) or die(mysql_error());

?>


<br /><table border='1'><tr>
    <th>Cartoon ID</th>
    <th>Artist ID</th>
    <th>Pub Date</th>
    <th>Caption</th>
    <th></th>
    <th></th>
  </tr>
<?php while($row = mysql_fetch_array($all_cartoon_result)){  ?>
<tr>
<td><?php echo $row['toon_no'];?></td>
<td><?php echo $row['fk_artist_no'];?></td>
<td><?php echo $row['p_date'];?></td>
<td><?php echo $row['title'];?></td>
<td><a href="recordstest.php?toon_no=<?php echo $row['toon_no'];?>">Edit Toon</a></td>
<td><a href="addmeta.php?toon_no=<?php echo $row['toon_no'];?>">Add New Meta</a></td>
</tr>

<?php
 } 
?>
</table>
                        
                 <a href="formdev.php">Add New Record</a>
                <br /><a href="https://github.com/sashaca2/Cartoon-DB">See the Code</a>
<br /><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a>

        </body>
</html>