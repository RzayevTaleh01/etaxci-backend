/* ETACXİ admin panel scripts */
(function () {
  "use strict";

  // ---- Mobile sidebar ---------------------------------------------------
  const sidebar = document.getElementById("adminSidebar");
  const backdrop = document.getElementById("sidebarBackdrop");
  const toggle = (open) => {
    sidebar?.classList.toggle("open", open);
    backdrop?.classList.toggle("open", open);
  };
  document.querySelectorAll("[data-sidebar-toggle]").forEach((b) => b.addEventListener("click", () => toggle(!sidebar.classList.contains("open"))));
  backdrop?.addEventListener("click", () => toggle(false));

  // ---- Confirm before destructive actions -------------------------------
  document.addEventListener("submit", (e) => {
    const msg = e.target.dataset.confirm;
    if (msg && !window.confirm(msg)) e.preventDefault();
  });

  // ---- Language switcher inside forms -----------------------------------
  document.querySelectorAll("[data-lang-switch]").forEach((switcher) => {
    const form = switcher.closest("form") || document;
    const show = (lang) => {
      switcher.querySelectorAll("button").forEach((b) => b.classList.toggle("active", b.dataset.lang === lang));
      form.querySelectorAll(".lang-pane").forEach((p) => p.classList.toggle("active", p.dataset.lang === lang));
      try { localStorage.setItem("adminLang", lang); } catch (_) {}
    };
    switcher.querySelectorAll("button").forEach((b) => b.addEventListener("click", () => show(b.dataset.lang)));
    let saved = null;
    try { saved = localStorage.getItem("adminLang"); } catch (_) {}
    show(saved && switcher.querySelector(`[data-lang="${saved}"]`) ? saved : switcher.querySelector("button").dataset.lang);

    // Mark languages that already have content.
    const refresh = () => {
      switcher.querySelectorAll("button").forEach((b) => {
        const dot = b.querySelector(".dot");
        if (!dot) return;
        const fields = form.querySelectorAll(`.lang-pane[data-lang="${b.dataset.lang}"] [data-lang-input]`);
        dot.classList.toggle("filled", [...fields].some((f) => f.value && f.value.replace(/<[^>]*>/g, "").trim() !== ""));
      });
    };
    form.addEventListener("input", refresh);
    setTimeout(refresh, 400);
  });

  // ---- Rich text (Quill) ------------------------------------------------
  const quills = [];
  if (window.Quill) {
    document.querySelectorAll("[data-richtext]").forEach((box) => {
      const input = box.parentElement.querySelector("input[type=hidden]");
      const editor = box.querySelector(".editor");
      const q = new Quill(editor, {
        theme: "snow",
        modules: {
          toolbar: [
            [{ header: [2, 3, 4, false] }],
            ["bold", "italic", "underline", "strike"],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ align: [] }],
            ["link", "blockquote"],
            ["clean"],
          ],
        },
      });
      q.clipboard.dangerouslyPasteHTML(input.value || "");
      q.on("text-change", () => {
        input.value = q.getText().trim() === "" && !q.root.querySelector("img") ? "" : q.root.innerHTML;
        input.dispatchEvent(new Event("input", { bubbles: true }));
      });
      quills.push({ q, input });
    });
  }

  // ---- Image inputs: live preview + remove -----------------------------
  document.querySelectorAll("[data-image-field]").forEach((wrap) => {
    const input = wrap.querySelector("input[type=file]");
    const preview = wrap.querySelector("img.img-preview");
    const remove = wrap.querySelector("input[data-remove]");
    input?.addEventListener("change", () => {
      const file = input.files[0];
      if (!file) return;
      const url = URL.createObjectURL(file);
      if (preview) { preview.src = url; preview.classList.remove("d-none"); }
      if (remove) remove.checked = false;
    });
    remove?.addEventListener("change", () => preview?.classList.toggle("d-none", remove.checked));
  });

  // ---- Gallery field ----------------------------------------------------
  document.querySelectorAll("[data-gallery-field]").forEach((wrap) => {
    wrap.addEventListener("click", (e) => {
      const btn = e.target.closest(".remove");
      if (btn) btn.closest(".gallery-item").remove();
    });
    const input = wrap.querySelector("input[type=file]");
    const grid = wrap.querySelector(".gallery-new");
    input?.addEventListener("change", () => {
      grid.innerHTML = "";
      [...input.files].forEach((f) => {
        const img = document.createElement("img");
        img.src = URL.createObjectURL(f);
        const div = document.createElement("div");
        div.className = "gallery-item";
        div.appendChild(img);
        grid.appendChild(div);
      });
    });
  });

  // ---- Drag & drop ordering --------------------------------------------
  const sortBody = document.querySelector("[data-sortable]");
  if (sortBody && window.Sortable) {
    Sortable.create(sortBody, {
      handle: ".drag-handle",
      animation: 150,
      ghostClass: "sortable-ghost",
      onEnd: () => {
        const ids = [...sortBody.querySelectorAll("tr[data-id]")].map((tr) => tr.dataset.id);
        fetch(sortBody.dataset.url, {
          method: "POST",
          headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content, Accept: "application/json" },
          body: JSON.stringify({ ids }),
        });
      },
    });
  }

  // ---- Auto-hide flash messages ----------------------------------------
  document.querySelectorAll(".alert-flash").forEach((a) => setTimeout(() => a.classList.add("d-none"), 6000));

  // ---- Dashboard chart --------------------------------------------------
  const chartEl = document.getElementById("newsChart");
  if (chartEl && window.Chart) {
    const data = JSON.parse(chartEl.dataset.chart);
    new Chart(chartEl, {
      type: "bar",
      data: { labels: data.labels, datasets: [{ label: chartEl.dataset.label, data: data.data, backgroundColor: "#0392ce", borderRadius: 6 }] },
      options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, maintainAspectRatio: false },
    });
  }
})();
