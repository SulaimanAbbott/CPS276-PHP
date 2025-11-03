<?php
require_once 'Pdo_methods.php';

class Date_time {

  public function checkSubmit() {
    if (isset($_POST['addNote'])) {
      return $this->addNote();
    }
    if (isset($_POST['getNotes'])) {
      return $this->getNotes();
    }
  }

  private function addNote() {
    $dateTime = $_POST['dateTime'] ?? '';
    $note = trim($_POST['note'] ?? '');

    if ($dateTime === '' || $note === '') {
      return "You must enter a date, time, and note.";
    }

    $timestamp = strtotime($dateTime);
    $pdo = new PdoMethods();

    $sql = "INSERT INTO note (date_time, note) VALUES (:date_time, :note)";
    $bindings = [
      [':date_time', $timestamp, 'int'],
      [':note', $note, 'str']
    ];

    $result = $pdo->otherBinded($sql, $bindings);

    if ($result === 'noerror') {
      return "Note added successfully.";
    } else {
      return "There was an error adding the note.";
    }
  }

  private function getNotes() {
    $begDate = $_POST['begDate'] ?? '';
    $endDate = $_POST['endDate'] ?? '';

    if ($begDate === '' || $endDate === '') {
      return "No notes found for the date range selected.";
    }

    $begTimestamp = strtotime($begDate . ' 00:00:00');
    $endTimestamp = strtotime($endDate . ' 23:59:59');

    $pdo = new PdoMethods();
    $sql = "SELECT date_time, note FROM note WHERE date_time BETWEEN :begDate AND :endDate ORDER BY date_time DESC";
    $bindings = [
      [':begDate', $begTimestamp, 'int'],
      [':endDate', $endTimestamp, 'int']
    ];

    $records = $pdo->selectBinded($sql, $bindings);

    if ($records === 'error' || count($records) === 0) {
      return "No notes found for the date range selected.";
    }

    $output = "<table class='table table-striped'><thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>";
    foreach ($records as $row) {
      $formattedDate = date("m/d/Y h:i A", $row['date_time']);
      $output .= "<tr><td>{$formattedDate}</td><td>{$row['note']}</td></tr>";
    }
    $output .= "</tbody></table>";
    return $output;
  }
}
?>