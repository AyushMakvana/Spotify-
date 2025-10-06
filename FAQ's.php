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
    <title>Spotify - FAQs</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #121212;
            color: white;
            display: flex;
            height: 100vh;
            overflow: hidden;
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
            color: #1DB954;
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
            padding-bottom: 60px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
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

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .signup-button {
            text-decoration: none;
            color: #b3b3b3;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            background: none;
            border: none;
            transition: color 0.3s;
        }

        .signup-button:hover {
            color: white;
        }

        .login-button {
            text-decoration: none;
            color: black;
            background-color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.3s;
        }

        .login-button:hover {
            transform: scale(1.1);
        }

        .faqs-section {
            background-color: #181818;
            color: white;
            padding: 40px;
            border-radius: 10px;
        }

        .faqs-section h1 {
            text-align: center;
            font-size: 36px;
            font-weight: 900;
            color: #1DB954;
        }

        .faqs-section p {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #b3b3b3;
        }

        /* .faqs-description {
            font-size: 16px;
           
            margin-bottom: 30px;
        } */

        .faq-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
        }

        .faq-card {
            background-color: #282828;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            width: 300px;
        }

        .faq-card:hover {
            transform: translateY(-5px);
        }

        .faq-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #1DB954;
        }

        .faq-card p {
            font-size: 15px;
            margin-bottom: 15px;
        }

        .view-button {
            background-color: #1DB954;
            color: black;
            padding: 10px 16px;
            border: none;
            border-radius: 999px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .view-button:hover {
            background-color: #1aa34a;
        }

        .view-button:focus,
        .view-button:active {
            text-decoration: none;
            outline: none;
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
        <a href="Home.php">Home</a>
        <a href="Search.php">Search</a>
        <a href="Library.php">Your Library</a>
        <a href="Liked Songs.php">Liked Songs</a>
        <a href="Premium.php">Explore Premium</a>
        <a href="Profile.php">Profile</a>
        <a href="FAQ's.php">FAQs</a>
    </div>

    <div id="faq" class="main-content">
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

        <div class="faqs-section">
            <h1>FAQs</h1>
            <p>Check the most Frequently Asked Questions before posting. Also includes help on using the Community.</p>

            <div class="faq-grid">
                <div class="faq-card">
                    <h3>🎧 App Help</h3>
                    <p>Learn how to use common app features and troubleshoot issues.</p>
                    <a href="App Help.php" class="view-button">View Articles</a>
                </div>
                <div class="faq-card">
                    <h3>🎵 Plan Help</h3>
                    <p>Manage Trial, Free, or Premium plans including Duo, Family, and Student.</p>
                    <a href="plan-help.html" class="view-button">View Articles</a>
                </div>
                <div class="faq-card">
                    <h3>💳 Payment Help</h3>
                    <p>Find answers for common payment and billing questions.</p>
                    <a href="payment-help.html" class="view-button">View Articles</a>
                </div>
                <div class="faq-card">
                    <h3>📺 Device Help</h3>
                    <p>Troubleshoot the app with gaming devices, TVs, speakers, and more.</p>
                    <a href="device-help.html" class="view-button">View Articles</a>
                </div>
                <div class="faq-card">
                    <h3>👤 Account Help</h3>
                    <p>Get help with logging in, verification, and account settings.</p>
                    <a href="account-help.html" class="view-button">View Articles</a>
                </div>
                <div class="faq-card">
                    <h3>👥 Community Help</h3>
                    <p>Find guidance for getting started here in Spotify Community.</p>
                    <a href="community-help.html" class="view-button">View Articles</a>
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