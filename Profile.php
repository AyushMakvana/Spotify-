<?php
session_start();

// If not logged in, send back to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get name from session (set during login.php)
$username = $_SESSION['name'];
$email = $_SESSION['email'];

$userFirstLetter = strtoupper($username[0]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spotify - Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* --- your CSS unchanged --- */
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

        .profile-content {
            margin-top: 20px;
        }

        .profile-banner {
            background: linear-gradient(to right, #1f1f1f, #000);
            padding: 40px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .profile-banner img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            cursor: pointer;
        }

        .profile-details h1 {
            font-size: 36px;
            font-weight: 700;
            cursor: pointer;
        }

        .profile-details p {
            margin-top: 10px;
            color: #b3b3b3;
            font-weight: 400;
        }

        .section {
            background-color: #181818;
            padding: 20px;
            border-radius: 10px;

        }

        .section h3 {
            margin-bottom: 15px;
        }

        .following-artists {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .artist-card {
            position: relative;
            width: 150px;
            text-align: center;
            overflow: hidden;
            transition: transform 0.3s;
            cursor: pointer;
        }

        .artist-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: block;
        }

        .artist-card:hover {
            transform: scale(1.05);
        }

        .artist-card .play-button {
            position: absolute;
            bottom: 45px;
            right: 10px;
            background-color: #1DB954;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .artist-card:hover .play-button {
            opacity: 1;
        }

        .play-button::before {
            content: '';
            border-style: solid;
            border-width: 8px 0 8px 14px;
            border-color: transparent transparent transparent rgb(0, 0, 0);
            margin-left: 3px;
        }

        .edit-name-group {
    display: none;
    margin-top: 10px;
    gap: 10px;
    flex-direction: row;
    align-items: center;
}
.edit-input {
    padding: 6px 10px;
    border: none;
    border-radius: 20px;
    background-color: #2a2a2a;
    color: white;
    outline: none;
}
.save-button {
    padding: 6px 12px;
    border: none;
    border-radius: 20px;
    background-color: #1DB954;
    color: black;
    font-weight: bold;
    cursor: pointer;
}
.save-button:hover {
    background-color: #1ed760;
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
      <a href="Profile.php" class="active">Profile</a>
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
      </div> <!-- header ends -->

      <div class="profile-content">
          <div class="profile-banner">
              <label for="profilePic">
                  <img id="profileImage" src="Photos/default.jpg" alt="Profile Picture">
              </label>
              <input type="file" id="profilePic" style="display:none;" accept="image/*"
                  onchange="changeProfilePic(event)">

              <div class="profile-details">
                  <p>Profile</p>
                  <!-- Make name clickable -->
                  <h1 id="profileName" onclick="showEditName()">
                      <?php echo htmlspecialchars($username); ?>
                  </h1>
                  <p><?php echo htmlspecialchars($email); ?></p>
                  <div class="edit-name-group" id="editNameGroup">
                      <input type="text" id="nameInput" class="edit-input" placeholder="Enter new name">
                      <button class="save-button" onclick="saveName()">Save Name</button>
                  </div>
                  <p>1 Public Playlist • 2 Following</p>
              </div>
          </div>

          <div class="section">
              <h3>Following Artists</h3>
              <div class="following-artists">
                  <div class="artist-card">
                      <img src="Photos/Ozuna.jpg" alt="Ozuna">
                      <div class="play-button"></div>
                      <p>Ozuna</p>
                      <p style="color:#b3b3b3;">Artist</p>
                  </div>
                  <div class="artist-card">
                      <img src="Photos/Atif Aslam.jpg" alt="Atif Aslam">
                      <div class="play-button"></div>
                      <p>Atif Aslam</p>
                      <p style="color:#b3b3b3;">Artist</p>
                  </div>
              </div>
          </div>
      </div>
  </div>

<script>
  // Save new name
  function saveName() {
      const nameInput = document.getElementById('nameInput').value.trim();
      if (nameInput) {
          document.getElementById('profileName').textContent = nameInput;
      }
      document.getElementById('editNameGroup').style.display = 'none';
      document.getElementById('nameInput').value = '';
  }

  // Change profile picture preview
  function changeProfilePic(event) {
      const reader = new FileReader();
      reader.onload = function () {
          document.getElementById('profileImage').src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
  }

  // Show edit name input
  function showEditName() {
      document.getElementById('editNameGroup').style.display = 'flex';
      document.getElementById('nameInput').focus();
  }

  // Dropdown toggle
  const profileBtn = document.getElementById("profile-btn");
  const dropdown = document.getElementById("profileDropdown");
  profileBtn.addEventListener("click", () => {
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  });

  // Hide dropdown if clicked outside
  window.addEventListener("click", (e) => {
      if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.style.display = "none";
      }
  });
</script>
</body>
</html>
