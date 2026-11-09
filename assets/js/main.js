/* =========================================================
   بازی‌کن‌ها — Homepage interactions & motion
   Libraries (local): GSAP + ScrollTrigger, Lenis
   ========================================================= */
(function () {
  "use strict";

  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => [...c.querySelectorAll(s)];
  const fa = (n) => Number(n).toLocaleString("fa-IR");
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const hasGsap = typeof window.gsap !== "undefined" && typeof window.ScrollTrigger !== "undefined";

  /* ---------- Sample product data (replace with real data / API in phase 2) ---------- */
  const PRODUCTS = [
    { name: "کنسول پلی‌استیشن ۵ اسلیم دیجیتال", img: "product-ps5-slim.webp", price: 191980000, old: 197980000, badges: ["ارسال رایگان", "۱۸ ماه گارانتی"] },
    { name: "کنسول ایکس‌باکس سری X", img: "product-xbox-series-x.webp", price: 189500000, old: 199000000, badges: ["ارسال رایگان", "۱۸ ماه گارانتی"] },
    { name: "کنسول نینتندو سوییچ OLED", img: "product-switch-oled.webp", price: 98900000, old: 109000000, badges: ["ارسال رایگان"] },
    { name: "دسته DualSense پلی‌استیشن ۵", img: "product-dualsense.webp", price: 19480000, badges: ["اورجینال"] },
    { name: "دسته بی‌سیم ایکس‌باکس", img: "product-xbox-controller.webp", price: 16900000, old: 18200000, badges: ["اورجینال"] },
    { name: "هدست گیمینگ PULSE 3D", img: "product-pulse-headset.webp", price: 22800000, badges: ["صدای سه‌بعدی"] },
    { name: "دسته DualShock 4 پلی‌استیشن ۴", img: "product-dualshock4.webp", price: 9800000, old: 11500000, badges: ["اورجینال"] },
    { name: "پایه شارژ دوتایی دسته PS5", img: "product-charging-station.webp", price: 6480000, badges: ["پرفروش"] },
    { name: "کیف حمل کنسول PS5 اسلیم", img: "product-ps5-case.webp", price: 4980000, old: 5900000, badges: ["ضد ضربه"] },
    { name: "باتری قابل شارژ دسته ایکس‌باکس", img: "product-xbox-battery.webp", price: 3680000, badges: ["کابل USB-C"] },
    { name: "دیسک بازی God of War Ragnarök برای PS5", img: "product-game-ps5.webp", price: 8980000, old: 11980000, badges: ["ارسال رایگان"] },
    { name: "دیسک بازی Gears of War برای ایکس‌باکس", img: "product-game-xbox.webp", price: 6480000, old: 7480000, badges: ["ارسال رایگان"] },
  ];

  const arrowSvg =
    '<svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  const cartSvg =
    '<svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>';

  function renderProducts() {
    const wrap = $("#products");
    if (!wrap) return;
    wrap.innerHTML = PRODUCTS.map((p) => {
      const off = p.old ? Math.round((1 - p.price / p.old) * 100) : 0;
      return `
      <article class="p-card">
        <div class="p-card__media">
          <img src="${p.img}" alt="${p.name}" loading="lazy" width="1000" height="1000">
          ${off ? `<span class="p-card__off">٪${fa(off)}</span>` : ""}
          <div class="p-card__badges">${p.badges.map((b) => `<span>${b}</span>`).join("")}</div>
        </div>
        <div class="p-card__body">
          <h3 class="p-card__name">${p.name}</h3>
          <div class="p-card__foot">
            <div class="p-card__price">
              ${p.old ? `<del>${fa(p.old)}</del>` : ""}
              <strong>${fa(p.price)} <small>تومان</small></strong>
            </div>
            <button class="round-btn add-cart" aria-label="افزودن ${p.name} به سبد">${cartSvg}</button>
          </div>
        </div>
      </article>`;
    }).join("");
  }

  /* ---------- Preloader ---------- */
  function hidePreloader() {
    const pl = $("#preloader");
    if (!pl || pl.classList.contains("is-done")) return;
    pl.classList.add("is-done");
    document.dispatchEvent(new Event("site:ready"));
  }
  window.addEventListener("load", () => setTimeout(hidePreloader, 350));
  setTimeout(hidePreloader, 3500); // safety

  /* ---------- Smooth scroll (Lenis) ---------- */
  let lenis = null;
  if (!reduceMotion && typeof window.Lenis !== "undefined") {
    lenis = new window.Lenis({ lerp: 0.1, smoothWheel: true });
    if (hasGsap) {
      lenis.on("scroll", window.ScrollTrigger.update);
      gsap.ticker.add((t) => lenis.raf(t * 1000));
      gsap.ticker.lagSmoothing(0);
    } else {
      const raf = (t) => { lenis.raf(t); requestAnimationFrame(raf); };
      requestAnimationFrame(raf);
    }
  }
  function scrollToTarget(target) {
    if (lenis) lenis.scrollTo(target, { offset: -80, duration: 1.4 });
    else {
      const el = typeof target === "string" ? $(target) : target;
      const y = el === 0 ? 0 : el.getBoundingClientRect().top + window.scrollY - 80;
      window.scrollTo({ top: y, behavior: reduceMotion ? "auto" : "smooth" });
    }
  }

  /* ---------- Header / nav / search ---------- */
  const header = $("#header");
  const toTop = $("#toTop");
  function onScroll() {
    const y = window.scrollY;
    header.classList.toggle("is-scrolled", y > 30);
    toTop.classList.toggle("is-visible", y > 700);
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  const burger = $("#burger");
  const nav = $("#nav");
  burger.addEventListener("click", () => {
    const open = burger.getAttribute("aria-expanded") === "true";
    burger.setAttribute("aria-expanded", String(!open));
    nav.classList.toggle("is-open", !open);
  });
  $$(".has-drop > .nav__link").forEach((btn) =>
    btn.addEventListener("click", () => btn.parentElement.classList.toggle("is-open"))
  );

  $("#searchBtn").addEventListener("click", () => {
    const s = $("#search");
    s.classList.toggle("is-open");
    if (s.classList.contains("is-open")) setTimeout(() => $("input", s).focus(), 250);
  });

  // in-page anchors
  document.addEventListener("click", (e) => {
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;
    const id = a.getAttribute("href");
    if (id === "#") { e.preventDefault(); return; }
    const target = id === "#top" ? 0 : $(id);
    if (target === null) return;
    e.preventDefault();
    nav.classList.remove("is-open");
    burger.setAttribute("aria-expanded", "false");
    scrollToTarget(target);
  });

  /* ---------- Cart (demo) & toast ---------- */
  let cart = 0;
  const cartCount = $("#cartCount");
  const toast = $("#toast");
  let toastTimer;
  function showToast(msg) {
    toast.textContent = msg;
    toast.classList.add("is-show");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove("is-show"), 2200);
  }
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".add-cart");
    if (!btn) return;
    cart++;
    cartCount.textContent = fa(cart);
    cartCount.classList.remove("bump"); void cartCount.offsetWidth; cartCount.classList.add("bump");
    showToast("به سبد خرید اضافه شد ✓");
  });

  /* ---------- Coupon copy ---------- */
  $("#copyBtn").addEventListener("click", async () => {
    const code = $("#couponCode").textContent.trim();
    try { await navigator.clipboard.writeText(code); } catch (_) {
      const t = document.createElement("textarea"); t.value = code; document.body.appendChild(t); t.select();
      try { document.execCommand("copy"); } catch (__) {} t.remove();
    }
    $("#copyBtn span").textContent = "کپی شد!";
    showToast("کد تخفیف کپی شد");
    setTimeout(() => ($("#copyBtn span").textContent = "کپی کد"), 2000);
  });

  /* ---------- FAQ: smooth open / close ---------- */
  $$(".acc").forEach((d) => {
    const sum = $("summary", d);
    const body = $(".acc__body", d);
    let anim = null;
    const refresh = () => { if (window.ScrollTrigger) ScrollTrigger.refresh(); };
    sum.addEventListener("click", (e) => {
      e.preventDefault();
      if (anim) anim.cancel();
      const dur = reduceMotion ? 0 : 450;
      const easing = "cubic-bezier(.22,1,.36,1)";
      if (!d.open) {
        // close any other open item first
        $$(".acc[open]").forEach((o) => o !== d && $("summary", o).click());
        d.open = true;
        const h = body.scrollHeight;
        anim = body.animate([{ height: "0px", opacity: 0 }, { height: h + "px", opacity: 1 }], { duration: dur, easing });
        anim.onfinish = () => { anim = null; refresh(); };
      } else {
        const h = body.offsetHeight;
        d.classList.add("is-closing");
        anim = body.animate([{ height: h + "px", opacity: 1 }, { height: "0px", opacity: 0 }], { duration: dur * 0.8, easing });
        anim.onfinish = () => { d.open = false; d.classList.remove("is-closing"); anim = null; refresh(); };
      }
    });
  });

  /* ---------- Countdown to midnight ---------- */
  const pad = (n) => String(n).padStart(2, "0").replace(/\d/g, (d) => "۰۱۲۳۴۵۶۷۸۹"[d]);
  function tick() {
    const now = new Date();
    const end = new Date(now); end.setHours(24, 0, 0, 0);
    let s = Math.max(0, Math.floor((end - now) / 1000));
    const h = Math.floor(s / 3600); s -= h * 3600;
    const m = Math.floor(s / 60); s -= m * 60;
    $("#tH").textContent = pad(h);
    $("#tM").textContent = pad(m);
    $("#tS").textContent = pad(s);
  }
  tick(); setInterval(tick, 1000);

  /* ---------- Product slider buttons (RTL aware) ---------- */
  renderProducts();
  const track = $("#products");
  $$(".slider-nav [data-dir]").forEach((b) =>
    b.addEventListener("click", () => {
      const card = $(".p-card", track);
      const step = card ? card.getBoundingClientRect().width + 20 : 300;
      // in RTL, "next" content lies to the left (negative x)
      track.scrollBy({ left: b.dataset.dir === "next" ? -step : step, behavior: "smooth" });
    })
  );

  /* ---------- Counters ---------- */
  function runCounter(el) {
    const to = Number(el.dataset.to);
    const latin = el.hasAttribute("data-latin");
    const fmt = (v) => (latin ? String(v) : fa(v));
    if (reduceMotion || !hasGsap) { el.textContent = fmt(to); return; }
    const o = { v: 0 };
    gsap.to(o, { v: to, duration: 2, ease: "power3.out", onUpdate: () => (el.textContent = fmt(Math.round(o.v))) });
  }

  /* ---------- Split words for scroll reveal ---------- */
  function splitWords(el) {
    const out = [];
    [...el.childNodes].forEach((node) => {
      const muted = node.nodeType === 1 && node.classList.contains("muted");
      const text = node.textContent;
      text.split(/(\s+)/).forEach((part) => {
        if (!part) return;
        if (/^\s+$/.test(part)) { out.push(document.createTextNode(part)); return; }
        const s = document.createElement("span");
        s.className = "w" + (muted ? " muted" : "");
        s.textContent = part;
        out.push(s);
      });
    });
    el.innerHTML = "";
    out.forEach((n) => el.appendChild(n));
  }

  /* ---------- 3D controller frame sequence ---------- */
  const SPIN_FRAMES = 96;
  const spinSrc = (i) => `assets/img/xbox-controller/${String(i + 1).padStart(3, "0")}.webp`;
  function initSpin() {
    const canvas = $("#spinCanvas");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    const imgs = [];
    let current = -1;
    const draw = (i) => {
      i = Math.max(0, Math.min(SPIN_FRAMES - 1, i));
      const img = imgs[i];
      if (!img || !img.complete || !img.naturalWidth) return;
      current = i;
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    for (let i = 0; i < SPIN_FRAMES; i++) {
      const im = new Image();
      im.decoding = "async";
      im.src = spinSrc(i);
      if (i === SPIN_FRAMES - 1) im.onload = () => current < 0 && draw(SPIN_FRAMES - 1);
      imgs.push(im);
    }
    const feats = $$(".spin__feats li");
    const bar = $("#spinBar");
    const update = (p) => {
      // reversed: starts from the back, ends facing the viewer
      draw(Math.round((1 - p) * (SPIN_FRAMES - 1)));
      if (bar) bar.style.width = (p * 100).toFixed(1) + "%";
      feats.forEach((li) => li.classList.toggle("is-on", p >= Number(li.dataset.at)));
    };
    if (!hasGsap || reduceMotion) {
      // fallback: plain scroll listener
      const sec = $("#spin");
      const onS = () => {
        const r = sec.getBoundingClientRect();
        const total = r.height - innerHeight;
        update(Math.min(1, Math.max(0, -r.top / total)));
      };
      window.addEventListener("scroll", onS, { passive: true });
      onS();
      return;
    }
    // rotation follows scroll: starts as the section enters, ends as the pin releases
    ScrollTrigger.create({
      trigger: "#spin", start: "top 60%", end: "bottom bottom", scrub: true,
      onUpdate: (self) => update(self.progress),
    });
    // page keeps a gentle motion while the controller rotates
    gsap.fromTo(".spin__stage", { y: 70 }, { y: -50, ease: "none",
      scrollTrigger: { trigger: "#spin", start: "top bottom", end: "bottom top", scrub: true } });
    gsap.fromTo(".spin__text", { y: 50 }, { y: -40, ease: "none",
      scrollTrigger: { trigger: "#spin", start: "top bottom", end: "bottom top", scrub: true } });
  }

  /* =========================================================
     Motion (GSAP)
     ========================================================= */
  if (!hasGsap || reduceMotion) {
    $$(".count").forEach((el) => runCounter(el));
    initSpin();
    return;
  }
  gsap.registerPlugin(ScrollTrigger);

  // hide hero parts until intro plays
  gsap.set(".hero__title .line > span", { yPercent: 110 });
  gsap.set([".hero__sub", ".hero__btn"], { autoAlpha: 0, y: 20 });
  gsap.set(".hero__char", { autoAlpha: 0, y: 80, scale: 0.94 });
  gsap.set([".hero__side--card", ".hero__side--stats"], { autoAlpha: 0, y: 40 });
  gsap.set(".hero__ground", { yPercent: 40 });

  function heroIntro() {
    const tl = gsap.timeline({ defaults: { ease: "power4.out" } });
    tl.to(".hero__title .line > span", { yPercent: 0, duration: 1.1, stagger: 0.12 })
      .to([".hero__sub", ".hero__btn"], { autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.08 }, "-=0.7")
      .to(".hero__ground", { yPercent: 0, duration: 1.2 }, "-=0.9")
      .to(".hero__char", { autoAlpha: 1, y: 0, scale: 1, duration: 1.2, ease: "back.out(1.4)" }, "-=1.0")
      .to([".hero__side--card", ".hero__side--stats"], { autoAlpha: 1, y: 0, duration: 0.9, stagger: 0.1 }, "-=0.8")
      .add(() => $$(".hero .count").forEach(runCounter), "-=0.6");
    // idle float of character
    gsap.to(".hero__char", { y: -12, duration: 2.6, ease: "sine.inOut", yoyo: true, repeat: -1, delay: 2.2 });
  }
  if ($("#preloader").classList.contains("is-done")) heroIntro();
  else document.addEventListener("site:ready", heroIntro, { once: true });

  // hero parallax on scroll
  gsap.to(".hero__head", {
    y: 160, autoAlpha: 0.2, ease: "none",
    scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: true },
  });
  // the character sinks behind the grass while scrolling
  gsap.to(".hero__char-wrap", {
    yPercent: 55, ease: "none",
    scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: 0.6 },
  });

  gsap.to(".hero__glow", {
    opacity: 0.3, ease: "none",
    scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: true },
  });

  // word-by-word reveal
  $$(".reveal-words").forEach((el) => {
    splitWords(el);
    gsap.fromTo($$(".w", el), { opacity: 0.14 }, {
      opacity: 1, stagger: 0.08, ease: "none",
      scrollTrigger: { trigger: el, start: "top 85%", end: "bottom 45%", scrub: true },
    });
  });

  // category cards
  gsap.from(".cat-card", {
    y: 90, autoAlpha: 0, rotate: 0, duration: 1.1, ease: "power3.out", stagger: { each: 0.09, from: "start" },
    scrollTrigger: { trigger: ".cat-grid", start: "top 85%" },
  });

  // generic fade-up groups
  const groups = [
    [".sec-head", 0],
    [".bento__card", 0.1],
    [".p-card", 0.06],
    [".plat", 0.12],
    [".step", 0.12],
    [".gift", 0.06],
    [".acc", 0.07],
    [".coupon", 0],
  ];
  groups.forEach(([sel, st]) => {
    ScrollTrigger.batch(sel, {
      start: "top 88%",
      once: true,
      onEnter: (els) => gsap.fromTo(els, { y: 50, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.9, ease: "power3.out", stagger: st, overwrite: true }),
    });
    gsap.set(sel, { autoAlpha: 0 });
  });

  // spotlight
  gsap.from(".spot__img", {
    y: 80, scale: 0.85, autoAlpha: 0, duration: 1.3, ease: "power3.out",
    scrollTrigger: { trigger: ".spot", start: "top 75%" },
  });
  gsap.from(".bubble", {
    scale: 0.4, autoAlpha: 0, duration: 0.9, ease: "back.out(1.8)", stagger: 0.12,
    scrollTrigger: {
      trigger: ".spot", start: "top 65%",
      onEnter: () => $$(".spot .count").forEach(runCounter),
    },
  });
  gsap.to(".spot__img", {
    yPercent: -8, ease: "none",
    scrollTrigger: { trigger: ".spot", start: "top bottom", end: "bottom top", scrub: true },
  });

  // timeline progress
  ScrollTrigger.create({
    trigger: "#timeline", start: "top 60%", end: "bottom 60%", scrub: true,
    onUpdate: (self) => { $("#tlFill").style.height = (self.progress * 100).toFixed(2) + "%"; },
  });
  $$(".tl-item").forEach((item) => {
    ScrollTrigger.create({
      trigger: item, start: "top 60%", end: "bottom 60%",
      onEnter: () => item.classList.add("is-active"),
      onLeaveBack: () => item.classList.remove("is-active"),
    });
    gsap.from($(".tl-card", item), {
      x: item.matches(":nth-child(odd)") ? -60 : 60, autoAlpha: 0, duration: 1, ease: "power3.out",
      scrollTrigger: { trigger: item, start: "top 80%" },
    });
  });

  // 3D controller: scroll-driven rotation (image sequence on canvas)
  initSpin();

  // CTA
  gsap.fromTo(".cta__img", { yPercent: 75, scale: 0.92 }, {
    yPercent: 0, scale: 1, ease: "none",
    scrollTrigger: { trigger: ".cta__box", start: "top 95%", end: "top 35%", scrub: 0.8 },
  });
  gsap.from(".cta__text > *", {
    y: 30, autoAlpha: 0, duration: 0.8, stagger: 0.08, ease: "power3.out",
    scrollTrigger: { trigger: ".cta__box", start: "top 75%" },
  });

  window.addEventListener("load", () => ScrollTrigger.refresh());
})();
