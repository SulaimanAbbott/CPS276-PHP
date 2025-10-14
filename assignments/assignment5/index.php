<?php
require_once 'classes/Directories.php';

$message = '';
$fileLink = '';

if (isset($_POST['submit'])) {
    $dirName = trim($_POST['directoryname']);
    $fileContent = trim($_POST['filecontent']);

    // Validate directory name (AI Prompt: Give me a command I can use instead of an if statement that only allows alphabetic characters)
    if (!ctype_alnum($dirName)) {
        $message = 'Folder name must contain alphanumeric characters only (A–Z, a–z, 1-10).';
    } else {
        $directories = new Directories();
        $result = $directories->createDirectoryAndFile($dirName, $fileContent);

        if ($result['status'] === 'success') {
            $fileLink = "File and directory were created<br>
                         <a href='" . htmlspecialchars($result['path']) . "' target='_blank'>Path where file is located</a>";
        } else {
            $message = $result['message'];
        }
    }
}

// Determine output message
$output = $fileLink ?: $message;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File and Directory</title>
    <link 
      rel="stylesheet" 
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
      crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-4">
      <h1>File and Directory Assignment</h1>
      <p>Enter a folder name and the contents of a file. Folder names should contain alphanumeric characters only.</p>

      <p><?php echo $output; ?></p>

      <form method="post" action="">
        <div class="form-group">
          <label for="directoryname">Folder Name</label>
          <input type="text" class="form-control" id="directoryname" name="directoryname" required>
        </div>
        <div class="form-group">
          <label for="filecontent">File Content</label>
          <textarea id="filecontent" name="filecontent" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </form>
    </div>
  </body>
</html>
