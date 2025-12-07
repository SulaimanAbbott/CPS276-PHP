<?php
require_once 'controllers/loginProc.php';

function init(){
  global $acknowledgment;

  return <<<HTML
<div class="container mt-5">
  <h1>Login</h1>
  {$acknowledgment}
  <form method="post" action="">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="text" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    <input type="submit" class="btn btn-primary" value="Login">
  </form>
</div>
HTML;
}
?>