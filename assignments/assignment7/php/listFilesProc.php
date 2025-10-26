<?php
require_once __DIR__ . '/../classes/Pdo_methods.php';

$pdo = new PdoMethods();
$sql = "SELECT file_name, file_path FROM file_uploads";
$result = $pdo->selectNotBinded($sql);

$output = "<ul>";

// AI Prompt: "Can you explain how to handle different outcomes from a PDO SELECT query in PHP? i'm trying to use an if statement to check for errors and empty results"
if ($result === 'error') {
    $output .= "<li>Error retrieving file list.</li>";
} elseif (count($result) === 0) {
    $output .= "<li>No files found.</li>";
} else {
    foreach ($result as $row) {
        $output .= "<li><a target='_blank' href='" . htmlspecialchars($row['file_path']) . "'>" . htmlspecialchars($row['file_name']) . "</a></li>";
    }
}

$output .= "</ul>";
?>