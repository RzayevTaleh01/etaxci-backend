/* ==========================================================================
   ETACXİ – site behaviour (Bootstrap 5 handles the navbar and dropdowns)
   ========================================================================== */

/**
 * Horizontal thumbnail strip: prev/next buttons scroll the track by one item.
 * Markup: [data-strip] > [data-strip-track], [data-strip-prev], [data-strip-next]
 */
function initThumbStrips() {
  document.querySelectorAll("[data-strip]").forEach((strip) => {
    const track = strip.querySelector("[data-strip-track]");
    const prev = strip.querySelector("[data-strip-prev]");
    const next = strip.querySelector("[data-strip-next]");
    if (!track || !prev || !next) return;

    const step = () => {
      const item = track.firstElementChild;
      const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      return item ? item.getBoundingClientRect().width + gap : track.clientWidth;
    };

    prev.addEventListener("click", () => track.scrollBy({ left: -step() }));
    next.addEventListener("click", () => track.scrollBy({ left: step() }));
  });
}

/** Fancybox for photos and videos (only loaded on pages that use it). */
function initFancybox() {
  if (!window.Fancybox) return;

  const locale = (window.ETACXI_I18N && window.ETACXI_I18N.locale) || "az";
  const l10n = {
    az: { CLOSE: "Bağla", NEXT: "Növbəti", PREV: "Əvvəlki", MODAL: "Bu pəncərəni Esc düyməsi ilə bağlaya bilərsiniz", ERROR: "Xəta baş verdi, sonra yenidən cəhd edin", IMAGE_ERROR: "Şəkil tapılmadı", ELEMENT_NOT_FOUND: "HTML elementi tapılmadı", AJAX_NOT_FOUND: "Yükləmə xətası: tapılmadı", AJAX_FORBIDDEN: "Yükləmə xətası: icazə yoxdur", IFRAME_ERROR: "Səhifə yüklənmədi", TOGGLE_ZOOM: "Yaxınlaşdır", TOGGLE_THUMBS: "Miniatürlər", TOGGLE_SLIDESHOW: "Slayd nümayişi", TOGGLE_FULLSCREEN: "Tam ekran", DOWNLOAD: "Yüklə" },
    en: { CLOSE: "Close", NEXT: "Next", PREV: "Previous", MODAL: "You can close this modal with the Esc key", ERROR: "Something went wrong, please try again later", IMAGE_ERROR: "Image not found", ELEMENT_NOT_FOUND: "HTML element not found", AJAX_NOT_FOUND: "Loading error: not found", AJAX_FORBIDDEN: "Loading error: forbidden", IFRAME_ERROR: "Page failed to load", TOGGLE_ZOOM: "Toggle zoom", TOGGLE_THUMBS: "Thumbnails", TOGGLE_SLIDESHOW: "Slideshow", TOGGLE_FULLSCREEN: "Full screen", DOWNLOAD: "Download" },
    ru: { CLOSE: "Закрыть", NEXT: "Далее", PREV: "Назад", MODAL: "Окно можно закрыть клавишей Esc", ERROR: "Произошла ошибка, повторите попытку позже", IMAGE_ERROR: "Изображение не найдено", ELEMENT_NOT_FOUND: "HTML-элемент не найден", AJAX_NOT_FOUND: "Ошибка загрузки: не найдено", AJAX_FORBIDDEN: "Ошибка загрузки: доступ запрещён", IFRAME_ERROR: "Страница не загрузилась", TOGGLE_ZOOM: "Увеличить", TOGGLE_THUMBS: "Миниатюры", TOGGLE_SLIDESHOW: "Слайд-шоу", TOGGLE_FULLSCREEN: "На весь экран", DOWNLOAD: "Скачать" },
  };

  Fancybox.bind("[data-fancybox]", { l10n: l10n[locale] || l10n.az });
}

/** Bootstrap validation styles for forms marked with .needs-validation. */
function initFormValidation() {
  document.querySelectorAll(".needs-validation").forEach((form) => {
    form.addEventListener("submit", (event) => {
      // Valid forms are submitted to the server; invalid ones only show validation hints.
      if (form.checkValidity()) return;
      event.preventDefault();
      form.classList.add("was-validated");
    });
  });
}

/** Search band: dim the page behind it, focus the field, close with Escape or a click outside. */
function initSearch() {
  const panel = document.getElementById("searchPanel");
  if (!panel) return;

  const backdrop = document.createElement("div");
  backdrop.className = "search-backdrop";
  const collapse = () => bootstrap.Collapse.getOrCreateInstance(panel);

  panel.addEventListener("show.bs.collapse", () => {
    document.body.appendChild(backdrop);
    requestAnimationFrame(() => backdrop.classList.add("show"));
  });
  panel.addEventListener("shown.bs.collapse", () => panel.querySelector("input").focus());
  panel.addEventListener("hide.bs.collapse", () => backdrop.classList.remove("show"));
  panel.addEventListener("hidden.bs.collapse", () => backdrop.remove());
  panel.addEventListener("keydown", (event) => {
    if (event.key === "Escape") collapse().hide();
  });
  backdrop.addEventListener("click", () => collapse().hide());
}

/**
 * Menu parents:
 *  - desktop (>= 1200px): the menu opens on hover, a click simply follows the parent link;
 *  - phones: the off-canvas sub-menus open as a smooth accordion (height transition, one at a time).
 * Bootstrap listens in the capture phase on `document`, so this runs earlier, on `window`.
 */
function initMenuLinks() {
  const desktop = window.matchMedia("(min-width: 1200px)");
  const panel = document.getElementById("mainNav");
  if (!panel) return;

  const setOpen = (toggle, open) => {
    const menu = toggle.parentElement.querySelector(":scope > .dropdown-menu");
    if (!menu) return;

    if (open) menu.style.setProperty("--sub-h", `${menu.scrollHeight}px`);
    toggle.classList.toggle("is-open", open);
    menu.classList.toggle("is-open", open);
    toggle.setAttribute("aria-expanded", String(open));
  };

  const closeAll = () => panel.querySelectorAll('[data-bs-toggle="dropdown"].is-open').forEach((toggle) => setOpen(toggle, false));

  window.addEventListener(
    "click",
    (event) => {
      const toggle = event.target.closest('#mainNav [data-bs-toggle="dropdown"]');
      if (!toggle) return;

      if (desktop.matches) {
        // only the language switcher keeps Bootstrap's dropdown on desktop
        if (!toggle.matches(".site-nav__menu .dropdown-toggle")) return;
        event.stopPropagation();
        if (toggle.getAttribute("href") === "#") event.preventDefault();
        return;
      }

      event.stopPropagation();
      event.preventDefault();
      const willOpen = !toggle.classList.contains("is-open");
      closeAll();
      setOpen(toggle, willOpen);
    },
    true
  );

  // leaving the phone layout: reset any open accordion
  desktop.addEventListener("change", closeAll);
  panel.addEventListener("hidden.bs.offcanvas", closeAll);
}

/** Fade blocks in as they scroll into view; siblings get a small stagger. */
function initReveal() {
  const items = Array.from(document.querySelectorAll("[data-reveal]"));
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  if (reduced || !("IntersectionObserver" in window)) {
    items.forEach((item) => item.classList.add("is-visible"));
    return;
  }

  items.forEach((item) => {
    const siblings = Array.from(item.parentElement.children).filter((el) => el.hasAttribute("data-reveal"));
    item.style.setProperty("--reveal-delay", `${Math.min(siblings.indexOf(item), 4) * 80}ms`);
  });

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.12, rootMargin: "0px 0px -6% 0px" }
  );

  items.forEach((item) => observer.observe(item));
}

document.addEventListener("DOMContentLoaded", () => {
  initSearch();
  initMenuLinks();
  initReveal();
  initThumbStrips();
  initFancybox();
  initFormValidation();
});
