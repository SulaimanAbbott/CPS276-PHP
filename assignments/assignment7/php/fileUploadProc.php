<?php
require_once __DIR__ . '/../classes/Pdo_methods.php';

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fileUpload'])) {
    $fileName = trim($_POST['fileName']);
    $file = $_FILES['file'];

    // Validate file name
    if ($fileName === '') {
        $output = "<p>Please enter a file name.</p>";
        return;
    }

    // Validate file upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $output = "<p>File upload error.</p>";
        return;
    }

    // Check file size
    if ($file['size'] > 100000) {
        $output = "<p>File must be under 100000 bytes.</p>";
        return;
    }

    // Check MIME type
    // AI Prompt: "How can I validate a PDF file upload in PHP and check its MIME type?"
    if ($file['type'] !== 'application/pdf') {
        $output = "<p>Only PDF files are allowed.</p>";
        return;
    }

    // Move file to files directory
    $targetDir = 'files/';
    $targetPath = $targetDir . basename($file['name']);

    // AI Prompt: “Can you walk me through how PHP handles file uploads? also tell me about security risks and how I can mitigate them”
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        $output = "<p>Failed to move uploaded file.</p>";
        return;
    }

    // Insert into database
    $pdo = new PdoMethods();
    $sql = "INSERT INTO file_uploads (file_name, file_path) VALUES (:fileName, :filePath)";
    $bindings = [
        [':fileName', $fileName, 'str'],
        [':filePath', $targetPath, 'str']
    ];

    $result = $pdo->otherBinded($sql, $bindings);

    if ($result === 'noerror') {
        $output = "<p>File uploaded successfully.</p>";
    } else {
        $output = "<p>Database error. File not saved.</p>";
    }
}
?>