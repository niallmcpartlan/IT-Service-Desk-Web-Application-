<?php

session_start();                     // Starts a session so we can store user login data
require 'dbConnection.php';          // Includes your database connection file where creds are stored

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);   // Extracts the username and removes extra spaces
    $password = trim($_POST['password']);   // Extracts the password and removes extra spaces

    // Prepare a secure SQL query to find the user by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?"); //WHERE only correct userId is being modified 
    $stmt->execute([$username]);            // Executes the query with the username
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the user record 

    // Check if the user exists AND the password matches the hashed password in the database
    if ($user && password_verify($password, $user['password'])) { // don't skip on password verify** secure comparison

        // Store important user details in the session
        $_SESSION['user_id'] = $user['id'];         // User ID
        $_SESSION['role_id'] = $user['role_id'];    // User role (admin/user)
        $_SESSION['username'] = $user['username'];  // Username

        // Redirect to your existing website homepage
        header("Location: index.html");
        exit;                                       // Stops the script after redirect

    } else {
        $error = "Invalid username or password";    // Error message for incorrect login
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">                          <!-- Sets character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                    
    <title>Login - SRC Solutions </title>             

    <style>
        /* Basic page styling */
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Login box container */
        .container {
            max-width: 400px;                       /* Limits width for desktop */
            margin: 60px auto;                      /* Centers the box */
            background: #fff;
            padding: 25px;
            border-radius: 10px;                    /* Rounded corners */
            box-shadow: 0 0 12px rgba(0,0,0,0.1);   /* Soft shadow */
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        /* Labels above inputs */
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        /* Input fields */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        /* Login button */
        button {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background: #181a3afd;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;                    /* Darker blue on hover */
        }

        /* Error message styling */
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .container {
                margin: 20px;                       /* Smaller margins on mobile */
                padding: 20px;
            }

            h2 {
                font-size: 22px;                    /* Slightly smaller title */
            }

            button {
                font-size: 16px;                    /* Adjust button size */
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Welcome!</h2>
    <h2>The SRC Solutions IT HelpDesk</h2>
    <h3>Login</h3>

    <!-- Display error message if login fails -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <!-- Login form -->
    <form action="login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>   <!-- Username input -->

        <label>Password</label>
        <input type="password" name="password" required> <!-- Password input -->

        <button type="submit">Login</button>            <!-- Submit button -->
    </form>
</div>

</body>
</html>