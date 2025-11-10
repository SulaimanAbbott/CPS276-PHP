<?php
// Include necessary classes
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
        'required' => true,
        'errorMsg' => 'First name is required.'
    ],
    'lastName' => [
        'type' => 'text',
        'label' => 'Last Name',
        'name' => 'lastName',
        'id' => 'last_name',
        'value' => 'Abbott',
        'regex' => 'name',
        'required' => false,
        'errorMsg' => 'Only letters, spaces, and apostrophes allowed.'
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
        'required' => true
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

    // Additional validation for first name
    $firstName = $_POST['firstName'] ?? '';
    if (empty($firstName)) {
        $formConfig['firstName']['error'] = 'First name is required.';
        $formConfig['masterStatus']['error'] = true;
    } elseif (!preg_match("/^[a-zA-Z\s']+$/", $firstName)) {
        $formConfig['firstName']['error'] = 'Only letters, spaces, and apostrophes allowed.';
        $formConfig['masterStatus']['error'] = true;
    }

    $password = $_POST['password1'];
    $confirm = $_POST['password2'];

    // Validate password complexity and match
    if (!preg_match('/^(?=.*[A-Z])(?=.*\W)(?=.*\d).{8,}$/', $password)) {
        $formConfig['password1']['error'] = 'Password must be at least 8 characters with 1 uppercase, 1 symbol, and 1 number.';
        $formConfig['masterStatus']['error'] = true;
    } elseif ($password !== $confirm) {
        $formConfig['password2']['error'] = 'Passwords do not match.';
        $formConfig['masterStatus']['error'] = true;
    }

    // Check for existing email
    $sql = "SELECT email FROM users WHERE email = :email";
    $bindings = [[':email', $_POST['email'], 'str']];
    $result = $pdo->selectBinded($sql, $bindings);
    if ($result !== 'error' && count($result) > 0) {
        $formConfig['email']['error'] = 'Email already exists.';
        $formConfig['masterStatus']['error'] = true;
    }

    // If no errors, insert into database
    if (!$formConfig['masterStatus']['error']) {
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

// I'm pre-rendering form fields to reduce redundancy
$firstNameField = $form->renderInput($formConfig['firstName']);
$lastNameField = $form->renderInput($formConfig['lastName']);
$emailField = $form->renderInput($formConfig['email']);
$password1Field = $form->renderInput($formConfig['password1']);
$password2Field = $form->renderInput($formConfig['password2']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sticky Form Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <?php
    $records = $pdo->selectNotBinded("SELECT first_name, last_name, email, password FROM users");
    if ($records !== 'error' && count($records) > 0) {
        echo '<table class="table table-bordered mt-4"><thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th></tr></thead><tbody>';
        foreach ($records as $row) {
            echo "<tr><td>{$row['first_name']}</td><td>{$row['last_name']}</td><td>{$row['email']}</td><td>{$row['password']}</td></tr>";
        }
        echo '</tbody></table>';
    } else {
        echo '<p class="mt-4">No records to display.</p>';
    }
    ?>
</div>
</body>
</html>