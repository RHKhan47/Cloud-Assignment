<?php
// User login script.  Authenticates a user and starts a session.

session_start();
require 'config.php';

$errors = [];

// If the form is submitted, process credentials.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Retrieve the user record based on the supplied username.
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verify credentials.
    if ($user && password_verify($password, $user['password'])) {
        // Store user information in the session.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;

        // Redirect to the quiz page after successful login.
        header('Location: index.php');
        exit;
    } else {
        $errors[] = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <!-- Display any errors -->
    <?php foreach ($errors as $error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endforeach; ?>

    <form method="post" action="login.php">
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
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</body>
</html>