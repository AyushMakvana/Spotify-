<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the first letter of the user's name
$userFirstLetter = strtoupper($_SESSION['name'][0]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify - Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        html,
        body {
            overflow: auto;
            width: 100%;
        }

        body {
            background-color: #121212;
            color: white;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #000;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 0;
            transition: color 0.3s;
        }

        .sidebar a:hover {
            color: #1DB954;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            max-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left img {
            transition: transform 0.3s;
            cursor: pointer;
        }

        .header-left img:hover {
            transform: scale(1.1);
        }

        .header-center {
            display: flex;
            align-items: center;
            background-color: #2a2a2a;
            border-radius: 30px;
            padding: 5px 10px;
            width: 400px;
            transition: background-color 0.3s;
        }

        .header-center:hover {
            background-color: #3a3a3a;
        }

        .header-center input {
            border: none;
            background: transparent;
            outline: none;
            color: white;
            padding: 8px;
            flex: 1;
        }

        /* .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-right button,
        .header-right span {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .header-right .premium-button {
            margin-right: 30px;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background-color: white;
            color: black;
            font-weight: bold;
            transition: transform 0.3s;
        }

        .header-right .premium-button:hover {
            transform: scale(1.1);
        }

        .header-right .profile-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #1DB954;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: transform 0.3s;
        }

        .header-right .profile-button:hover {
            transform: scale(1.1);
        } */

        .header-right .signup-button {
            margin-right: 10px;
            background: none;
            color: #b3b3b3;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
            border: none;
            font-size: 16px;
            text-decoration: none;
        }

        .header-right .signup-button:hover {
            color: white;
        }

        .header-right .login-button {
            display: inline-block;
            text-align: center;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background-color: white;
            color: black;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .header-right .login-button:hover {
            transform: scale(1.1);
        }

        .plans,
        .comparison,
        .why-premium {
            margin-bottom: 40px;
        }

        .plans {
            display: flex;
            justify-content: space-around;
            gap: 40px;
        }

        .plan-card {
            background-color: #181818;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            transition: border 0.3s;
            border: 2px solid transparent;
        }

        .plan-card h3 {
            margin-bottom: 10px;
        }

        .plan-card p {
            margin-bottom: 5px;
        }

        .plan-card:hover {
            border: 2px solid #1DB954;
        }

        .plan-card button {
            margin-top: 10px;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background-color: #1DB954;
            color: rgb(0, 0, 0);
            font-weight: bold;
            transition: transform 0.3s;
        }

        .plan-card button:hover {
            transform: scale(1.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
        }

        th:first-child {
            text-align: left;
            padding-left: 10px;
        }

        th {

            background-color: #1DB954;
            color: #000;
        }

        tr:hover {
            background-color: #282828;
        }

        td {
            border-bottom: 1px solid #333;
        }

        td:first-child {
            text-align: left;
            padding-left: 10px;
        }

        .why-premium {
            display: flex;
            justify-content: space-between;
            gap: 20px;

        }

        .why-card {
            background-color: #181818;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            transition: border 0.3s;
            border: 2px solid transparent;

        }

        .why-card:hover {
            border: 2px solid #1DB954;
        }

        .why-card h4 {
            color: #1DB954;
            margin-bottom: 10px;
        }

        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background-color: #282727;
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-track {
            background-color: #121212;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .premium-button {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background-color: white;
            color: black;
            font-weight: bold;
            transition: transform 0.3s;
        }

        .premium-button:hover {
            transform: scale(1.1);
        }

        .profile-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #1DB954;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
        }

        /* Dropdown */
        .profile-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: #282828;
            border-radius: 8px;
            min-width: 150px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        .profile-dropdown a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .profile-dropdown a:hover {
            background-color: #3a3a3a;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h1>Spotify</h1>
        <a href="home.php">Home</a>
        <a href="Search.php">Search</a>
        <a href="Library.php">Your Library</a>
        <!-- <a href="#">Create Playlist</a> -->
        <a href="Liked Songs.php">Liked Songs</a>
        <a href="Premium.php" class="active">Explore Premium</a>
        <a href="Profile.php">Profile</a>
        <a href="FAQ's.php">FAQs</a>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg"
                    alt="Spotify Logo" width="40">
            </div>

            <div class="header-center">
                <span>🔍</span>
                <input type="text" placeholder="What do you want to play?">
                <span>🗑️</span>
            </div>

            <div class="header-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                   <a href="Premium.php">
  <button class="premium-button">Explore Premium</button>
</a>

                    <div class="profile-button" id="profile-btn"><?php echo $userFirstLetter; ?></div>
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="Profile.php">Account</a>
                        <a href="logout.php">Log out</a>
                    </div>
                <?php else: ?>
                    <a href="signup.html" class="signup-button">Sign up</a>
                    <a href="login.php" class="login-button">Log in</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="premium-content">
            <h2 style="text-align: center; margin-bottom: 20px;">Explore Spotify Premium</h2>
            <p style="text-align: center; margin-bottom: 40px;">Enjoy ad-free music, offline playback, and more with
                Premium plans made for you.</p>

            <div class="plans">
                <div class="plan-card">
                    <h3>Individual</h3>
                    <p>₹119/month</p>
                    <p>1 account</p>
                    <button>Select</button>
                </div>
                <div class="plan-card">
                    <h3>Duo</h3>
                    <p>₹149/month</p>
                    <p>2 accounts</p>
                    <button>Select</button>
                </div>
                <div class="plan-card">
                    <h3>Family</h3>
                    <p>₹179/month</p>
                    <p>Up to 6 accounts</p>
                    <button>Select</button>
                </div>
                <div class="plan-card">
                    <h3>Student</h3>
                    <p>₹59/month</p>
                    <p>1 account</p>
                    <button>Select</button>
                </div>
            </div>

            <h3 style="text-align: center; margin: 40px 0 20px;">Experience the difference</h3>
            <p style="text-align: center;">Get Premium and enjoy all kinds of great listening. Cancel anytime.</p>

            <table>
                <tr>
                    <th style="text-align: left; padding-left: 10px;">What you get</th>
                    <th>Spotify Free</th>
                    <th>Premium</th>
                </tr>
                <tr>
                    <td>Ad-free music listening</td>
                    <td style="color: red; text-align: center;">✗</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
                <tr>
                    <td>Download songs</td>
                    <td style="color: red; text-align: center;">✗</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
                <tr>
                    <td>Play songs in any order</td>
                    <td style="color: red; text-align: center;">✗</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
                <tr>
                    <td>High quality audio</td>
                    <td style="color: red; text-align: center;">✗</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
                <tr>
                    <td>Listen offline</td>
                    <td style="color: red; text-align: center;">✗</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
                <tr>
                    <td>Organize playlists</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
                <tr>
                    <td>Unlimited skips</td>
                    <td style="color: red; text-align: center;">✗</td>
                    <td style="color: #1DB954; text-align: center;">✓</td>
                </tr>
            </table>

            <h3 style="text-align: center; margin: 40px 0 20px;">Why go Premium?</h3>
            <div class="why-premium">
                <div class="why-card">
                    <h4>No ad interruptions</h4>
                    <p>Enjoy uninterrupted music with no ads.</p>
                </div>
                <div class="why-card">
                    <h4>Download and listen offline</h4>
                    <p>Save your favorite tracks and listen anywhere.</p>
                </div>
                <div class="why-card">
                    <h4>Play any song</h4>
                    <p>Choose and play any track on demand.</p>
                </div>
                <div class="why-card">
                    <h4>High quality audio</h4>
                    <p>Stream music at the highest quality.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function slideLeft(id) {
            document.getElementById(id).scrollLeft -= 300;
        }
        function slideRight(id) {
            document.getElementById(id).scrollLeft += 300;
        }

        // Profile dropdown toggle
        const profileBtn = document.getElementById('profile-btn');
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileBtn) {
            profileBtn.addEventListener('click', () => {
                profileDropdown.style.display =
                    profileDropdown.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', (event) => {
                if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.style.display = 'none';
                }
            });
        }
    </script>

</body>

</html>