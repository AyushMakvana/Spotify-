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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Spotify - Daily Mix</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    html,
    body {
      overflow: hidden;
      width: 100%;
      height: 100%;
    }

    body {
      background-color: #121212;
      color: white;
      display: flex;
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

    .main-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background-color: #181818;
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

    .content {
      display: flex;
      flex: 1;
      overflow: hidden;
    }

    .daily-mix {
      flex: 1;
      overflow-y: auto;
      max-height: calc(100vh - 150px);
      padding-bottom: 30px;
    }

    .daily-mix-banner {
      background: linear-gradient(to bottom, #4b1c94, #121212 100%);
      padding: 20px;
    }

    .daily-mix-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
    }

    .daily-mix-header img {
      width: 200px;
      height: 200px;
      border-radius: 8px;
    }

    .daily-mix-header .info {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .daily-mix-header .info h2 {
      font-size: 80px;
      font-weight: bold;
    }

    .daily-mix-header .info p {
      font-size: 16px;
      color: #d4d4d4;
    }

    .daily-mix::-webkit-scrollbar {
      width: 8px;
    }

    .daily-mix::-webkit-scrollbar-thumb {
      background-color: #282727;
      border-radius: 10px;
    }

    .daily-mix::-webkit-scrollbar-track {
      background: #121212;
    }


    .play-button {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #1DB954;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .play-button:hover {
      background-color: #1ed760;
      transform: scale(1.1);
    }

    .play-button::before {
      content: '';
      display: block;
      width: 0;
      height: 0;
      border-left: 18px solid black;
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
    }

    .song-table {
      width: 100%;
      border-collapse: collapse;
    }

    
    .song-table td , .song-table th{
      padding: 10px;
      text-align:left;
    }


  


    .song-table .detail {
      cursor: pointer;
    }

    .song-table .detail:hover {
      background-color: #282828;
    }

    .song-table th {
      color: #b3b3b3;
      font-weight: normal;
      
    }

    .song-table td small {
      color: #b3b3b3;
    }

    .player-bar {
      position: fixed;
      bottom: 0;
      left: 250px;
      right: 0;
      background-color: #181818;
      padding: 10px 20px;
      border-top: 1px solid #282828;
      z-index: 999;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
    }

    .now-playing {
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
    }

    .now-playing img {
      width: 50px;
      height: 50px;
      border-radius: 4px;
    }

    .player-controls {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 5px;
      flex: 1;
    }

    .control-icons {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .control-icons button {
      background: none;
      border: none;
      color: white;
      font-size: 20px;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .control-icons button:hover {
      transform: scale(1.2);
      color: #1DB954;
    }

    .play-pause {
      width: 45px;
      height: 45px;
      background-color: white;
      color: black;
      border-radius: 50%;
      font-size: 20px;
    }

    .time {
      font-size: 12px;
      color: #b3b3b3;
    }

    #volumeSlider {
      appearance: none;
      height: 4px;
      background: #444;
      border-radius: 2px;
      cursor: pointer;
      width: 120px;
    
      
    }


    #progressBar {
      appearance: none;
      height: 4px;
      background: #444;
      border-radius: 2px;
      cursor: pointer;
      width: 800px;
      
    }

    #progressBar::-webkit-slider-thumb,
    #volumeSlider::-webkit-slider-thumb {
      appearance: none;
      width: 10px;
      height: 10px;
      background: white;
      border-radius: 50%;
      transition: transform 0.3s;
      transition: background-color 0.3s;
    }

    #progressBar::-webkit-slider-thumb:hover,#volumeSlider::-webkit-slider-thumb:hover{
      transform: scale(1.2);
      background-color:#1ed760
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

         #progressBar::-webkit-slider-thumb {
      appearance: none;
      width: 10px;
      height: 10px;
      background: white;
      border-radius: 50%;
      transition: transform 0.3s;

    }

    #progressBar::-webkit-slider-thumb:hover {
      transform: scale(1.2);

    }

    #volumeSlider::-webkit-slider-thumb {
      appearance: none;
      width: 10px;
      height: 10px;
      background: white;
      border-radius: 50%;
      transition: transform 0.3s ease;
    }

    #volumeSlider::-webkit-slider-thumb:hover {
      transform: scale(1.2);

    }


    #progressBar {
      appearance: none;
      width: 800px;
      height: 4px;
      border-radius: 2px;
      background: linear-gradient(to right, #ffffff var(--progress, 0%), #444 var(--progress, 0%));
      cursor: pointer;
      transition: background 0.2s ease;
    }

    #progressBar:hover {
      background: linear-gradient(to right, #1ed760 var(--progress, 0%), #444 var(--progress, 0%));
    }


    #volumeSlider {
      appearance: none;
      width: 120px;
      height: 4px;
      border-radius: 2px;
      background: linear-gradient(to right, #ffffff var(--vol, 80%), #444 var(--vol, 80%));
      cursor: pointer;
      transition: background 0.2s ease;
    }

    #volumeSlider:hover {
      background: linear-gradient(to right, #1ed760 var(--vol, 80%), #444 var(--vol, 80%));
    }
   
  </style>
</head>

<body>

  <div class="sidebar">
    <h1>Spotify</h1>
    <a href="home.php">Home</a>
    <a href="Search.php">Search</a>
    <a href="Library.php">Your Library</a>
    <a href="Liked Songs.php">Liked Songs</a>
    <a href="Premium.php">Explore Premium</a>
    <a href="Profile.php">Profile</a>
    <a href="FAQ's.php">FAQs</a>
  </div>


  <div class="main-container">
    <div class="header">
      <div class="header-left">
        <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Spotify Logo"
          width="40">
      </div>
      <div class="header-center">
        <span>🔍</span><input type="text" placeholder="What do you want to play?"><span>🕑️</span>
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

    <div class="content">
      <div class="daily-mix">
        <div class="daily-mix-banner">
          <div class="daily-mix-header">
            <img src="Photos/Fav.png" alt="Daily Mix Cover">
            <div class="info">
              <p>Playlist</p>
              <h2>Liked Songs</h2>
            <p>dardvail02 • 3 songs</p>
              
             
            </div>
          </div>
          <div class="play-button" id="bannerPlay"></div>
        </div>

        <table class="song-table">
          <thead>
            <tr>
              <th></th>
              <th>Title</th>
              <th>Album</th>
              <th>⏱️</th>
            </tr>
          </thead>
          <tbody>
            <tr data-src="Songs/Duniyaa.mp3" data-title="Duniyaa" data-artist="Akhil, Dhvani Bhanushali" data-cover="Photos/Duniyaa.png" class="detail">
              <td><img src="Photos/Duniyaa.png" alt="Ishq" width="50" style="margin-left: 10px;border-radius: 4px;"></td>
              <td>Duniyaa<br><small>Akhil, Dhvani Bhanushali</small></td>
              <td>Luka Chuppi</td>
              <td>3:42</td>
            </tr>
            <tr data-src="Songs/SATRANGA.mp3" data-title="Satranga" data-artist="Arijit Singh"
              data-cover="Photos/Satranga.png" class="detail">
              <td><img src="Photos/Satranga.png" alt="Satranga" width="50" style="margin-left: 10px;border-radius: 4px;"></td>
              <td>Satranga<br><small>Arijit Singh</small></td>
              <td>ANIMAL</td>
              <td>4:31</td>
            </tr>
            <tr data-src="Songs/With You.mp3" data-title="With You" data-artist="AP Dhillon"
              data-cover="Photos/With you.png" class="detail">
              <td><img src="Photos/With you.png" alt="With you" width="50" style="margin-left: 10px;border-radius: 4px;"></td>
              <td>With You<br><small>AP Dhillon</small></td>
              <td>With You</td>
              <td>2:35</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="player-bar">
    <div class="now-playing">
      <img id="songCover" src="Photos/Duniyaa.png">
      <div>
        <div id="songTitle">Duniyaa</div>
        <div id="songArtist" style="font-size: 12px; color: #b3b3b3;">Akhil, Dhvani Bhanushali</div>
      </div>
    </div>
    <div class="player-controls">
      <div class="control-icons">
        <button><i class="fas fa-random"></i></button>
        <button id="prevBtn"><i class="fas fa-step-backward"></i></button>
        <button id="playPauseBtn" class="play-pause"><i class="fas fa-play"></i></button>
        <button id="nextBtn"><i class="fas fa-step-forward"></i></button>
        <button><i class="fas fa-redo-alt"></i></button>
      </div>
      <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
        <div class="time" id="currentTime">0:00</div>
        <input type="range" id="progressBar" value="0" min="0" max="100" step="1" />
        <div class="time" id="duration">0:00</div>
      </div>
    </div>
    <div style="display: flex; align-items:center; gap: 10px;">
      <i class="fas fa-volume-up"></i>
      <input type="range" id="volumeSlider" min="0" max="1" step="0.01" value="0.8" />
    </div>
  </div>

  <audio id="audioPlayer"></audio>

   <script>
    const audioPlayer = document.getElementById('audioPlayer');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const progressBar = document.getElementById('progressBar');
    const currentTimeEl = document.getElementById('currentTime');
    const durationEl = document.getElementById('duration');
    const rows = document.querySelectorAll('.song-table tbody tr');
    const bannerPlay = document.getElementById('bannerPlay');
    const volumeSlider = document.getElementById('volumeSlider');
    let currentIndex = 0;

    function loadTrack(index) {
      const row = rows[index];
      if (!row) return;
      currentIndex = index;
      audioPlayer.src = row.dataset.src;
      document.getElementById('songTitle').textContent = row.dataset.title;
      document.getElementById('songArtist').textContent = row.dataset.artist;
      document.getElementById('songCover').src = row.dataset.cover;

      // Reset progress bar visually
      progressBar.value = 0;
      progressBar.style.setProperty('--progress', `0%`);
      currentTimeEl.textContent = "0:00";
      durationEl.textContent = "0:00";
    }


    function formatTime(seconds) {
      const m = Math.floor(seconds / 60);
      const s = Math.floor(seconds % 60);
      return `${m}:${s < 10 ? '0' + s : s}`;
    }


    audioPlayer.addEventListener('timeupdate', () => {
      if (!isNaN(audioPlayer.duration)) {
        const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.value = percent;
        progressBar.style.setProperty('--progress', `${percent}%`);
        currentTimeEl.textContent = formatTime(audioPlayer.currentTime);
        durationEl.textContent = formatTime(audioPlayer.duration);
      }
    });


    progressBar.addEventListener('input', () => {
      if (!isNaN(audioPlayer.duration)) {
        audioPlayer.currentTime = (progressBar.value / 100) * audioPlayer.duration;
      }
    });

    playPauseBtn.addEventListener('click', () => {
      const icon = playPauseBtn.querySelector('i');
      if (audioPlayer.paused) {
        audioPlayer.play();
        icon.className = 'fas fa-pause';
      } else {
        audioPlayer.pause();
        icon.className = 'fas fa-play';
      }
    });

    bannerPlay.addEventListener('click', () => {
      loadTrack(0);
      audioPlayer.play();
      playPauseBtn.querySelector('i').className = 'fas fa-pause';
    });

    rows.forEach((row, idx) => {
      row.addEventListener('click', () => {
        loadTrack(idx);
        audioPlayer.play();
        playPauseBtn.querySelector('i').className = 'fas fa-pause';
      });
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
      const prev = (currentIndex - 1 + rows.length) % rows.length;
      loadTrack(prev);
      audioPlayer.play();
      playPauseBtn.querySelector('i').className = 'fas fa-pause';
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
      const next = (currentIndex + 1) % rows.length;
      loadTrack(next);
      audioPlayer.play();
      playPauseBtn.querySelector('i').className = 'fas fa-pause';
    });



    volumeSlider.addEventListener('input', () => {
      const percent = volumeSlider.value * 100;
      audioPlayer.volume = volumeSlider.value;
      volumeSlider.style.setProperty('--vol', `${percent}%`);
    });



    audioPlayer.volume = 0.8;


    volumeSlider.style.setProperty('--vol', `${volumeSlider.value * 100}%`);

    audioPlayer.addEventListener('ended', () => {
      const nextIndex = (currentIndex + 1) % rows.length;
      loadTrack(nextIndex);
      audioPlayer.play();
      playPauseBtn.querySelector('i').className = 'fas fa-pause';
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