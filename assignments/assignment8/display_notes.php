<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$notes = $dt->checkSubmit();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Display Notes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <h1>Display Notes</h1>
      <p><a href="index.php">Add Note</a></p>
      <div>
        <?php echo $notes ?? ''; ?>
      </div>
      <form action="display_notes.php" method="post">
        <div class="form-group">
          <label for="begDate">Beginning Date</label>
          <input type="date" class="form-control" id="begDate" name="begDate">
        </div>
        <div class="form-group">
          <label for="endDate">Ending Date</label>
          <input type="date" class="form-control" id="endDate" name="endDate">
        </div>
        <div class="form-group">
          <input type="submit" name="getNotes" class="btn btn-primary" value="Get Notes">
        </div>
      </form>
    </div>
  </body>
</html>