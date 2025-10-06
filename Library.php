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
  <title>Spotify - Your Library</title>
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
      height: 100vh;
    }

    .main-content::-webkit-scrollbar {
      width: 8px;
    }

    .main-content::-webkit-scrollbar-thumb {
      background-color: #282727;
      border-radius: 10px;
    }

    .main-content::-webkit-scrollbar-track {
      background: #121212;
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

    .filter-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .filter-buttons button {
      background-color: #2a2a2a;
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .filter-buttons button:hover {
      background-color: #3a3a3a;
    }

    .library-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .library-card {
      background-color: #181818;
      border-radius: 10px;
      width: 225px;
      padding: 15px;
      transition: transform 0.3s;
      cursor: pointer;
    }

    .library-card:hover {
      transform: scale(1.05);
    }

    .library-card img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .library-card .title {
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .library-card .subtitle {
      font-size: 13px;
      color: #b3b3b3;
    }

    .library-card[data-type] {
      display: none;
    }

    .library-card.show {
      display: block;
    }

    .library-section h2 {
      margin-bottom: 20px;
    }

    .library-grid .library-card a {
      text-decoration: none;
      color: white;
      display: block;
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
    <a href="Library.php" class="active">Your Library</a>
    <!-- <a href="#">Create Playlist</a> -->
    <a href="Liked Songs.php">Liked Songs</a>
    <a href="Premium.php">Explore Premium</a>
    <a href="Profile.php">Profile</a>
    <a href="FAQ's.php">FAQs</a>
  </div>

  <div class="main-content">
    <div class="header">
      <div class="header-left">
        <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Spotify Logo"
          width="40">
      </div>

      <div class="header-center">
        <span>🔍</span>
        <input type="text" placeholder="What do you want to play?">
        <span>🕑️</span>
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

   <div class="library-section">
      <h2  style="font-size: 25px;" >Your Library</h2>
      <div class="filter-buttons">
        <button onclick="filterCards('all')">All</button>
        <button onclick="filterCards('playlist')">Playlists</button>
        <button onclick="filterCards('artist')">Artists</button>
        <button onclick="filterCards('album')">Albums</button>
      </div>
      <div class="library-grid">
        <div class="library-card show" data-type="playlist">
          <a href="Liked Songs.html">
          <img src="https://misc.scdn.co/liked-songs/liked-songs-300.png" alt="Liked Songs">
          <div class="title">Liked Songs</div>
          <div class="subtitle">Playlist • 136 songs</div>
          </a>
        </div>
        <div class="library-card show" data-type="playlist">
          <img src="Photos/Reggaeton Mix.png" alt="Reggaeton Mix">
          <div class="title">Reggaeton Mix</div>
          <div class="subtitle">Playlist • Spotify</div>
        </div>
        <div class="library-card show" data-type="artist">
          <img src="Photos/The Weeknd.jpg" alt="The Weeknd">
          <div class="title">The Weeknd</div>
          <div class="subtitle">Artist</div>
        </div>
        <div class="library-card show" data-type="artist">
          <img src="Photos/Justin bieber.jpg" alt="Justin Bieber">
          <div class="title">Justin Bieber</div>
          <div class="subtitle">Artist</div>
        </div>
        <div class="library-card show" data-type="album">
          <img src="Photos/La Criatura.png" alt="Dunki">
          <div class="title">La Criatura</div>
          <div class="subtitle">Album • Nacho</div>
        </div>
        <div class="library-card show" data-type="album">
          <img src="Photos/Aura.png" alt="La Criatura">
          <div class="title">Aura</div>
          <div class="subtitle">Album • Ozuna</div>
        </div>
      </div>
    </div>
  </div>

  <script>
  function filterCards(type) {
    const cards = document.querySelectorAll('.library-card');
    cards.forEach(card => {
      card.classList.remove('show');
      if (type === 'all' || card.dataset.type === type) {
        card.classList.add('show');
      }
    });
  }

  
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