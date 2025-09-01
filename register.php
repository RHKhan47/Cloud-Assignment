<?php
// User registration script.  This page allows a new user to create an account.
// It validates input, checks for existing usernames, and stores hashed passwords.

session_start();
require 'config.php';

$errors = [];

// When the form is submitted, process the input.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm'] ?? '');

    // Simple validation rules.
    if ($username === '' || $password === '' || $confirm === '') {
        $errors[] = 'All fields are required.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    // If no validation errors, continue with database checks.
    if (empty($errors)) {
        // Check if the username already exists.
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username already exists. Please choose another.';
        } else {
            // Hash the password and insert the new user into the database.
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);

            // Redirect to the login page after successful registration.
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Create an Account</h2>
    <!-- Display any validation or processing errors -->
    <?php foreach ($errors as $error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endforeach; ?>

    <form method="post" action="register.php">
        <label>
            Username:<br>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
        </label>
        <br><br>
        <label>
            Password:<br>
            <input type="password" name="password" required>
        </label>
        <br><br>
        <label>
            Confirm Password:<br>
            <input type="password" name="confirm" required>
        </label>
        <br><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>