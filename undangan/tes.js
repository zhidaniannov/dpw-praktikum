(function () {
    var audio = document.getElementById('bgAudio');
    var btn = document.getElementById('soundToggle');
    var storageKey = 'dpw_sound_muted';

    function init() {
        var saved = localStorage.getItem(storageKey);
        var muted = saved === null ? true : (saved === 'true');
        audio.muted = muted;
        audio.play().catch(function () {});
        updateButton();
    }

    function toggle() {
        audio.muted = !audio.muted;
        localStorage.setItem(storageKey, String(audio.muted));
        updateButton();
    }

    function updateButton() {
        if (!btn) return;
        btn.setAttribute('aria-pressed', String(!audio.muted));
        btn.textContent = audio.muted ? '🔈' : '🔊';
        btn.title = audio.muted ? 'Unmute' : 'Mute';
    }
    if (btn) {
        btn.addEventListener('click', toggle);
    }
    init();
    window.__dpw_bgAudio = audio;
})();