// ==============================
// [RECRUITMENT MODAL - TEMP FILE]
// Purpose: Always show the recruitment popup on the homepage.
// Safe to delete after the recruitment campaign ends.
// ==============================
// Always shows the recruitment modal on the homepage (no persistence)
(function () {
  const MODAL_ID = 'recruitmentModal';

  function init() {
    const modalEl = document.getElementById(MODAL_ID);
    if (!modalEl) return; // only on homepage

    const modal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });
    // Defer to ensure Bootstrap is fully ready and DOM painted
    setTimeout(() => modal.show(), 300);

    // [RECRUITMENT MODAL - TEMP] Wire global close button (fixed in viewport)
    const globalClose = document.querySelector('.recruitment-close-global');
    if (globalClose) {
      // Pokaż dopiero po pełnym wyświetleniu modala
      modalEl.addEventListener('shown.bs.modal', () => {
        globalClose.style.display = 'block';
      });
      // Ukryj gdy modal znika
      modalEl.addEventListener('hidden.bs.modal', () => {
        globalClose.style.display = 'none';
      });
      // Klik zamyka modal natychmiast
      globalClose.addEventListener('click', () => {
        modal.hide();
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
