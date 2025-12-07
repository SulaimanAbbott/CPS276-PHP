<?php
// Only build nav if user is logged in
if (!isset($_SESSION['status'])) {
  $nav = '';
  return;
}

$nav = <<<HTML
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <a class="navbar-brand" href="#">Modular Website</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="index.php?page=welcome">Welcome</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=addContact">Add Contact</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=deleteContacts">Delete Contact(s)</a></li>
HTML;

if ($_SESSION['status'] === 'admin') {
  $nav .= <<<HTML
      <li class="nav-item"><a class="nav-link" href="index.php?page=addAdmin">Add Admin</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=deleteAdmins">Delete Admin(s)</a></li>
HTML;
}

$nav .= <<<HTML
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
HTML;
?>