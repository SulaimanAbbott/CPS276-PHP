<?php

/* Placing all PHP above the DOCTYPE allows the server
 to execute logic first and prepare variables before any HTML is sent -- no overlap, separates logic from presentation
*/

// Array for numbers 1 to 50
$numbers = [];
for ($i = 1; $i <= 50; $i++) {
    $numbers[] = $i;
}

$evenArray = [];

// Collect even numbers using a foreach loop
// foreach loops through $numbers and the if condition filters even numbers
// This pattern can be reused to filter other stuff

// foreach loop for even numbers
foreach ($numbers as $num) {
    if ($num % 2 === 0) { // example of other reason for filtering: if ($product['price'] > 50)
        $evenArray[] = $num;
    }
}


// Strings with implode
$evenNumbers = "Even Numbers: " . implode(" - ", $evenArray);

// makes it easy to embed large blocks of HTML or text without escaping quotes or breaking lines 
// into multiple strings. it makes the code more readable because it looks more like regular HTML, 
// avoids messy concatenation, and clearly separates presentation from PHP logic.

// Form with heredoc syntax
$form = <<<EOD
<form method="post" action="#">
  <div class="mb-3">
    <label for="emailInput" class="form-label">Email address</label>
    <input type="email" class="form-control" id="emailInput" name="email" placeholder="name@example.com">
  </div>
  <div class="mb-3">
    <label for="exampleTextarea" class="form-label">Example textarea</label>
    <textarea class="form-control" id="exampleTextarea" name="message" rows="3"></textarea>
  </div>
</form>
EOD;

/* Example Form
        $form = "<form>" .
          "<label for=\"email\">Email:</label>" .
          "<input type=\"email\" id=\"email\">" .
        "</form>"; 
*/

// The outer for loop controls how many tr are created.
// For each row, the inner for loop runs and creates the correct number of columns (<td>).
// Inside the inner loop, .= concatenates each new cell onto the existing $table string.
// table is built piece by piece, with every row and column added in order.

// Table generation function
function createTable($rows, $cols) {
    $table = "<table class='table table-bordered'>";
    for ($i = 1; $i <= $rows; $i++) {
        $table .= "<tr>";
        for ($j = 1; $j <= $cols; $j++) {
            $table .= "<td>Row $i, Col $j</td>";
        }
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
}
?>

<!-- HTML with Bootstrap -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PHP Table Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <?php
        echo "<p>$evenNumbers</p>";
        echo $form;
        echo createTable(8, 6);
    ?>
  </body>
</html>
