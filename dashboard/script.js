/**
 * =====================================================
 *  WEDDING INVITATION — Zhidan & Suci
 *  script.js — All interactive functionality
 * =====================================================
 */

'use strict';

/* ─────────────────────────────────────────────────
   1. SMOOTH SCROLLING NAVIGATION
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
        - 16;

      window.scrollTo({ top: offsetTop, behavior: 'smooth' });
    });
  });
})();


/* ─────────────────────────────────────────────────
   2. SCROLL FADE-IN ANIMATION
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
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    fadeEls.forEach(function (el) { observer.observe(el); });
  } else {
    fadeEls.forEach(function (el) { el.classList.add('visible'); });
  }
}

document.addEventListener('DOMContentLoaded', checkFadeIn);


/* ─────────────────────────────────────────────────
   3. REAL-TIME COUNTDOWN TIMER
   Target: 20 February 2027 at 08:00 WIB (UTC+7)
───────────────────────────────────────────────── */
(function initCountdown() {
  const WEDDING_DATE = new Date('2027-02-20T01:00:00Z'); // 08:00 WIB in UTC

  const cdDays    = document.getElementById('cdDays');
  const cdHours   = document.getElementById('cdHours');
  const cdMinutes = document.getElementById('cdMinutes');
  const cdSeconds = document.getElementById('cdSeconds');
  const cdGrid    = document.getElementById('countdownGrid');
  const cdDone    = document.getElementById('countdownDone');

  if (!cdDays) return;

  function pad(n) { return String(n).padStart(2, '0'); }

  function updateCountdown() {
    const diff = WEDDING_DATE - new Date();

    if (diff <= 0) {
      if (cdGrid) cdGrid.hidden = true;
      if (cdDone) cdDone.hidden = false;
      return;
    }

    const totalSec = Math.floor(diff / 1000);
    cdDays.textContent    = pad(Math.floor(totalSec / 86400));
    cdHours.textContent   = pad(Math.floor((totalSec % 86400) / 3600));
    cdMinutes.textContent = pad(Math.floor((totalSec % 3600) / 60));
    cdSeconds.textContent = pad(totalSec % 60);
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);
})();


/* ─────────────────────────────────────────────────
   4. RSVP FORM
   Submits to the server via fetch, shows a toast on
   success or error.
───────────────────────────────────────────────── */
(function initRSVP() {
  const form            = document.getElementById('rsvpForm');
  const guestCountGroup = document.getElementById('guestCountGroup');
  const attendanceRadios = document.querySelectorAll('input[name="attendance"]');

  if (!form) return;

  // Show / hide guest count based on attendance choice
  attendanceRadios.forEach(function (radio) {
    radio.addEventListener('change', function () {
      const hide = this.value === 'tidak';
      guestCountGroup.style.opacity       = hide ? '0.4' : '1';
      guestCountGroup.style.pointerEvents = hide ? 'none' : 'auto';
    });
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const nameVal  = document.getElementById('rsvpName').value.trim();
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
    const formData   = new FormData(form);

    fetch('rsvp_action.php', { method: 'POST', body: formData })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data.success) {
          const msg = attended.value === 'hadir'
            ? '✅ Terima kasih, ' + nameVal + '! Kehadiran Anda untuk ' + guestCount + ' orang telah tercatat. 🎉'
            : '💌 Terima kasih, ' + nameVal + '. Doa Anda sangat berarti bagi kami.';
          showToast(msg, 'success');
          form.reset();
          guestCountGroup.style.opacity       = '1';
          guestCountGroup.style.pointerEvents = 'auto';
        } else {
          showToast(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
        }
      })
      .catch(function () {
        showToast('Gagal terhubung ke server. Silakan coba lagi.', 'error');
      });
  });
})();


/* ─────────────────────────────────────────────────
   5. WISHES & PRAYERS FORM
   Appends submitted messages to the in-memory list.
───────────────────────────────────────────────── */
(function initWishes() {
  const form   = document.getElementById('wishForm');
  const list   = document.getElementById('wishesList');
  const wishes = [];

  if (!form || !list) return;

  function renderWishes() {
    if (wishes.length === 0) {
      list.innerHTML = '<p class="wishes__empty">Belum ada ucapan. Jadilah yang pertama! 🌸</p>';
      return;
    }
    list.innerHTML = wishes.slice().reverse().map(function (w) {
      return [
        '<div class="wish__item">',
          '<p class="wish__name">'    + escapeHTML(w.name)    + '</p>',
          '<p class="wish__message">' + escapeHTML(w.message) + '</p>',
          '<p class="wish__time">'    + w.time                + '</p>',
        '</div>'
      ].join('');
    }).join('');
  }

  renderWishes();

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const nameVal = document.getElementById('wishName').value.trim();
    const msgVal  = document.getElementById('wishMessage').value.trim();

    if (!nameVal || !msgVal) {
      showToast('Mohon lengkapi nama dan pesan Anda.', 'error');
      return;
    }

    wishes.push({
      name:    nameVal,
      message: msgVal,
      time:    new Date().toLocaleString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
      })
    });

    renderWishes();
    form.reset();
    showToast('Doa dan ucapan Anda telah tersampaikan. Terima kasih! 🌸', 'success');
    list.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });
})();


/* ─────────────────────────────────────────────────
   6. TOAST NOTIFICATION
───────────────────────────────────────────────── */
function showToast(message, type) {
  const existing = document.getElementById('toastMsg');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.id = 'toastMsg';
  toast.setAttribute('role', 'alert');
  toast.setAttribute('aria-live', 'polite');

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

  requestAnimationFrame(function () {
    requestAnimationFrame(function () {
      toast.style.opacity   = '1';
      toast.style.transform = 'translateX(-50%) translateY(0)';
    });
  });

  function dismissToast() {
    toast.style.opacity   = '0';
    toast.style.transform = 'translateX(-50%) translateY(20px)';
    toast.addEventListener('transitionend', function () { toast.remove(); });
  }

  const timer = setTimeout(dismissToast, 4500);
  toast.addEventListener('click', function () { clearTimeout(timer); dismissToast(); });
}


/* ─────────────────────────────────────────────────
   7. HTML ESCAPE UTILITY
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
   8. ACTIVE NAV HIGHLIGHT ON SCROLL
───────────────────────────────────────────────── */
(function initActiveNav() {
  const navLinks = document.querySelectorAll('.nav__link');
  const sections = Array.from(navLinks).map(function (link) {
    return document.getElementById(link.getAttribute('href').slice(1));
  });

  function onScroll() {
    const scrollY = window.pageYOffset;
    const navH    = (document.getElementById('nav') || { offsetHeight: 0 }).offsetHeight;
    let current   = -1;

    sections.forEach(function (section, i) {
      if (section && section.offsetTop - navH - 60 <= scrollY) current = i;
    });

    navLinks.forEach(function (link, i) {
      link.style.color = (i === current) ? 'var(--gold-light)' : '';
    });
  }

  window.addEventListener('scroll', onScroll, { passive: true });
})();


/* ─────────────────────────────────────────────────
   9. HERO TICKER — stagger each span's animation
───────────────────────────────────────────────── */
(function initTicker() {
  const spans = document.querySelectorAll('.hero__stripe span');
  spans.forEach(function (span, i) {
    span.style.animationDelay = (i * (18 / spans.length)) + 's';
  });
})();


/* ─────────────────────────────────────────────────
   10. GALLERY LIGHTBOX
───────────────────────────────────────────────── */
(function initLightbox() {
  const items = Array.from(document.querySelectorAll('.gallery__item'));
  if (!items.length) return;

  const lightbox  = document.getElementById('lightbox');
  const lbImg     = document.getElementById('lightboxImg');
  const lbCaption = document.getElementById('lightboxCaption');
  const btnClose  = document.getElementById('lightboxBtnClose');
  const btnPrev   = document.getElementById('lightboxPrev');
  const btnNext   = document.getElementById('lightboxNext');
  const backdrop  = document.getElementById('lightboxClose');

  let currentIndex = 0;

  function open(index) {
    const item    = items[index];
    if (!item) return;
    const img     = item.querySelector('.gallery__img');
    const overlay = item.querySelector('.gallery__overlay');
    lbImg.src            = img ? (img.dataset.full || img.src) : '';
    lbImg.alt            = img ? img.alt : '';
    lbCaption.textContent = overlay ? overlay.textContent : (img ? img.alt : '');
    currentIndex = index;
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function close() {
    lightbox.setAttribute('aria-hidden', 'true');
    lbImg.src = '';
    document.body.style.overflow = '';
  }

  function showPrev() { open((currentIndex - 1 + items.length) % items.length); }
  function showNext() { open((currentIndex + 1) % items.length); }

  items.forEach(function (it, i) {
    it.addEventListener('click', function () { open(i); });
  });

  if (btnClose) btnClose.addEventListener('click', close);
  if (backdrop)  backdrop.addEventListener('click', close);
  if (btnPrev)   btnPrev.addEventListener('click',  function (e) { e.stopPropagation(); showPrev(); });
  if (btnNext)   btnNext.addEventListener('click',  function (e) { e.stopPropagation(); showNext(); });

  document.addEventListener('keydown', function (e) {
    if (!lightbox || lightbox.getAttribute('aria-hidden') === 'true') return;
    if (e.key === 'Escape')      close();
    if (e.key === 'ArrowLeft')   showPrev();
    if (e.key === 'ArrowRight')  showNext();
  });
})();