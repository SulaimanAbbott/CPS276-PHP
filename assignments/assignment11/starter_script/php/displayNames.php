<?php
require_once "../classes/Pdo_methods.php";

class DisplayNames {

  public function process() {
    $pdo = new PdoMethods();

    // Get all names 
    $sql = "SELECT name FROM names ORDER BY name ASC";
    $records = $pdo->selectNotBinded($sql);

    // error
    if ($records === "error") {
      return json_encode([
        "masterstatus" => "error",
        "msg" => "Could not retrieve names"
      ]);
    }

    if (count($records) === 0) {
      return json_encode([
        "masterstatus" => "success",
        "msg" => "",
        "names" => "No names to display."
      ]);
    }

    $output = "";
    foreach ($records as $row) {
      $safeName = htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8");
      $output .= $safeName . "<br>";
    }

    // Return names
    return json_encode([
      "masterstatus" => "success",
      "msg" => "",
      "names" => $output
    ]);
  }

}

// Run the code
$worker = new DisplayNames();
echo $worker->process();
