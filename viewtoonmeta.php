
<?php $id = $_GET['toon_no']; 
// connect to the database
        include("connect-real-db.php");

$recent_cartoon = "SELECT * FROM cartoons WHERE toon_no=" .$id; 

$cartoonist = "SELECT cartoonists.artist_no, cartoonists.l_name, cartoonists.f_name, cartoonists.paper, cartoons.toon_no, cartoons.fk_artist_no "
."FROM cartoonists, cartoons "
."WHERE cartoons.toon_no = " .$id
." HAVING cartoonists.artist_no = cartoons.fk_artist_no";

$recent_char = "SELECT cartoon_characters.fk_toon_no, cartoon_characters.fk_actor_no, characters.actor_no, characters.actor "
."FROM cartoon_characters, characters "
."WHERE cartoon_characters.fk_toon_no = " .$id
." HAVING cartoon_characters.fk_actor_no = characters.actor_no";

$recent_event = "SELECT cartoon_events.fk_toon_no, cartoon_events.fk_event_no, events.event_no, events.event "
."FROM cartoon_events, events "
."WHERE cartoon_events.fk_toon_no = " .$id
." HAVING cartoon_events.fk_event_no = events.event_no";

$recent_keyword = "SELECT cartoon_keywords.fk_toon_no, cartoon_keywords.fk_keyw_no, keywords.keyw_no, keywords.keyword "
."FROM cartoon_keywords, keywords "
."WHERE cartoon_keywords.fk_toon_no = " .$id
." HAVING cartoon_keywords.fk_keyw_no = keywords.keyw_no";

?>
    <div class='heading'>
    <h3>Artist:</h3>
  </div>
    <?php if ($current_cartoonist=mysql_query($cartoonist)) { ?>
      <table id='cartoonist' border="1">
        <tr>
          <th>Artist ID</th><th>Artist Name</th><th>Paper</th>
        </tr>
        <?php while ($row=mysql_fetch_array($current_cartoonist)) { ?>
        <tr>
          <td><?php echo $row['fk_artist_no'];?></td>
          <td><?php echo $row['f_name'] ." " .$row['l_name'];?></td>
          <td><?php echo $row['paper'];?></td>
           <?php } ?>
        </tr>
      <?php } ?>
      </table>

    <h3><span style="color: #3286A5;"> Cartoon:</span></h3>
    <?php if ($cartoon_result=mysql_query($recent_cartoon)) { ?>
      <table id='cartoon' border="1">
        <tr>
          <th>Cartoon ID</th><th>Pub Date</th><th>Caption</th><th>Description</th>
        </tr>
        <?php while ($row=mysql_fetch_array($cartoon_result)) { ?>
        <tr>
          <td><?php echo $row['toon_no'];?></td>
          <td><?php echo $row['p_date'];?></td>
          <td><?php echo $row['title'];?></td>
          <td><?php echo $row['description'];?></td>
        <?php } ?>
        </tr>
      <?php } ?>
      </table>

<div id='leftside'>
    <div class='TableElement'>
    <h3>Event:</h3>
      <?php if ($recent_event_result=mysql_query($recent_event)) { ?>
        <table class='meta' border='1'>
          <tr>
            <th>Event ID</th><th>Event</th><th></th>
          </tr>
          <tr>
            <?php while ($row=mysql_fetch_array($recent_event_result)) { ?>
              <td><?php echo $row['fk_event_no'];?></td>
              <td class='tag'><?php echo $row['event'];?></td>
              <?php echo "<td><a href='ViewAll.php?events=" . $row['fk_event_no'] . "'>View All</a></td>"; ?>
          </tr>
      <?php } }?>
        </table>
    </div>

    <div class='TableElement'>
    <h3>Characters:</h3>
      <?php if ($recent_char_result=mysql_query($recent_char)) { ?>
      <table class='meta' border="1">
        <tr>
          <th>Actor ID</th><th>Actor</th><th></th>
        </tr>
          <tr>
            <?php while ($row=mysql_fetch_array($recent_char_result)) { ?>
              <td><?php echo $row['fk_actor_no'];?></td>
              <td class='tag'><?php echo $row['actor'];?></td>
              <?php echo "<td><a href='ViewAll.php?actors=" . $row['fk_actor_no'] . "'>View All</a></td>"; ?>
          </tr>
      <?php } }?>
        </table>
    </div>
</div>

 <div id='rightside'>
    <div class='TableElement'>
      <h3>Keywords:</h3>
      <?php if ($recent_keyword_result=mysql_query($recent_keyword)) { ?>
      <table class='meta' border="1">
        <tr>
          <th>Keyword ID</th><th>Keyword</th><th></th>
        </tr>
          <tr>
            <?php while ($row=mysql_fetch_array($recent_keyword_result)) { ?>
              <td><?php echo $row['fk_keyw_no'];?></td>
              <td class='tag'><?php echo $row['keyword'];?></td>
              <?php echo "<td><a href='ViewAll.php?keywords=" . $row['fk_keyw_no'] . "'>View All</a></td>"; ?>
          </tr>
      <?php } }?>
        </table>
    </div>
</div>

<div class='clearfloat'>

<form method="POST" action="">
<br /><input name="submit" type="submit" value="Delete Record" /><br />
</form>

<div class='clearfloat'>
<br />
<br />
<p><a href="DissCartoonForm.php">Add New Record</a></p>
<p><a href="DissDBTable.php">Return to Cartoons</a></p>
<p><a href="http://www.digitalpraxis.sashahoffman.org">Return to Portfolio Development Homepage</a></p>
</div>

<?php
$id=$_GET['toon_no'];
if (isset($_POST['submit'])) {
    $delete_keyword="DELETE FROM cartoon_keywords WHERE fk_toon_no=".$id;
        mysql_query($delete_keyword) or die('Error deleting joiner table');
    $delete_event="DELETE FROM cartoon_events WHERE fk_toon_no=".$id;
        mysql_query($delete_event) or die('Error deleting joiner table');
    $delete_actor="DELETE FROM cartoon_characters WHERE fk_toon_no=".$id;
        mysql_query($delete_actor) or die('Error deleting joiner table');
    $delete_cartoon="DELETE FROM cartoons WHERE toon_no=".$id;
        mysql_query($delete_cartoon) or die('Error deleting joiner table');
    header("Location: DissDBTable.php");
}
?>