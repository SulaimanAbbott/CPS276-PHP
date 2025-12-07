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
    'address' => [
        'type' => 'text',
        'regex' => 'address',
        'label' => '*Address',
        'name' => 'address',
        'id' => 'address',
        'errorMsg' => 'You must enter a valid address',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'city' => [
        'type' => 'text',
        'regex' => 'city',
        'label' => '*City',
        'name' => 'city',
        'id' => 'city',
        'errorMsg' => 'You must enter a valid city',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'state' => [
        'type' => 'select',
        'label' => '*State',
        'name' => 'state',
        'id' => 'state',
        'errorMsg' => 'You must select a state',
        'error' => '',
        'selected' => '0',
        'required' => true,
        'options' => [
            '0' => 'Please Select a State',
            'ca' => 'California',
            'tx' => 'Texas',
            'mi' => 'Michigan',
            'ny' => 'New York',
            'fl' => 'Florida'
        ]
    ],
    'zip' => [
        'type' => 'text',
        'regex' => 'zip',
        'label' => '*Zip',
        'name' => 'zip',
        'id' => 'zip',
        'errorMsg' => 'You must enter a valid 5-digit zip code',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'phone' => [
        'type' => 'text',
        'regex' => 'phone',
        'label' => '*Phone',
        'name' => 'phone',
        'id' => 'phone',
        'errorMsg' => 'You must enter a valid phone number (999.999.9999)',
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
    'dob' => [
        'type' => 'text',
        'regex' => 'dob',
        'label' => '*Date of Birth (mm/dd/yyyy)',
        'name' => 'dob',
        'id' => 'dob',
        'errorMsg' => 'Date of birth must be mm/dd/yyyy',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'age' => [
        'type' => 'radio',
        'label' => '*Age Range',
        'name' => 'age',
        'id' => 'age',
        'errorMsg' => 'You must select an age range',
        'error' => '',
        'required' => true,
        'options' => [
            ['value' => '0-17', 'label' => '0-17', 'checked' => false],
            ['value' => '18-30', 'label' => '18-30', 'checked' => false],
            ['value' => '30-50', 'label' => '30-50', 'checked' => false],
            ['value' => '50+', 'label' => '50+', 'checked' => false]
        ]
    ],
    'contact' => [
        'type' => 'checkbox',
        'label' => 'Contact Options',
        'name' => 'contact',
        'id' => 'contact',
        'errorMsg' => '',
        'error' => '',
        'required' => false,
        'options' => [
            ['value' => 'Newsletter', 'label' => 'Newsletter', 'checked' => false],
            ['value' => 'Email', 'label' => 'Email', 'checked' => false],
            ['value' => 'Text', 'label' => 'Text', 'checked' => false]
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
    
    $sql = "INSERT INTO contacts (fname, lname, address, city, state, zip, phone, email, dob, age, contact)
            VALUES (:fname, :lname, :address, :city, :state, :zip, :phone, :email, :dob, :age, :contact)";
    
    $bindings = [
      [':fname', $_POST['first_name'], 'str'],
      [':lname', $_POST['last_name'], 'str'],
      [':address', $_POST['address'], 'str'],
      [':city', $_POST['city'], 'str'],
      [':state', $_POST['state'], 'str'],
      [':zip', $_POST['zip'], 'str'],
      [':phone', $_POST['phone'], 'str'],
      [':email', $_POST['email'], 'str'],
      [':dob', $_POST['dob'], 'str'],
      [':age', $_POST['age'], 'str'],
      [':contact', implode(',', $_POST['contact'] ?? []), 'str']
    ];
    
    $result = $pdo->otherBinded($sql, $bindings);
    
    if ($result === 'error') {
      $acknowledgment = '<p style="color:red">There was an error adding the record</p>';
    } else {
      $_SESSION['acknowledgment'] = '<p style="color:green">Contact Information Added</p>';
      header("Location: index.php?page=addContact");
      exit;
    }
  }
}
?>