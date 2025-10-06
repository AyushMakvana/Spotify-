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
    <title>Spotify - Home</title>
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

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #000;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #ffffffff;
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

        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-center {
            display: flex;
            align-items: center;
            background-color: #2a2a2a;
            border-radius: 30px;
            padding: 5px 10px;
            width: 400px;
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

        /* Sections */
        h3.section-title {
            font-size: 25px;
            margin: 40px 0 15px;
        }

        /* Card Section */
        .cards-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .cards {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 0;
            width: 100%;
        }

        .cards::-webkit-scrollbar {
            display: none;
        }

        .card {
            flex: 0 0 auto;
            width: 200px;
            background-color: #181818;
            border-radius: 10px;
            padding: 10px;
            transition: transform 0.3s;
            text-align: center;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 17px;
        }

        /* Slider Buttons */
        .slide-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background 0.3s;
            z-index: 2;
        }

        .slide-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .slide-btn.left {
            left: -20px;
        }

        .slide-btn.right {
            right: -20px;
        }

         .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #181818;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 17px;
        }

        .cards a {
            text-decoration: none;
            color: white;
            display: block;
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

        .cards-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .cards-wrapper:hover .slide-btn {
            opacity: 1;
            pointer-events: all;
        }

        .cards.scrollable {
            overflow-x: auto;
            white-space: nowrap;
            scroll-behavior: smooth;
            display: flex;
            gap: 20px;
            width: 100%;
            padding: 10px 0;
        }

        .cards.scrollable::-webkit-scrollbar {
            display: none;
        }

        .card {
            flex: 0 0 auto;
            width: 230px;
        }

        .slide-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background-color 0.3s, opacity 0.3s;
            opacity: 0;
            pointer-events: none;
        }

        .slide-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .slide-btn.left {
            left: -20px;
        }

        .slide-btn.right {
            right: -20px;
        }

        /* Add this to your CSS */
#auth-buttons {
    display: flex;
    align-items: center;
    gap: 10px; /* space between buttons */
}
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Spotify</h1>
        <a href="Home.php">Home</a>
        <a href="Search.php">Search</a>
        <a href="Library.php">Your Library</a>
        <a href="LikedSongs.php">Liked Songs</a>
        <a href="Premium.php">Explore Premium</a>
        <a href="Profile.php">Profile</a>
        <a href="FAQs.php">FAQs</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
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

        <!-- Popular Playlists -->
        <h3 class="section-title">Popular Playlists</h3>
        <div class="cards-wrapper">
            <button class="slide-btn left" onclick="slideLeft('playlists')">&#10094;</button>
            <div class="cards" id="playlists">
                <a href="Daily Mix 1.php" class="card"><img src="Photos/Daily Mix 1.jpg"><h3>Daily Mix 1</h3></a>
                <a href="#" class="card"><img src="Photos/Darshan Raval Mix.png"><h3>Darshan Raval Mix</h3></a>
                <a href="#" class="card"><img src="Photos/Hindi Mix.png"><h3>Hindi Mix</h3></a>
                <a href="#" class="card"><img src="Photos/New Music Hindi.jpg"><h3>New Music Hindi</h3></a>
                <a href="#" class="card"><img src="Photos/Mega Hit Mix.png"><h3>Mega Hit Mix</h3></a>
            </div>
            <button class="slide-btn right" onclick="slideRight('playlists')">&#10095;</button>
        </div>

        <!-- Popular Artists -->
        <h3 class="section-title">Popular Artists</h3>
        <div class="cards-wrapper">
            <button class="slide-btn left" onclick="slideLeft('artists')">&#10094;</button>
            <div class="cards" id="artists">
                <a href="Arijit Singh.php" class="card"><img src="Photos/Arijit.jpg"><h3>Arijit Singh</h3></a>
                <a href="#" class="card"><img src="Photos/Shreya.jpg"><h3>Shreya Ghoshal</h3></a>
                <a href="#" class="card"><img src="Photos/Justin bieber.jpg"><h3>Justin Bieber</h3></a>
                <a href="#" class="card"><img src="Photos/The Weeknd.jpg"><h3>The Weeknd</h3></a>
                <a href="#" class="card"><img src="Photos/Taylor Swift.jpg"><h3>Taylor Swift</h3></a>
            </div>
            <button class="slide-btn right" onclick="slideRight('artists')">&#10095;</button>
        </div>
    </div>

    <!-- JS -->
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
