<?php
$output = "";
$acknowledgement = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'php/rest_client.php';
    $result = getWeather();
    $acknowledgement = $result[0];
    $output = $result[1];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Weather API</title>
  </head>
  <body class="container mt-4">
    <h1>Enter Zip Code to Get City Weather</h1>

    <?php echo $acknowledgement; ?>

        <form method="post" action="index.php" class="form-inline">
            <div class="form-group mb-2">
                <label for="zip_code" class="sr-only">Zip Code:</label>
                <input style="width: 25%;" type="text" class="form-control" id="zip_code" name="zip_code">
            </div>
            <button type="submit" class="btn btn-primary mb-2 ml-2">Submit</button>
        </form>

    <?php echo $output; ?>
  </body>
</html>