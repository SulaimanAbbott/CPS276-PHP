<?php
require_once 'controllers/deleteContactProc.php';

function init(){
  global $records, $msg, $deleted;

  $status = $_SESSION['status'] ?? '';

  $links = "<p>";
  $links .= "<a href='index.php?page=addContact'>Add Contact</a> &nbsp;&nbsp;&nbsp; ";
  $links .= "<a href='index.php?page=deleteContacts'>Delete Contact(s)</a> &nbsp;&nbsp;&nbsp; ";

  if ($status === 'admin') {
    $links .= "<a href='index.php?page=addAdmin'>Add Admin</a> &nbsp;&nbsp;&nbsp; ";
    $links .= "<a href='index.php?page=deleteAdmins'>Delete Admin(s)</a> &nbsp;&nbsp;&nbsp; ";
  }

  $links .= "<a href='logout.php'>Logout</a>";
  $links .= "</p>";

  if ($records == "error") {
    $msg = "<p style='color:red'>Could not display records</p>";
    $output = "";
  }
  elseif (count($records) === 0) {
    $msg = "<p>There are no records to display</p>";
    $output = "";
  }
  else {
    $output = <<<HTML
    <div class="container mt-5">
      {$links}

      <h1>Delete Contact(s)</h1>
      <form method='post' action='index.php?page=deleteContacts'>
        <input type='submit' class='btn btn-danger mb-3' name='delete' value='Delete'/>
        <table class='table table-striped table-bordered'>
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Zip</th>
              <th>Phone</th>
              <th>Email</th>
              <th>DOB</th>
              <th>Age Range</th>
              <th>Contact</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
HTML;

    foreach ($records as $row) {
      $output .= "<tr>
        <td>{$row['fname']}</td>
        <td>{$row['lname']}</td>
        <td>{$row['address']}</td>
        <td>{$row['city']}</td>
        <td>{$row['state']}</td>
        <td>{$row['zip']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['email']}</td>
        <td>{$row['dob']}</td>
        <td>{$row['age']}</td>
        <td>{$row['contact']}</td>
        <td><input type='checkbox' name='chkbx[]' value='{$row['id']}' /></td>
      </tr>";
    }

    $output .= "</tbody></table></form></div>";

    if ($deleted) {
      $msg = "<p style='color:green'>Contact(s) deleted</p>";
    } else {
      $msg = "<p>&nbsp;</p>";
    }
  }

  return $msg.$output;
}
?>