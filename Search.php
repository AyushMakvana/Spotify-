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
    <title>Spotify - Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        html, body {
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

        .header-right .signup-button {
            text-decoration: none;
            color: #b3b3b3;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-size: 16px;
            transition: color 0.3s;
            background: none;
        }

        .header-right .signup-button:hover {
            color: white;
        }

        .header-right .login-button {
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

        .header-right .login-button:hover {
            transform: scale(1.1);
        }

        .search-content {
            margin-top: 20px;
        }

        .categories {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .category-button {
            background-color: #2a2a2a;
            padding: 20px 70px;
            border-radius: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            font-size: 20px;
        }

        .category-button:hover {
            background-color: #1DB954;
            transform: scale(1.05);
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
        <a href="Search.php" class="active">Search</a>
        <a href="Library.php">Your Library</a>
        <!-- <a href="#">Create Playlist</a> -->
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
                <span>🖑️</span>
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

        <div class="search-content">
          <h3 style="font-size: 25px;">Browse all</h3><br>
            <div class="categories">
                <div class="category-button">Pop</div>
                <div class="category-button">Hip-Hop</div>
                <div class="category-button">Rock</div>
                <div class="category-button">Jazz</div>
                  <div class="category-button">Hindi</div>
                <div class="category-button">Mood</div>
                <div class="category-button">Workout</div>
                <div class="category-button">Chill</div>
                <div class="category-button">Focus</div>
                <div class="category-button">Bollywood</div>
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
