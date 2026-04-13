/**
 * =====================================================
 *  WEDDING INVITATION — Zhidan & Suci
 *  Vintage Sepia / Beatles 1960s Aesthetic
 *  script.js — All interactive functionality
 * =====================================================
 */

'use strict';

/* ─────────────────────────────────────────────────
   1. COVER / OPEN INVITATION BUTTON
   Fades out the cover overlay and reveals main content.
───────────────────────────────────────────────── */
(function initCover() {
  const openBtn     = document.getElementById('openBtn');
  const cover       = document.getElementById('cover');
  const mainContent = document.getElementById('mainContent');

  if (!openBtn || !cover || !mainContent) return;

  openBtn.addEventListener('click', function () {
    // Mark cover as hidden (CSS transition handles fade-out)
    cover.classList.add('hidden');

    // Make main content accessible and visible
    mainContent.setAttribute('aria-hidden', 'false');
    mainContent.classList.add('visible');

    // After the cover fully fades, remove it from layout flow
    cover.addEventListener('transitionend', function onEnd() {
      cover.style.display = 'none';
      cover.removeEventListener('transitionend', onEnd);
    });

    // Trigger scroll animations for elements already in viewport
    checkFadeIn();
  });
})();


/* ─────────────────────────────────────────────────
   2. SMOOTH SCROLLING NAVIGATION
   Intercepts all internal anchor links.
───────────────────────────────────────────────── */
(function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href').slice(1);
      const target   = document.getElementById(targetId);
      if (!target) return;

      e.preventDefault();

      const navHeight = document.getElementById('nav')
        ? document.getElementById('nav').offsetHeight
        : 0;
      const offsetTop = target.getBoundingClientRect().top
        + window.pageYOffset
        - navHeight
        - 16; // small extra breathing room

      window.scrollTo({ top: offsetTop, behavior: 'smooth' });
    });
  });
})();


/* ─────────────────────────────────────────────────
   3. SCROLL FADE-IN ANIMATION
   Uses IntersectionObserver to trigger .visible on
   elements with the .fade-in class.
───────────────────────────────────────────────── */
function checkFadeIn() {
  const fadeEls = document.querySelectorAll('.fade-in');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target); // animate only once
        }
      });
    }, {
      threshold:  0.12,
      rootMargin: '0px 0px -40px 0px'
    });

    fadeEls.forEach(function (el) { observer.observe(el); });

  } else {
    // Fallback: just show everything
    fadeEls.forEach(function (el) { el.classList.add('visible'); });
  }
}

// Re-run observer after content is revealed
document.addEventListener('DOMContentLoaded', checkFadeIn);


/* ─────────────────────────────────────────────────
   4. REAL-TIME COUNTDOWN TIMER
   Target: 20 February 2027 at 08:00 WIB (UTC+7)
───────────────────────────────────────────────── */
(function initCountdown() {
  // 20 Feb 2027 08:00 WIB = UTC+7 → subtract 7h for UTC
  const WEDDING_DATE = new Date('2027-02-20T01:00:00Z'); // 08:00 WIB in UTC

  const cdDays    = document.getElementById('cdDays');
  const cdHours   = document.getElementById('cdHours');
  const cdMinutes = document.getElementById('cdMinutes');
  const cdSeconds = document.getElementById('cdSeconds');
  const cdGrid    = document.getElementById('countdownGrid');
  const cdDone    = document.getElementById('countdownDone');

  if (!cdDays) return;

  // Pad a number to two digits
  function pad(n) {
    return String(n).padStart(2, '0');
  }

  function updateCountdown() {
    const now  = new Date();
    const diff = WEDDING_DATE - now; // milliseconds

    if (diff <= 0) {
      // Wedding day has arrived!
      if (cdGrid)  cdGrid.hidden  = true;
      if (cdDone)  cdDone.hidden  = false;
      return;
    }

    const totalSec = Math.floor(diff / 1000);
    const days     = Math.floor(totalSec / 86400);
    const hours    = Math.floor((totalSec % 86400) / 3600);
    const minutes  = Math.floor((totalSec % 3600)  / 60);
    const seconds  = totalSec % 60;

    cdDays.textContent    = pad(days);
    cdHours.textContent   = pad(hours);
    cdMinutes.textContent = pad(minutes);
    cdSeconds.textContent = pad(seconds);
  }

  // Run immediately, then every second
  updateCountdown();
  setInterval(updateCountdown, 1000);
})();


/* ─────────────────────────────────────────────────
   5. RSVP FORM
   Validates, shows a success alert, and resets the
   form. No backend – pure front-end only.
───────────────────────────────────────────────── */
(function initRSVP() {
  const form             = document.getElementById('rsvpForm');
  const guestCountGroup  = document.getElementById('guestCountGroup');
  const attendanceRadios = document.querySelectorAll('input[name="attendance"]');

  if (!form) return;

  // Show / hide guest count based on attendance choice
  attendanceRadios.forEach(function (radio) {
    radio.addEventListener('change', function () {
      if (this.value === 'tidak') {
        guestCountGroup.style.opacity = '0.4';
        guestCountGroup.style.pointerEvents = 'none';
      } else {
        guestCountGroup.style.opacity = '1';
        guestCountGroup.style.pointerEvents = 'auto';
      }
    });
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Basic validation
    const nameVal = document.getElementById('rsvpName').value.trim();
    const attended = document.querySelector('input[name="attendance"]:checked');

    if (!nameVal) {
      showToast('Mohon masukkan nama lengkap Anda.', 'error');
      return;
    }
    if (!attended) {
      showToast('Mohon pilih konfirmasi kehadiran Anda.', 'error');
      return;
    }

    const guestCount = document.getElementById('guestCount').value;

    // Build confirmation message
    let message;
    if (attended.value === 'hadir') {
      message = '✅ Terima kasih, ' + nameVal + '! Konfirmasi kehadiran Anda untuk '
        + guestCount + ' orang telah kami terima. Kami sangat menantikan kehadiran Anda. 🎉';
    } else {
      message = '💌 Terima kasih, ' + nameVal + '. Kami sangat memahami dan menghargai '
        + 'kehadiran doa serta ucapan tulus Anda dari kejauhan.';
    }

    showToast(message, 'success');
    form.reset();
    guestCountGroup.style.opacity    = '1';
    guestCountGroup.style.pointerEvents = 'auto';
  });
})();


/* ─────────────────────────────────────────────────
   6. WISHES & PRAYERS FORM
   Appends submitted messages to the in-memory list
   displayed on the page. No backend.
───────────────────────────────────────────────── */
(function initWishes() {
  const form       = document.getElementById('wishForm');
  const list       = document.getElementById('wishesList');
  const wishes     = []; // in-memory store

  if (!form || !list) return;

  function renderWishes() {
    if (wishes.length === 0) {
      list.innerHTML = '<p class="wishes__empty">Belum ada ucapan. Jadilah yang pertama! 🌸</p>';
      return;
    }

    // Build HTML for all wishes (newest first)
    list.innerHTML = wishes
      .slice()            // clone array so we don't reverse in place
      .reverse()
      .map(function (w) {
        return [
          '<div class="wish__item">',
            '<p class="wish__name">' + escapeHTML(w.name) + '</p>',
            '<p class="wish__message">' + escapeHTML(w.message) + '</p>',
            '<p class="wish__time">' + w.time + '</p>',
          '</div>'
        ].join('');
      })
      .join('');
  }

  // Show placeholder on load
  renderWishes();

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const nameEl    = document.getElementById('wishName');
    const msgEl     = document.getElementById('wishMessage');
    const nameVal   = nameEl.value.trim();
    const msgVal    = msgEl.value.trim();

    if (!nameVal || !msgVal) {
      showToast('Mohon lengkapi nama dan pesan Anda.', 'error');
      return;
    }

    // Create wish object
    const now  = new Date();
    const time = now.toLocaleString('id-ID', {
      day:    '2-digit',
      month:  'long',
      year:   'numeric',
      hour:   '2-digit',
      minute: '2-digit'
    });

    wishes.push({ name: nameVal, message: msgVal, time: time });
    renderWishes();
    form.reset();
    showToast('Doa dan ucapan Anda telah tersampaikan. Terima kasih! 🌸', 'success');

    // Scroll to wishes list
    list.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });
})();


/* ─────────────────────────────────────────────────
   7. TOAST NOTIFICATION HELPER
   Lightweight overlay-free toast, styled to match
   the vintage sepia palette.
───────────────────────────────────────────────── */
function showToast(message, type) {
  // Remove any existing toast
  const existing = document.getElementById('toastMsg');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.id = 'toastMsg';
  toast.setAttribute('role', 'alert');
  toast.setAttribute('aria-live', 'polite');

  // Inline styles so it works without extra CSS classes
  Object.assign(toast.style, {
    position:     'fixed',
    bottom:       '1.5rem',
    left:         '50%',
    transform:    'translateX(-50%) translateY(20px)',
    zIndex:       '9999',
    maxWidth:     '92vw',
    width:        '420px',
    padding:      '1rem 1.4rem',
    background:   type === 'success' ? '#3e2b1e' : '#5c2020',
    color:        '#fdf6e3',
    fontFamily:   "'Playfair Display', Georgia, serif",
    fontSize:     '0.88rem',
    lineHeight:   '1.6',
    borderLeft:   type === 'success' ? '4px solid #c9a84c' : '4px solid #c94c4c',
    boxShadow:    '0 8px 32px rgba(0,0,0,0.35)',
    borderRadius: '2px',
    transition:   'opacity 0.4s ease, transform 0.4s ease',
    opacity:      '0',
    cursor:       'pointer',
  });

  toast.textContent = message;
  document.body.appendChild(toast);

  // Animate in
  requestAnimationFrame(function () {
    requestAnimationFrame(function () {
      toast.style.opacity   = '1';
      toast.style.transform = 'translateX(-50%) translateY(0)';
    });
  });

  // Auto-dismiss after 4.5s
  function dismissToast() {
    toast.style.opacity   = '0';
    toast.style.transform = 'translateX(-50%) translateY(20px)';
    toast.addEventListener('transitionend', function () { toast.remove(); });
  }

  const timer = setTimeout(dismissToast, 4500);

  // Allow manual dismissal by click
  toast.addEventListener('click', function () {
    clearTimeout(timer);
    dismissToast();
  });
}


/* ─────────────────────────────────────────────────
   8. UTILITY: HTML ESCAPE
   Prevents XSS when inserting user input into DOM.
───────────────────────────────────────────────── */
function escapeHTML(str) {
  return str
    .replace(/&/g,  '&amp;')
    .replace(/</g,  '&lt;')
    .replace(/>/g,  '&gt;')
    .replace(/"/g,  '&quot;')
    .replace(/'/g,  '&#039;');
}


/* ─────────────────────────────────────────────────
   9. ACTIVE NAV LINK HIGHLIGHT ON SCROLL
   Highlights the current section's nav link as the
   user scrolls through the page.
───────────────────────────────────────────────── */
(function initActiveNav() {
  const navLinks = document.querySelectorAll('.nav__link');
  const sections = Array.from(navLinks).map(function (link) {
    const id = link.getAttribute('href').slice(1);
    return document.getElementById(id);
  });

  function onScroll() {
    const scrollY = window.pageYOffset;
    const navH    = (document.getElementById('nav') || { offsetHeight: 0 }).offsetHeight;

    let currentIndex = -1;
    sections.forEach(function (section, i) {
      if (!section) return;
      if (section.offsetTop - navH - 60 <= scrollY) {
        currentIndex = i;
      }
    });

    navLinks.forEach(function (link, i) {
      if (i === currentIndex) {
        link.style.color = 'var(--gold-light)';
      } else {
        link.style.color = '';
      }
    });
  }

  window.addEventListener('scroll', onScroll, { passive: true });
})();


/* ─────────────────────────────────────────────────
   10. HERO TICKER — stagger each span's animation
    so they don't all start at the same position.
───────────────────────────────────────────────── */
(function initTicker() {
  const spans = document.querySelectorAll('.hero__stripe span');
  spans.forEach(function (span, i) {
    // Stagger by dividing the full 18s duration across spans
    span.style.animationDelay = (i * (18 / spans.length)) + 's';
  });
})();


/* ─────────────────────────────────────────────────
   10. GALLERY LIGHTBOX
   Click any image to open overlay, navigate with
   arrows or keyboard, close with ESC or backdrop.
───────────────────────────────────────────────── */
(function initLightbox() {
  const items = Array.from(document.querySelectorAll('.gallery__item'));
  if (!items.length) return;

  const lightbox    = document.getElementById('lightbox');
  const lbImg       = document.getElementById('lightboxImg');
  const lbCaption   = document.getElementById('lightboxCaption');
  const btnClose    = document.getElementById('lightboxBtnClose');
  const btnPrev     = document.getElementById('lightboxPrev');
  const btnNext     = document.getElementById('lightboxNext');
  const backdrop    = document.getElementById('lightboxClose');

  let currentIndex = 0;

  function open(index) {
    const item = items[index];
    if (!item) return;
    const img = item.querySelector('.gallery__img');
    const caption = item.querySelector('.gallery__overlay') ? item.querySelector('.gallery__overlay').textContent : img.alt || '';
    const src = img && (img.dataset.full || img.src);

    lbImg.src = src || '';
    lbImg.alt = img ? img.alt : '';
    lbCaption.textContent = caption || '';
    currentIndex = index;
    if (lightbox) {
      lightbox.setAttribute('aria-hidden', 'false');
    }
    document.body.style.overflow = 'hidden';
  }

  function close() {
    if (!lightbox) return;
    lightbox.setAttribute('aria-hidden', 'true');
    lbImg.src = '';
    document.body.style.overflow = '';
  }

  function showPrev() { open((currentIndex - 1 + items.length) % items.length); }
  function showNext() { open((currentIndex + 1) % items.length); }

  // Attach click handlers to each gallery item
  items.forEach(function (it, i) {
    it.addEventListener('click', function () { open(i); });
  });

  // Controls
  if (btnClose) btnClose.addEventListener('click', close);
  if (backdrop)  backdrop.addEventListener('click', close);
  if (btnPrev)   btnPrev.addEventListener('click', function (e) { e.stopPropagation(); showPrev(); });
  if (btnNext)   btnNext.addEventListener('click', function (e) { e.stopPropagation(); showNext(); });

  // Keyboard navigation
  document.addEventListener('keydown', function (e) {
    if (!lightbox || lightbox.getAttribute('aria-hidden') === 'true') return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') showPrev();
    if (e.key === 'ArrowRight') showNext();
  });

})();