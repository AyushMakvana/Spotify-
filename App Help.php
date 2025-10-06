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
    <title>Spotify - App Help</title>
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
            color: #1DB954;
            font-size: 36px;
            margin-bottom: 10px;
            text-align: center;
        }

        .faqs-description {
            font-size: 16px;
            color: #b3b3b3;
            margin-bottom: 30px;

        }

        .faq-item {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .faq-question {
            padding: 15px 20px;
            cursor: pointer;
            font-weight: bold;
            position: relative;
        }

        .faq-question::after {
            content: '+';
            position: absolute;
            right: 20px;
            font-size: 20px;
        }

        .faq-item.active .faq-question::after {
            content: '-';
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            padding: 0 20px;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 15px 20px;
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

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Spotify Logo" width="40">
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
            <h1>FAQs / App Help</h1>
            <p class="faqs-description">Find answers and troubleshoot issues related to Spotify's application features. Get answers to common questions about using the app across devices and customize your listening experience.</p>

            <div class="faq-item">
                <div class="faq-question">Locate song lyrics</div>
                <div class="faq-answer">
                    You can find song lyrics by playing a song and scrolling down in the Now Playing view. Not all songs have lyrics available.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Update your Accessibility settings</div>
                <div class="faq-answer">
                    Go to your device settings > Accessibility > Spotify and adjust text size or screen reader preferences as needed.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Spotify skipping</div>
                <div class="faq-answer">
                    Make sure your app is updated, check your network connection, and clear your cache to fix skipping issues.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                item.parentElement.classList.toggle('active');
            });
        });

         
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
