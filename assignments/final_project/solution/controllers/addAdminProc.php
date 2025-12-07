<?php
require_once('classes/StickyForm.php');
require_once('classes/Pdo_methods.php');

$acknowledgment = "<p></p>";

// Check for success message from redirect
if (isset($_SESSION['acknowledgment'])) {
  $acknowledgment = $_SESSION['acknowledgment'];
  unset($_SESSION['acknowledgment']);
}

$formConfig = [
  'first_name' => [
    'type' => 'text',
    'regex' => 'name',
    'label' => '*First Name',
    'name' => 'first_name',
    'id' => 'first_name',
    'errorMsg' => 'You must enter a valid first name',
    'error' => '',
    'required' => true,
    'value' => ''
  ],
  'last_name' => [
    'type' => 'text',
    'regex' => 'name',
    'label' => '*Last Name',
    'name' => 'last_name',
    'id' => 'last_name',
    'errorMsg' => 'You must enter a valid last name',
    'error' => '',
    'required' => true,
    'value' => ''
  ],
  'email' => [
    'type' => 'text',
    'regex' => 'email',
    'label' => '*Email',
    'name' => 'email',
    'id' => 'email',
    'errorMsg' => 'You must enter a valid email address',
    'error' => '',
    'required' => true,
    'value' => ''
  ],
  'password' => [
    'type' => 'text',
    'regex' => 'password',
    'label' => '*Password',
    'name' => 'password',
    'id' => 'password',
    'errorMsg' => 'Password is required',
    'error' => '',
    'required' => true,
    'value' => ''
  ],
  'status' => [
    'type' => 'select',
    'label' => '*Status',
    'name' => 'status',
    'id' => 'status',
    'errorMsg' => 'You must select a status',
    'error' => '',
    'selected' => '0',
    'required' => true,
    'options' => [
      '0' => 'Please Select Status',
      'staff' => 'Staff',
      'admin' => 'Admin'
    ]
  ],
  'masterStatus' => [
    'error' => false
  ]
];

$stickyForm = new StickyForm();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formConfig = $stickyForm->validateForm($_POST, $formConfig);
  
  if (!$stickyForm->hasErrors() && $formConfig['masterStatus']['error'] == false) {
    $pdo = new PdoMethods();
    
    // Check duplicate email
    $check = $pdo->selectBinded("SELECT * FROM admins WHERE email=:email", [ [':email', $_POST['email'], 'str'] ]);
    
    if ($check && count($check) > 0) {
      $acknowledgment = '<p style="color:red">Email already exists</p>';
    } else {
      $sql = "INSERT INTO admins (first_name, last_name, email, password, status)
        VALUES (:first_name, :last_name, :email, :password, :status)";

      $bindings = [
        [':first_name', $_POST['first_name'], 'str'],
        [':last_name', $_POST['last_name'], 'str'],
        [':email', $_POST['email'], 'str'],
        [':password', password_hash($_POST['password'], PASSWORD_DEFAULT), 'str'],
        [':status', $_POST['status'], 'str']
      ];
      
      $result = $pdo->otherBinded($sql, $bindings);
      
      if ($result === 'error') {
        $acknowledgment = '<p style="color:red">There was an error adding the admin</p>';
      } else {
        $_SESSION['acknowledgment'] = '<p style="color:green">Admin Added</p>';
        header("Location: index.php?page=addAdmin");
        exit;
      }
    }
  }
}
?>