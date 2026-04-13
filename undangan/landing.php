<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Undangan Pernikahan – Zhidan & Suci</title>
  <link rel="stylesheet" href="output.css" />
  <!-- Google Fonts: Playfair Display (serif) + Dancing Script (script) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Dancing+Script:wght@500;700&family=IM+Fell+English:ital@0;1&display=swap"
    rel="stylesheet" />
</head>

<body>

  <!-- =============================================
       MAIN INVITATION CONTENT
  ============================================== -->
  <main id="mainContent" class="main visible" aria-hidden="false">

    <!-- NAVIGATION -->
    <nav class="nav" id="nav">
      <ul class="nav__list">
        <li><a href="#couple" class="nav__link">Mempelai</a></li>
        <li><a href="#story" class="nav__link">Kisah</a></li>
        <li><a href="#gallery" class="nav__link">Galeri</a></li>
        <li><a href="#events" class="nav__link">Acara</a></li>
        <li><a href="#countdown" class="nav__link">Hitung Mundur</a></li>
        <li><a href="#rsvp" class="nav__link">RSVP</a></li>
        <li><a href="#wishes" class="nav__link">Doa &amp; Ucapan</a></li>
      </ul>
    </nav>

    <!-- ── SECTION 1: HERO ── -->
    <section id="hero" class="section section--hero fade-in bg-[#5c4b3b] text-[#fdf6e3] text-center py-20">
      <div class="section__noise"></div>
      <div class="hero__inner mx-auto">
        <p class="hero__eyebrow text-[#d6c7a1] italic">
          Bismillahirrahmanirrahim
        </p>
        <div class="hero__ornament-line text-yellow-500">
          <span>✦</span>
        </div>
        <h2 class="hero__names script text-4xl md:text-6xl font-bold">
          Zhidan Saaba<br />
          <span class="hero__ampersand text-yellow-400">&amp;</span><br />
          Suci Ramadina
        </h2>
        <p class="hero__tagline text-[#d6c7a1] mt-4">
          Kami mengundang Anda untuk menjadi saksi<br />
          ikatan suci pernikahan kami
        </p>
        <div class="hero__date-badge border border-yellow-500 px-6 py-3 mt-6 inline-block">
          <span class="badge__day">Sabtu</span>
          <span class="badge__number text-yellow-300 font-bold">20</span>
          <span class="badge__month">Februari 2027</span>
        </div>
        <div class="hero__stripe mt-6 text-yellow-400 text-sm">
          <span>★</span><span>All You Need Is Love</span><span>★</span>
          <span>★</span><span>Here Comes the Sun</span><span>★</span>
          <span>★</span><span>Something</span><span>★</span>
        </div>
      </div>
    </section>

    <!-- ── SECTION 2: BRIDE & GROOM ── -->
    <section id="couple" class="section section--couple fade-in">
      <div class="section__inner px-4">
        <div class="section__label">— Mempelai —</div>
        <h2 class="section__title">Dua Jiwa, Satu Ikatan</h2>
        <p class="section__intro">
          Dengan memohon rahmat dan ridho Allah Subhanahu Wa Ta'ala, kami bermaksud
          menyelenggarakan pernikahan putra-putri kami:
        </p>

        <div class="couple__cards flex flex-wrap md:flex-nowrap items-center justify-center gap-8">
          <!-- Groom -->
          <div class="couple__card">
            <div class="couple__photo-frame w-[200px] h-[240px] mx-auto mb-4">
              <img class="couple__photo" src="../assets/groom.webp" alt="Zhidan Saaba"
                onerror="this.style.display='none'" />
              <div class="couple__photo-placeholder">
                <span class="placeholder__icon">♂</span>
                <span class="placeholder__text">Foto Mempelai Pria</span>
              </div>
            </div>
            <div class="couple__info">
              <p class="couple__role">Mempelai Pria</p>
              <h3 class="couple__name script">Zhidan Saaba</h3>
              <p class="couple__parents">
                Putra dari Bapak Fulan<br />
                &amp; Ibu Fulanah
              </p>
            </div>
          </div>

          <!-- Divider -->
          <div class="couple__divider flex flex-col items-center gap-2 px-2">
            <div class="divider__line"></div>
            <div class="divider__heart">♥</div>
            <div class="divider__line"></div>
          </div>

          <!-- Bride -->
          <div class="couple__card couple__card--bride">
            <div class="couple__photo-frame w-[200px] h-[240px] mx-auto mb-4">
              <img class="couple__photo" src="../assets/bride.webp" alt="Suci Ramadina"
                onerror="this.style.display='none'" />
              <div class="couple__photo-placeholder">
                <span class="placeholder__icon">♀</span>
                <span class="placeholder__text">Foto Mempelai Wanita</span>
              </div>
            </div>
            <div class="couple__info">
              <p class="couple__role">Mempelai Wanita</p>
              <h3 class="couple__name script">Suci Ramadina</h3>
              <p class="couple__parents">
                Putri dari Bapak Fulan<br />
                &amp; Ibu Fulanah
              </p>
            </div>
          </div>
        </div>

        <!-- Quranic verse -->
        <blockquote class="couple__verse">
          <p>
            "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu istri-istri
            dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan
            dijadikan-Nya di antaramu rasa kasih dan sayang."
          </p>
          <cite>— QS. Ar-Rum : 21 —</cite>
        </blockquote>
      </div>
    </section>

    <!-- ── SECTION 3: LOVE STORY ── -->
    <section id="story" class="section section--story fade-in">
      <div class="section__inner px-4 max-w-3xl mx-auto">
        <div class="section__label">— Kisah Cinta —</div>
        <h2 class="section__title">Our Love Story</h2>
        <p class="section__intro">Perjalanan cinta yang tertulis indah dalam setiap lembar waktu.</p>

        <div class="timeline space-y-6 max-w-2xl mx-auto text-left">

          <div class="timeline__item fade-in flex gap-6">
            <div class="timeline__icon">✿</div>
            <div class="timeline__content">
              <span class="timeline__year">Pertemuan Pertama</span>
              <h3 class="timeline__heading">Awal Mula Sebuah Kisah</h3>
              <p class="timeline__text">
                Takdir mempertemukan dua jiwa dalam sebuah momen yang sederhana namun penuh makna.
                Dari senyum pertama yang tertukar, sebuah cerita indah pun mulai ditulis oleh semesta.
              </p>
            </div>
          </div>

          <div class="timeline__item fade-in">
            <div class="timeline__icon">♬</div>
            <div class="timeline__content">
              <span class="timeline__year">Menjalin Kasih</span>
              <h3 class="timeline__heading">Tumbuh Bersama dalam Cinta</h3>
              <p class="timeline__text">
                Hari demi hari, cinta itu tumbuh seperti melodi yang mengalun lembut — penuh ketulusan,
                kehangatan, dan janji-janji kecil yang dijaga dengan sepenuh hati.
              </p>
            </div>
          </div>

          <div class="timeline__item fade-in">
            <div class="timeline__icon">💍</div>
            <div class="timeline__content">
              <span class="timeline__year">Lamaran</span>
              <h3 class="timeline__heading">Sebuah Janji untuk Selamanya</h3>
              <p class="timeline__text">
                Dengan segenap keberanian dan cinta yang tulus, sebuah cincin kecil menjadi simbol
                dari janji abadi yang akan disempurnakan di hadapan Allah dan para saksi tercinta.
              </p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ── SECTION 4: GALLERY ── -->
    <section id="gallery" class="section section--gallery fade-in">
      <div class="section__inner">
        <div class="section__label">— Galeri Foto —</div>
        <h2 class="section__title">Our Moments</h2>
        <p class="section__intro">Setiap foto menyimpan seribu kenangan yang tak ternilai.</p>

        <div class="gallery__grid">
          <div class="gallery__item gallery__item--tall" data-index="0">
            <img class="gallery__img" src="../assets/journey.webp" alt="Foto 1" data-full="../assets/journey.webp"
              onerror="this.style.display='none'" />
            <div class="gallery__overlay">Kenangan Indah</div>
          </div>
          <div class="gallery__item" data-index="1">
            <img class="gallery__img" src="../assets/proposal.webp" alt="Foto 2" data-full="../assets/proposal.webp"
              onerror="this.style.display='none'" />
            <div class="gallery__overlay">Momen Bahagia</div>
          </div>
          <div class="gallery__item" data-index="2">
            <img class="gallery__img" src="../assets/together.webp" alt="Foto 3" data-full="../assets/together.webp"
              onerror="this.style.display='none'" />
            <div class="gallery__overlay">Bersama Selamanya</div>
          </div>
          <div class="gallery__item gallery__item--wide" data-index="3">
            <img class="gallery__img" src="../assets/firstmeet.webp" alt="Foto 4" data-full="../assets/firstmeet.webp"
              onerror="this.style.display='none'" />
            <div class="gallery__overlay">Kisah Kita</div>
          </div>
        </div>
      </div>
    </section>
    <!-- Lightbox for gallery (hidden until used) -->
    <div id="lightbox" class="lightbox" aria-hidden="true">
      <div class="lightbox__backdrop" id="lightboxClose"></div>
      <div class="lightbox__inner" role="dialog" aria-modal="true" aria-label="Galeri foto">
        <button class="lightbox__btn lightbox__btn--close" id="lightboxBtnClose" aria-label="Tutup">✕</button>
        <button class="lightbox__btn lightbox__btn--prev" id="lightboxPrev" aria-label="Sebelumnya">‹</button>
        <div class="lightbox__stage">
          <img id="lightboxImg" src="" alt="" />
          <div id="lightboxCaption" class="lightbox__caption"></div>
        </div>
        <button class="lightbox__btn lightbox__btn--next" id="lightboxNext" aria-label="Berikutnya">›</button>
      </div>
    </div>

    <!-- ── SECTION 5: EVENT DETAILS ── -->
    <section id="events" class="section section--events fade-in">
      <div class="section__inner">
        <div class="section__label">— Detail Acara —</div>
        <h2 class="section__title">Rangkaian Acara</h2>
        <p class="section__intro">Dengan penuh suka cita, kami mengundang Anda untuk hadir dan memberikan doa restu.</p>

        <div class="events__cards">

          <!-- Akad -->
          <div class="event__card fade-in">
            <div class="event__icon">☪</div>
            <h3 class="event__title">Akad Nikah</h3>
            <div class="event__detail">
              <div class="event__row">
                <span class="event__key">Hari / Tanggal</span>
                <span class="event__val">Sabtu, 20 Februari 2027</span>
              </div>
              <div class="event__row">
                <span class="event__key">Waktu</span>
                <span class="event__val">08.00 – 10.00 WIB</span>
              </div>
              <div class="event__row">
                <span class="event__key">Tempat</span>
                <span class="event__val">Masjid Al-Ikhlas, Jl. Melati No. 12, Pekanbaru</span>
              </div>
            </div>
          </div>

          <!-- Reception -->
          <div class="event__card fade-in">
            <div class="event__icon">🥂</div>
            <h3 class="event__title">Resepsi Pernikahan</h3>
            <div class="event__detail">
              <div class="event__row">
                <span class="event__key">Hari / Tanggal</span>
                <span class="event__val">Sabtu, 20 Februari 2027</span>
              </div>
              <div class="event__row">
                <span class="event__key">Waktu</span>
                <span class="event__val">11.00 – 14.00 WIB</span>
              </div>
              <div class="event__row">
                <span class="event__key">Tempat</span>
                <span class="event__val">Gedung Serba Guna Bunga Melati, Pekanbaru</span>
              </div>
            </div>
          </div>

        </div>

        <!-- Google Maps embed -->
        <div class="events__map fade-in">
          <h3 class="events__map-title">Lokasi Acara</h3>
          <div class="map__frame">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6527398779437!2d101.44740987496914!3d0.5333557636090698!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a8b9e5a3c9a1%3A0x4e8e8e8e8e8e8e8e!2sPekanbaru%2C%20Riau!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
              width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade" title="Lokasi Pernikahan"></iframe>
          </div>
        </div>

      </div>
    </section>

    <!-- ── SECTION 6: COUNTDOWN ── -->
    <section id="countdown" class="section section--countdown fade-in">
      <div class="section__noise"></div>
      <div class="section__inner">
        <div class="section__label" style="color: var(--cream-light);">— Hitung Mundur —</div>
        <h2 class="section__title" style="color: var(--cream-light);">Menuju Hari Bahagia</h2>
        <p class="section__intro" style="color: var(--sepia-light);">20 Februari 2027</p>

        <div class="countdown__grid" id="countdownGrid">
          <div class="countdown__unit">
            <span class="countdown__num" id="cdDays">--</span>
            <span class="countdown__label">Hari</span>
          </div>
          <div class="countdown__sep">:</div>
          <div class="countdown__unit">
            <span class="countdown__num" id="cdHours">--</span>
            <span class="countdown__label">Jam</span>
          </div>
          <div class="countdown__sep">:</div>
          <div class="countdown__unit">
            <span class="countdown__num" id="cdMinutes">--</span>
            <span class="countdown__label">Menit</span>
          </div>
          <div class="countdown__sep">:</div>
          <div class="countdown__unit">
            <span class="countdown__num" id="cdSeconds">--</span>
            <span class="countdown__label">Detik</span>
          </div>
        </div>

        <p id="countdownDone" class="countdown__done" hidden>
          🎊 Hari bahagia telah tiba! Selamat kepada Zhidan &amp; Suci 🎊
        </p>

        <!-- Beatles-inspired record graphic -->
        <div class="countdown__vinyl" aria-hidden="true">
          <div class="mini-vinyl">
            <div class="mini-vinyl__hole"></div>
          </div>
          <p class="countdown__vinyl-text">"In My Life" — The Beatles</p>
        </div>
      </div>
    </section>

    <!-- ── SECTION 7: RSVP ── -->
    <section id="rsvp" class="section section--rsvp fade-in">
      <div class="section__inner">
        <div class="section__label">— Konfirmasi Kehadiran —</div>
        <h2 class="section__title">RSVP</h2>
        <p class="section__intro">
          Mohon konfirmasi kehadiran Anda paling lambat 13 Februari 2027, agar kami dapat mempersiapkan
          segala sesuatunya dengan sebaik-baiknya.
        </p>

        <form id="rsvpForm" class="form mx-auto px-4 max-w-xl" novalidate>
          <!-- Name -->
          <div class="form__group">
            <label for="rsvpName" class="form__label">Nama Lengkap</label>
            <input type="text" id="rsvpName" name="rsvpName" class="form__input px-4 py-3 rounded-md"
              placeholder="Masukkan nama lengkap Anda" required />
          </div>

          <!-- Attendance -->
          <div class="form__group">
            <label class="form__label">Kehadiran</label>
            <div class="form__radio-group flex flex-col md:flex-row md:items-center md:gap-6">
              <label class="form__radio">
                <input type="radio" name="attendance" value="hadir" required />
                <span class="form__radio-box"></span>
                <span>Insya Allah Hadir</span>
              </label>
              <label class="form__radio">
                <input type="radio" name="attendance" value="tidak" />
                <span class="form__radio-box"></span>
                <span>Mohon Maaf, Tidak Bisa Hadir</span>
              </label>
            </div>
          </div>

          <!-- Guest count -->
          <div class="form__group" id="guestCountGroup">
            <label for="guestCount" class="form__label">Jumlah Tamu</label>
            <select id="guestCount" name="guestCount" class="form__select px-4 py-3 rounded-md">
              <option value="1">1 orang</option>
              <option value="2">2 orang</option>
              <option value="3">3 orang</option>
              <option value="4">4 orang</option>
              <option value="5+">5 orang atau lebih</option>
            </select>
          </div>
          <button type="submit" class="btn btn--primary bg-[#5c4b3b] text-[#fdf6e3] hover:bg-[#2b2b2b] py-3 px-4 rounded-md w-full">
            <span>Kirim Konfirmasi</span>
          </button>
        </form>
      </div>
    </section>

    <!-- ── SECTION 8: WISHES & PRAYERS ── -->
    <section id="wishes" class="section section--wishes fade-in">
      <div class="section__inner">
        <div class="section__label">— Doa &amp; Ucapan —</div>
        <h2 class="section__title">Sampaikan Doa &amp; Ucapan</h2>
        <p class="section__intro">
          Doa dan ucapan tulus Anda adalah hadiah terindah bagi kami. Silakan tuliskan pesan Anda di bawah ini.
        </p>

        <form id="wishForm" class="form mx-auto px-4 max-w-xl" novalidate>
          <div class="form__group">
            <label for="wishName" class="form__label">Nama Anda</label>
            <input type="text" id="wishName" name="wishName" class="form__input px-4 py-3 rounded-md" placeholder="Nama Anda" required />
          </div>
          <div class="form__group">
            <label for="wishMessage" class="form__label">Pesan &amp; Doa</label>
            <textarea id="wishMessage" name="wishMessage" class="form__textarea px-4 py-3 rounded-md" rows="4"
              placeholder="Tuliskan doa dan ucapan tulus Anda di sini..." required></textarea>
          </div>
          <button type="submit" class="btn btn--primary bg-[#5c4b3b] text-[#fdf6e3] hover:bg-[#2b2b2b] py-3 px-4 rounded-md w-full">
            <span>Kirim Pesan</span>
          </button>
        </form>

        <!-- Wishes display list -->
        <div class="wishes__list" id="wishesList">
          <!-- Populated by JS -->
        </div>
      </div>
    </section>

    <!-- ── FOOTER ── -->
    <footer class="footer">
      <div class="footer__noise"></div>
      <div class="footer__inner">
        <p class="footer__names script">Zhidan &amp; Suci</p>
        <p class="footer__date">20 · II · 2027</p>
        <div class="footer__divider">
          <span>♪</span> <span>♫</span> <span>♪</span>
        </div>
        <p class="footer__quote">
          "Two hearts, one song — forever in love."
        </p>
        <p class="footer__credit">
          Made with ♥ — Inspired by The Beatles
        </p>
      </div>
    </footer>

  </main><!-- /main -->

  <script src="script.js"></script>
  <!-- Background audio + sound toggle -->
  <audio id="bgAudio" src="../assets/song.mp3" loop preload="auto" aria-hidden="true"></audio>
  <button id="soundToggle" class="btn btn--primary" aria-pressed="false" title="Mute / Unmute" style="position:fixed;right:1rem;bottom:1rem;z-index:120;">🔈</button>

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
      init();
      window.__dpw_bgAudio = audio;
    })();
  </script>
</body>

</html>