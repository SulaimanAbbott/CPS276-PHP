<?php
require_once 'classes/Pdo_methods.php';
require_once 'classes/StickyForm.php';

// Initialize classes
$pdo = new PdoMethods();
$form = new StickyForm();

// Form configuration
$formConfig = [
    'firstName' => [
        'type' => 'text',
        'label' => 'First Name',
        'name' => 'firstName',
        'id' => 'first_name',
        'value' => 'Sulaiman',
        'regex' => 'name',
        'required' => true
    ],
    'lastName' => [
        'type' => 'text',
        'label' => 'Last Name',
        'name' => 'lastName',
        'id' => 'last_name',
        'value' => 'Abbott',
        'regex' => 'name',
        'required' => false,
        'errorMsg' => 'Incorrect last name format.'
    ],
    'email' => [
        'type' => 'text',
        'label' => 'Email',
        'name' => 'email',
        'id' => 'email',
        'value' => 'suabbott@wccnet.edu',
        'regex' => 'email',
        'required' => true,
        'errorMsg' => 'Enter a valid email address.'
    ],
    'password1' => [
        'type' => 'text',
        'label' => 'Password',
        'name' => 'password1',
        'id' => 'password1',
        'value' => 'Pass$or1',
        'regex' => 'password',
        'required' => true,
        'errorMsg' => 'Password must be at least 8 characters with 1 uppercase, 1 symbol, and 1 number.'
    ],
    'password2' => [
        'type' => 'text',
        'label' => 'Confirm Password',
        'name' => 'password2',
        'id' => 'password2',
        'value' => 'Pass$or1',
        'required' => true
    ],
    'masterStatus' => ['error' => false]
];

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formConfig = $form->validateForm($_POST, $formConfig);

    $password = $_POST['password1'];
    $confirm = $_POST['password2'];

    if (empty($formConfig['password1']['error']) && $password !== $confirm) {
        $formConfig['password2']['error'] = 'Passwords do not match.';
    }

    // Check for existing email
    $sql = "SELECT email FROM users WHERE email = :email";
    $bindings = [[':email', $_POST['email'], 'str']];
    $result = $pdo->selectBinded($sql, $bindings);
    if ($result !== 'error' && count($result) > 0) {
        $formConfig['email']['error'] = 'Email already exists.';
    }

    // Only insert if all fields are valid
    if (
        empty($formConfig['firstName']['error']) &&
        empty($formConfig['lastName']['error']) &&
        empty($formConfig['email']['error']) &&
        empty($formConfig['password1']['error']) &&
        empty($formConfig['password2']['error']) &&
        !$formConfig['masterStatus']['error']
    ) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first, :last, :email, :password)";
        $bindings = [
            [':first', $_POST['firstName'], 'str'],
            [':last', $_POST['lastName'], 'str'],
            [':email', $_POST['email'], 'str'],
            [':password', $hashedPassword, 'str']
        ];
        $insertResult = $pdo->otherBinded($sql, $bindings);
        if ($insertResult === 'noerror') {
            $message = '<p>Registration successful!</p>';
            foreach ($formConfig as $key => &$element) {
                if (isset($element['value'])) $element['value'] = '';
            }
        } else {
            $message = '<p class="text-danger">Database error. Please try again.</p>';
        }
    }
}

// Render form fields
$firstNameField = $form->renderInput($formConfig['firstName']);
$lastNameField = $form->renderInput($formConfig['lastName']);
$emailField = $form->renderInput($formConfig['email']);
$password1Field = $form->renderInput($formConfig['password1']);
$password2Field = $form->renderInput($formConfig['password2']);

// render user table
$records = $pdo->selectNotBinded("SELECT first_name, last_name, email, password FROM users");
if ($records !== 'error' && count($records) > 0) {
    $rows = '';
    foreach ($records as $row) {
        $rows .= "<tr><td>{$row['first_name']}</td><td>{$row['last_name']}</td><td>{$row['email']}</td><td>{$row['password']}</td></tr>";
    }
    $userTable = <<<HTML
<table class="table table-bordered mt-4">
    <thead>
        <tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th></tr>
    </thead>
    <tbody>
        $rows
    </tbody>
</table>
HTML;
} else {
    $userTable = '<p class="mt-4">No records to display.</p>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sticky Form Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <?php echo $message; ?>
    <form method="post" action="">
        <div class="mb-4 row">
            <div class="col-md-6"><?php echo $firstNameField; ?></div>
            <div class="col-md-6"><?php echo $lastNameField; ?></div>
        </div>
        <div class="mb-4 row">
            <div class="col-md-4"><?php echo $emailField; ?></div>
            <div class="col-md-4"><?php echo $password1Field; ?></div>
            <div class="col-md-4"><?php echo $password2Field; ?></div>
        </div>
        <input type="submit" class="btn btn-primary mt-3" value="Register">
    </form>

    <?php echo $userTable; ?>
</div>
</body>
</html>