<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";   // default XAMPP username
$password = "";       // default XAMPP password is empty
$dbname = "spotifydb";  // make sure you created this DB

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

// Handle login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['Email']);
    $pass = trim($_POST['Password']);

    // Prepare query (prevent SQL injection)
$stmt = $conn->prepare("SELECT id, password, name FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashedPassword, $name);
    $stmt->fetch();

    // Verify password
    if (password_verify($pass, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name; // ✅ store full name from DB
        header("Location: Home.php"); // use PHP file for homepage
        exit();
    } else {
        $error_message = "Invalid password!";
    }
} else {
    $error_message = "No account found with this email!";
}

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Spotify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* --- keep your CSS same as before --- */
        /* body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: linear-gradient(to bottom, #1f1f1f, #000000);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .container { background-color: #121212; width: 600px; padding: 40px 30px; border-radius: 12px; text-align: center; }
        .logo { width: 60px; margin: 0 auto 10px; }
        h1 { font-size: 30px; margin-bottom: 20px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid white; margin-bottom: 15px; border-radius: 4px; background: #121212; color: white; }
        input[type="submit"] { width: 100%; padding: 12px; background-color: #1DB954; border: none; border-radius: 30px; cursor: pointer; font-weight: bold; }*/
        .error { color: #f15e6c; margin-bottom: 10px; } 
         body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: linear-gradient(to bottom, #1f1f1f, #000000);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 30px;
            margin-bottom: 30px;





        }

        .container {
            background-color: #121212;
            width: 600px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;



        }

        .logo {
            width: 60px;
            margin: 0 auto 10px;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .social-btn {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #333;
            background-color: #121212;
            color: white;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .social-btn:hover {
            background-color: #232323;
        }

        .social-icon {
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            padding: 3px;
            object-fit: contain;
        }

        hr {
            border: none;
            border-top: 1px solid #333;
            margin: 25px 0;
        }

        label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin: 10px 0 4px;
        }

        input[type="text"],
        input[type="password"] {

            width: 100%;
            padding: 10px;
            background-color: #121212;
            border: 1px solid white;
            color: white;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border 0.3s ease;
            margin-bottom: 20px;

        }


        input[type="password"]:hover {
            border: 1px solid #1DB954;
        }

        input[type="text"]:hover {

            border: 1px solid #1DB954;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #1DB954;
            border: none;
            color: black;
            font-weight: bold;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 16px;
            transition: transform 0.3s ease, background-color 0.1s ease;
        }

        input[type="submit"]:hover {
            background-color: #1ed760;
            transform: scale(1.05);
        }

        p {
            font-size: 13px;
            color: #b3b3b3;
            margin-top: 20px;
        }

        a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #1DB954;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border: 1px solid white;
            outline: none;

        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #282727;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #121212;
        }



        .error-message {
            color: #f15e6c;
            font-size: 13px;
            display: none;
            align-items: left;
            gap: 6px;
             margin-bottom: 16px;

        }


        .error-message i {
            margin-right: 6px;
        }

        input.error {
            border: 1px solid #f15e6c !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Spotify_icon.svg" alt="Spotify Logo" class="logo">
        <h1>Log in to Spotify</h1>

         <button class="social-btn">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo"
                    class="social-icon">
                Continue with Google
            </button>


            <button class="social-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png"
                    alt="Facebook Logo" class="social-icon">
                Continue with Facebook
            </button>


            <button class="social-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple Logo"
                    class="social-icon">
                Continue with Apple
            </button>

            <hr>


        <?php if (!empty($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <form method="post" action="">
            <label for="Email">Email</label>
            <input type="text" id="Email" name="Email" placeholder="Email" required>

            <label for="Password">Password</label>
            <input type="password" id="Password" name="Password" placeholder="Password" required>

            <input type="submit" value="Log in">
        </form>

        <p>Don't have an account? <a href="signup.php">Sign up for Spotify</a></p>
    </div>
</body>
</html>
