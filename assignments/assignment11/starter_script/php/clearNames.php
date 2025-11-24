<?php
require_once "../classes/Pdo_methods.php";

class ClearNames {

  public function process() {

    $pdo = new PdoMethods();

    // SQL to delete all names
    $sql = "DELETE FROM names";
    $result = $pdo->otherNotBinded($sql);

    // error
    if ($result === "error") {
      return json_encode([
        "masterstatus" => "error",
        "msg" => "Could not clear names"
      ]);
    }

    // success
    return json_encode([
      "masterstatus" => "success",
      "msg" => "All names cleared",
      "names" => "No names to display."
    ]);
  }
}

// Run the code
$worker = new ClearNames();
echo $worker->process();
