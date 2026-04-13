<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cover — Undangan Zhidan &amp; Suci</title>
  <link rel="stylesheet" href="output.css" />
  <!-- Google Fonts: Playfair Display (serif) + Dancing Script (script) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Dancing+Script:wght@500;700&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- COVER / LANDING (terpisah) -->
  <div id="cover" class="cover">
    <div class="cover__noise"></div>
    <div class="cover__inner">
      <div class="cover__ornament top">❧</div>
      <p class="cover__label">The Wedding of</p>
      <h1 class="cover__names">Zhidan<br/><span class="cover__amp">&amp;</span><br/>Suci</h1>
      <p class="cover__date">20 · II · 2027</p>
      <div class="cover__divider"></div>
      <p class="cover__guest-label">Kepada Yth.</p>
      <?php
        // Tampilkan nama tamu (CSS mengatur warna dan kontras)
        $guestName = "Vramroro";
        echo '<h2 class="cover__guest-name">' . htmlspecialchars($guestName, ENT_QUOTES, 'UTF-8') . '</h2>';
      ?>
      <a id="openBtn" href="landing.html" class="btn btn--cover">
        <span>Buka Undangan</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
      </a>
      <div class="cover__ornament bottom">❧</div>
    </div>
    <!-- Vinyl record decoration -->
    <div class="cover__vinyl" aria-hidden="true">
      <div class="vinyl__disc">
        <div class="vinyl__label">
          <span>Parlophone</span>
        </div>
      </div>
    </div>
  </div>

  
  <!-- Background audio + sound toggle -->
  <audio id="bgAudio" src="../assets/song.mp3" loop preload="auto" aria-hidden="true"></audio>
  <button id="soundToggle" class="btn btn--cover" aria-pressed="false" title="Mute / Unmute" style="position:fixed;right:1rem;bottom:1rem;z-index:120;">🔈</button>

  <!-- Click-to-start overlay for browsers that block autoplay with sound -->
  <div id="audioStarter" style="position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.35);z-index:125;">
    <a id="startAudioBtn" href="#" class="btn btn--cover" style="font-size:1rem;padding:1rem 1.5rem;">Klik untuk memulai musik</a>
  </div>

  <script>
    (function(){
      var audio = document.getElementById('bgAudio');
      var btn = document.getElementById('soundToggle');
      var storageKey = 'dpw_sound_muted';
      function init(){
        var saved = localStorage.getItem(storageKey);
        var muted = saved === null ? true : (saved === 'true');
        audio.muted = muted;
        audio.play().catch(function(){});
        updateButton();
      }
      function toggle(){
        audio.muted = !audio.muted;
        localStorage.setItem(storageKey, String(audio.muted));
        updateButton();
      }
      function updateButton(){
        if (!btn) return;
        btn.setAttribute('aria-pressed', String(!audio.muted));
        btn.textContent = audio.muted ? '🔈' : '🔊';
        btn.title = audio.muted ? 'Unmute' : 'Mute';
      }
      if (btn){ btn.addEventListener('click', toggle); }
      function showStarterIfNeeded(){
        var starter = document.getElementById('audioStarter');
        if (!starter) return;
        // show starter when audio is muted (no user gesture yet)
        if (audio.muted){ starter.style.display = 'flex'; }
        else { starter.style.display = 'none'; }
      }

      init();
      showStarterIfNeeded();
      var startBtn = document.getElementById('startAudioBtn');
      if (startBtn){
        startBtn.addEventListener('click', function(e){
          e.preventDefault();
          try { localStorage.setItem(storageKey, 'false'); } catch(e){}
          audio.muted = false;
          audio.play().catch(function(){});
          var starter = document.getElementById('audioStarter'); if (starter) starter.style.display = 'none';
          updateButton();
        });
      }
      window.__dpw_bgAudio = audio;
    })();
  </script>
</body>
</html>