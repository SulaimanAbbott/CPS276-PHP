<?php
// Numbers
$evenNumbers = "";
for ($i = 1; $i <= 50; $i++) {
    if ($i % 2 == 0) {
        if ($evenNumbers !== "") {
            $evenNumbers .= " - ";
        }
        $evenNumbers .= $i;
    }
}

// Label
$evenNumbers = "Even Numbers: " . $evenNumbers;

// heredoc
$form = <<<EOD
<form>
  <div class="mb-3">
    <label for="emailInput" class="form-label">Email address</label>
    <input type="email" class="form-control" id="emailInput" placeholder="name@example.com">
  </div>
  <div class="mb-3">
    <label for="exampleTextarea" class="form-label">Example text area</label>
    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
  </div>
</form>
EOD;

// Table
function createTable($rows, $cols) {
    $table = "<table class='table table-bordered'>"; // Styling
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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Table PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <?php
        echo $evenNumbers;
        echo $form;
        echo createTable(8, 6);
    ?>
  </body>
</html>
