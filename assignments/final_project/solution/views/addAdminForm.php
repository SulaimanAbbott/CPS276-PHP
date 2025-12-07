<?php
require_once 'controllers/addAdminProc.php';
function init(){
  global $formConfig, $stickyForm, $acknowledgment;

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

  // Build password error message outside heredoc
  $passwordError = '';
  if (!empty($formConfig['password']['error'])) {
    $passwordError = '<span class="text-danger">' . $formConfig['password']['error'] . '</span><br>';
  }

return <<<HTML
<div class="container mt-5">
  {$links}
  {$acknowledgment}

  <h1>Add Admin</h1>
  <p>Fields with * are required</p>

  <form method="post" action="">
    <div class="row">
      <div class="col-md-6">
        {$stickyForm->renderInput($formConfig['first_name'], 'mb-3')}
      </div>
      <div class="col-md-6">
        {$stickyForm->renderInput($formConfig['last_name'], 'mb-3')}
      </div>
    </div>

    <div class="mb-3">
      {$stickyForm->renderInput($formConfig['email'], 'mb-3')}
    </div>
    <div class="mb-3">
      <label for="password">*Password</label>
      <input type="password" class="form-control" id="password" name="password" value="{$formConfig['password']['value']}">
      {$passwordError}
    </div>
    <div class="mb-3">
      {$stickyForm->renderSelect($formConfig['status'], 'mb-3')}
    </div>
    <input type="submit" class="btn btn-primary" value="Add Admin">
  </form>
</div>
HTML;
}
?>