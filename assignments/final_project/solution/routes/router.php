<?php
$path = "index.php?page=login";

// determine requested page (default to login)
$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'addContact':
        require_once 'includes/security.php';
        require_once 'views/addContactForm.php';
        $content = init();
        break;

    case 'deleteContacts':
        require_once 'includes/security.php';
        require_once 'views/deleteContactsTable.php';
        $content = init();
        break;

    case 'welcome':
        require_once 'includes/security.php';
        require_once 'views/welcome.php';
        $content = init();
        break;

    case 'addAdmin':
        require_once 'includes/security.php';
        require_once 'views/addAdminForm.php';
        $content = init();
        break;

    case 'deleteAdmins':
        require_once 'includes/security.php';
        require_once 'views/deleteAdminsTable.php';
        $content = init();
        break;

    case 'login':
        require_once 'views/loginForm.php';
        $content = init();
        break;

    default:
        // redirect to login if page not recognized
        header("Location: $path");
        exit;
}
?>