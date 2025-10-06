<?php
session_start();

// ======================
// Database connection
// ======================
$host = "localhost";
$user = "root";   // change if needed
$pass = "";       // change if needed
$dbname = "spotifydb"; // your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// ======================
// Handle form submission
// ======================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST["Email"]));
    $password = htmlspecialchars(trim($_POST["Password"]));
    $name = htmlspecialchars(trim($_POST["Name"]));
    $year = intval($_POST["year"]);
    $month = $_POST["month"];
    $day = intval($_POST["day"]);
    $gender = htmlspecialchars(trim($_POST["Gender"] ?? ''));
    $shareData = isset($_POST["shareData"]) ? 1 : 0;
    $tandc = isset($_POST["tandc"]) ? 1 : 0;

    // Month mapping
    $months = [
        "January" => "01", "February" => "02", "March" => "03",
        "April" => "04", "May" => "05", "June" => "06",
        "July" => "07", "August" => "08", "September" => "09",
        "October" => "10", "November" => "11", "December" => "12"
    ];

    // Validation
    if (!$email || !$password || !$name || !$year || !$month || !$day || !$gender) {
        $error = "❌ Error: All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Invalid email format!";
    } elseif (!isset($months[$month])) {
        $error = "❌ Invalid month selected!";
    } elseif (!checkdate((int)$months[$month], $day, $year)) {
        $error = "❌ Invalid date of birth!";
    } else {
        $dob = sprintf("%04d-%02d-%02d", $year, $months[$month], $day);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "❌ Error: Email already registered!";
        } else {
            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO users (email, password, name, dob, gender, share_data, tandc) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssii", $email, $hashedPassword, $name, $dob, $gender, $shareData, $tandc);

            if ($stmt->execute()) {
                $success = "✅ Registration Successful! Welcome, $name.";
                // Redirect to login after 2 seconds
                header("refresh:2;url=login.php");
            } else {
                $error = "❌ Database Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Spotify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* keep your full CSS here */
        body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: linear-gradient(to bottom, #1f1f1f, #000000);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .logo { width: 60px; margin: 0 auto 30px; display: block; }
        .container { background-color: #121212; padding: 40px 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8); width: 680px; box-sizing: border-box; }
        h1 { text-align: center; margin-bottom: 20px; font-size: 30px; }
        label { display: block; font-size: 14px; margin: 12px 0 6px; font-weight: bold; }
        small { font-size: 12px; color: #b3b3b3; display: block; margin-bottom: 15px; }
        input[type="text"], input[type="password"], select { width: 100%; padding: 10px; background-color: #121212; border: 1px solid white; color: white; border-radius: 4px; box-sizing: border-box; transition: border 0.3s ease; margin-bottom: 20px; }
        input[type="text"]:hover, input[type="password"]:hover, select:hover { border: 1px solid #1DB954; }
        .dob-group { display: flex; gap: 10px; margin-bottom: 20px; }
        .dob-group input, .dob-group select { flex: 1; margin-bottom: 0; }
        .gender-options { display: flex; flex-wrap: wrap; gap: 15px; margin: 10px 0 30px; }
        .gender-options label { font-weight: normal; align-items: center; gap: 5px; cursor: pointer; }
        input[type="submit"] { width: 100%; padding: 12px; background-color: #1DB954; border: none; color: black; font-weight: bold; border-radius: 30px; cursor: pointer; font-size: 16px; margin-top: 20px; transition: transform 0.3s ease, background-color 0.3s ease; }
        input[type="submit"]:hover { background-color: #1ed760; transform: scale(1.05); }
        p { font-size: 13px; color: #b3b3b3; text-align: center; margin-top: 20px; }
        a { color: white; font-weight: bold; text-decoration: none; margin-left: 5px; }
        a:hover { text-decoration: underline; color: #1DB954; }
        .message { text-align:center; margin:15px 0; font-weight:bold; }
        .error { color:#f15e6c; }
        .success { color:#1ed760; }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Spotify_icon.svg" alt="Spotify Logo" class="logo">
        </div>

        <?php if (!empty($error)): ?>
            <div class="message error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="message success"><i class="fa-solid fa-circle-check"></i> <?= $success ?></div>
        <?php endif; ?>

        <form action="signup.php" method="post" novalidate>
            <h1>Sign up to start listening</h1>

            <label for="Email">Email address</label>
            <input type="text" name="Email" id="Email" placeholder="name@domain.com" required>

            <label for="Password">Password</label>
            <input type="password" name="Password" id="Password" placeholder="Password" required>

            <label for="Name">Name</label>
            <small>This name will appear on your profile.</small>
            <input type="text" id="Name" name="Name" placeholder="Name" required>

            <label>Date of birth</label>
            <div class="dob-group">
                <input type="text" name="year" id="dobYear" placeholder="yyyy" required>
                <select name="month" id="dobMonth" required>
                    <option value="" disabled selected>Month</option>
                    <option>January</option><option>February</option><option>March</option>
                    <option>April</option><option>May</option><option>June</option>
                    <option>July</option><option>August</option><option>September</option>
                    <option>October</option><option>November</option><option>December</option>
                </select>
                <input type="text" name="day" id="dobDay" placeholder="dd" required>
            </div>

            <label>Gender</label>
            <div class="gender-options">
                <label><input type="radio" name="Gender" value="Male" required> Man</label>
                <label><input type="radio" name="Gender" value="Female" require> Woman</label>
                <label><input type="radio" name="Gender" value="Other" require> Non-binary</label>
                <label><input type="radio" name="Gender" required> Prefer not to say</label>
            </div>

            <div class="checkbox-group">
                <label><input type="checkbox" name="shareData"> I agree to share my registration data with Spotify's content providers.</label>
            </div>

            <div class="checkbox-group">
                <label><input type="checkbox" name="tandc" required> I agree to the Terms and Conditions and Privacy Policy.</label>
            </div>

            <input type="submit" value="Sign up">
            <p>Have an account? <a href="login.php">Log in</a></p>
        </form>
    </div>
</body>
</html>
