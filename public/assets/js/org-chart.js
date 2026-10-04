/* ==========================================================================
   Org chart: builds the structure tree from window.ETACXI_STRUCTURE
   (see assets/data/structure.js) or from a JSON file set in data-src.
   ========================================================================== */

(function () {
  "use strict";

  const chart = document.querySelector("[data-org-chart]");
  if (!chart) return;

  const scroller = document.querySelector("[data-org-scroll]");

  const create = (tag, className, text) => {
    const element = document.createElement(tag);
    if (className) element.className = className;
    if (text) element.textContent = text;
    return element;
  };

  const renderSide = (items, side) => {
    if (!items || !items.length) return null;

    const box = create("div", `org__side org__side--${side}`);
    items.forEach((item) => box.appendChild(create("div", `org__node org__node--${item.type || "advisor"}`, item.title)));
    return box;
  };

  const renderNode = (node) => {
    const item = create("li", "org__item");
    const children = Array.isArray(node.children) ? node.children : [];
    const head = create("div", "org__head");

    const box = create(children.length ? "button" : "div", `org__node org__node--${node.type || "department"}`);
    box.appendChild(create("span", "org__label", node.title));
    if (node.description) box.title = node.description;

    if (children.length) {
      box.type = "button";
      box.setAttribute("aria-expanded", "true");
      box.appendChild(create("span", "org__caret"));
    }

    const left = renderSide(node.side && node.side.left, "left");
    const right = renderSide(node.side && node.side.right, "right");
    if (left) head.appendChild(left);
    head.appendChild(box);
    if (right) head.appendChild(right);
    item.appendChild(head);

    if (children.length) {
      // departments whose children are all "unit" get a compact vertical list
      const stacked = children.every((child) => child.type === "unit");
      const list = create("ul", stacked ? "org__stack" : "org__children");
      children.forEach((child) => list.appendChild(renderNode(child)));
      item.appendChild(list);
    }

    return item;
  };

  const render = (data) => {
    chart.replaceChildren();
    const list = create("ul", "org__children org__children--root");
    list.appendChild(renderNode(data));
    chart.appendChild(list);

    if (scroller) scroller.scrollLeft = (scroller.scrollWidth - scroller.clientWidth) / 2;
  };

  const setCollapsed = (item, collapsed) => {
    item.classList.toggle("is-collapsed", collapsed);
    const toggle = item.querySelector(":scope > .org__head > .org__node[aria-expanded]");
    if (toggle) toggle.setAttribute("aria-expanded", String(!collapsed));
  };

  // expand / collapse a single branch
  chart.addEventListener("click", (event) => {
    const toggle = event.target.closest(".org__node[aria-expanded]");
    if (!toggle) return;
    const item = toggle.closest(".org__item");
    setCollapsed(item, !item.classList.contains("is-collapsed"));
  });

  // expand / collapse everything
  const allBranches = () => Array.from(chart.querySelectorAll(".org__item")).filter((item) => item.querySelector(":scope > ul"));
  document.querySelector("[data-org-expand]")?.addEventListener("click", () => allBranches().forEach((item) => setCollapsed(item, false)));
  document.querySelector("[data-org-collapse]")?.addEventListener("click", () => {
    // keep the first two levels open so the chart never becomes empty
    const depth = (item) => {
      let level = 0;
      for (let parent = item.parentElement.closest(".org__item"); parent; parent = parent.parentElement.closest(".org__item")) level += 1;
      return level;
    };
    allBranches().forEach((item) => setCollapsed(item, depth(item) >= 2));
  });

  // drag to pan on wide screens
  if (scroller) {
    let startX = 0;
    let startScroll = 0;
    let dragging = false;

    scroller.addEventListener("pointerdown", (event) => {
      if (event.pointerType !== "mouse" || event.target.closest("button")) return;
      dragging = true;
      startX = event.clientX;
      startScroll = scroller.scrollLeft;
      scroller.classList.add("is-dragging");
    });
    window.addEventListener("pointermove", (event) => {
      if (dragging) scroller.scrollLeft = startScroll - (event.clientX - startX);
    });
    window.addEventListener("pointerup", () => {
      dragging = false;
      scroller.classList.remove("is-dragging");
    });
  }

  const source = chart.dataset.src;
  const load = source ? fetch(source).then((response) => response.json()) : Promise.resolve(window.ETACXI_STRUCTURE);

  load
    .then((data) => {
      if (!data) throw new Error("no data");
      render(data);
    })
    .catch(() => {
      chart.textContent = chart.dataset.error || "Failed to load.";
    });
})();
