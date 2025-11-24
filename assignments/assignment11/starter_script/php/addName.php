<?php
require_once "../classes/Pdo_methods.php";

class AddName {

  public function process() {

    // Get JSON 
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    // validate name input
    if (!isset($data["name"]) || trim($data["name"]) === "") {
      return json_encode([
        "masterstatus" => "error",
        "msg" => "You must enter a name"
      ]);
    }

    // Remove extra spaces
    $cleanName = trim($data["name"]);
    $cleanName = preg_replace("/\s+/", " ", $cleanName);

    $nameParts = explode(" ", $cleanName);

    // validate at least first and last name
    if (count($nameParts) < 2) {
      return json_encode([
        "masterstatus" => "error",
        "msg" => "Please enter both first and last name"
      ]);
    }

    // Get first and last name only
    $firstName = $nameParts[0];
    $lastName = $nameParts[count($nameParts) - 1];

    // flip 
    $finalName = $lastName . ", " . $firstName;

    // database
    $pdo = new PdoMethods();
    $sql = "INSERT INTO names (name) VALUES (:name)";
    $bindings = [
      [":name", $finalName, "str"]
    ];

    $insertResult = $pdo->otherBinded($sql, $bindings);

    // insert error
    if ($insertResult === "error") {
      return json_encode([
        "masterstatus" => "error",
        "msg" => "Database insert failed"
      ]);
    }

    // Insert successful 
    return $this->getNames("Name added.");
  }

  private function getNames($message) {

    // Get names 
    $pdo = new PdoMethods();
    $sql = "SELECT name FROM names ORDER BY name ASC";
    $records = $pdo->selectNotBinded($sql);

    // select error
    if ($records === "error") {
      return json_encode([
        "masterstatus" => "error",
        "msg" => "Could not retrieve names"
      ]);
    }

    // check for empty table
    if (count($records) === 0) {
      return json_encode([
        "masterstatus" => "success",
        "msg" => $message,
        "names" => "No names to display."
      ]);
    }

    // build names list
    $output = "";
    foreach ($records as $row) {
      $safeName = htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8");
      $output .= $safeName . "<br>";
    }

    // sucess return
    return json_encode([
      "masterstatus" => "success",
      "msg" => $message,
      "names" => $output
    ]);
  }

}

$worker = new AddName();
echo $worker->process();
