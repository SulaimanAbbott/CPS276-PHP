<?php
require_once 'controllers/addContactProc.php';
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

return <<<HTML
<div class="container mt-5">
  {$links}
  {$acknowledgment}
  
  <h1>Add Contact</h1>
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

    <div class="row">
      <div class="col-md-12">
        {$stickyForm->renderInput($formConfig['address'], 'mb-3')}
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        {$stickyForm->renderInput($formConfig['city'], 'mb-3')}
      </div>
      <div class="col-md-6">
        {$stickyForm->renderSelect($formConfig['state'], 'mb-3')}
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        {$stickyForm->renderInput($formConfig['zip'], 'mb-3')}
      </div>
      <div class="col-md-4">
        {$stickyForm->renderInput($formConfig['phone'], 'mb-3')}
      </div>
      <div class="col-md-4">
        {$stickyForm->renderInput($formConfig['email'], 'mb-3')}
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        {$stickyForm->renderInput($formConfig['dob'], 'mb-3')}
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        {$stickyForm->renderRadio($formConfig['age'], 'mb-3', 'horizontal')}
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        {$stickyForm->renderCheckboxGroup($formConfig['contact'], 'mb-3', 'horizontal')}
      </div>
    </div>

    <input type="submit" class="btn btn-primary" value="Add Contact">
  </form>
</div>
HTML;
}
?>