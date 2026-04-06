'use strict';

/* Utilities */
function formatNumber(num) {
    return num.toString().padStart(2, '0');
}

function escapeHTML(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#x27;');
}


/* Countdown */
const WEDDING_DATE = new Date('March 19, 2027 08:00:00').getTime();

function updateCountdown() {
    const diff = WEDDING_DATE - Date.now();
    const box = document.getElementById('countdown');

    if (diff <= 0) {
        if (box) {
            box.innerHTML =
                `<h3 style="font-family:'Great Vibes',cursive;font-size:32px;color:#8b5e3c;">
                Hari Bahagia Telah Tiba ❤️
                </h3>`;
        }
        clearInterval(countdownTimer);
        return;
    }

    const time = {
        days: Math.floor(diff / (1000 * 60 * 60 * 24)),
        hours: Math.floor(diff / (1000 * 60 * 60) % 24),
        minutes: Math.floor(diff / (1000 * 60) % 60),
        seconds: Math.floor(diff / 1000 % 60)
    };

    Object.keys(time).forEach(key => {
        const el = document.getElementById(key);
        if (el) el.textContent = formatNumber(time[key]);
    });
}

updateCountdown();
const countdownTimer = setInterval(updateCountdown, 1000);


/* Local storage */
const STORAGE_NAME = 'weddingGuestData';

function getGuests() {
    try {
        return JSON.parse(localStorage.getItem(STORAGE_NAME)) || [];
    } catch {
        return [];
    }
}

function saveGuests(data) {
    try {
        localStorage.setItem(STORAGE_NAME, JSON.stringify(data));
    } catch (err) {
        console.warn('localStorage error:', err);
    }
}


/* Guest list */
function renderGuestList() {
    const list = document.getElementById('guestList');
    const empty = document.getElementById('emptyWishes');
    if (!list) return;

    const guests = getGuests().reverse();
    list.innerHTML = '';

    if (!guests.length) {
        if (empty) empty.style.display = 'block';
        return;
    }

    if (empty) empty.style.display = 'none';

    guests.forEach((guest, i) => {

        const hadir = guest.status === 'Hadir';

        const jumlah =
            hadir && guest.jumlah
                ? `<p class="guest-item-count">🧑‍🤝‍🧑 ${guest.jumlah} orang</p>`
                : '';

        const pesan =
            guest.pesan
                ? `<p class="guest-item-message">${escapeHTML(guest.pesan)}</p>`
                : '';

        const li = document.createElement('li');
        li.style.animationDelay = `${i * 0.06}s`;

        li.innerHTML = `
            <div class="guest-name-row">
                <span class="guest-item-name">${escapeHTML(guest.nama)}</span>
                <span class="guest-badge ${hadir ? 'badge-hadir' : 'badge-tidak'}">
                    ${hadir ? '✓ Hadir' : '✗ Tidak Hadir'}
                </span>
            </div>
            ${jumlah}
            ${pesan}
        `;

        list.appendChild(li);
    });
}


/* RSVP form */
const rsvpForm = document.getElementById('rsvpForm');

if (rsvpForm) {
    rsvpForm.addEventListener('submit', e => {
        e.preventDefault();

        const name = rsvpForm.querySelector('#rsvpName')?.value.trim();
        const status = rsvpForm.querySelector('#rsvpStatus')?.value.trim();
        const count = parseInt(rsvpForm.querySelector('#rsvpJumlah')?.value || '1', 10);
        const message = rsvpForm.querySelector('#rsvpPesan')?.value.trim();

        if (!name) return showToast('Mohon isi nama lengkap Anda.');
        if (!status) return showToast('Mohon pilih konfirmasi kehadiran.');

        const guest = {
            nama: name,
            status: status,
            jumlah: status === 'Hadir' ? count : 0,
            pesan: message,
            timestamp: new Date().toISOString()
        };

        const data = getGuests();
        data.push(guest);
        saveGuests(data);

        renderGuestList();
        showToast('Konfirmasi berhasil disimpan ❤️');
        rsvpForm.reset();

        setTimeout(() => {
            document.getElementById('wishes')
                ?.scrollIntoView({ behavior: 'smooth' });
        }, 400);
    });
}


/* Toast */
const toast = document.getElementById('toast');
let toastTimeout;

function showToast(message) {
    if (!toast) return;

    toast.textContent = message;
    toast.classList.add('show');

    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}


/* Scroll animation */
const cards = document.querySelectorAll('.card');

if ('IntersectionObserver' in window) {

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.08 });

    cards.forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(28px)';
        card.style.transition = `opacity .6s ease ${i * 0.1}s, transform .6s ease ${i * 0.1}s`;
        observer.observe(card);
    });
}


/* Init */
renderGuestList();