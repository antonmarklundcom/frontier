/* Paraguay Frontier — progressive enhancement only.
   Nothing here is required to read the site, submit a form, or navigate it.
   Motion budget: hero route draw, scroll reveal on ~12% of elements, rail
   progress, and one very slow hero contour drift on desktop. */
(function () {
  'use strict';

  var d = document;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* -- 1. Desktop navigation panels ------------------------------------- */
  var panelItems = d.querySelectorAll('.nav__item--has-panel');
  function closeAllPanels(except) {
    panelItems.forEach(function (item) {
      if (item === except) return;
      item.classList.remove('is-open');
      var btn = item.querySelector('.nav__link');
      var panel = item.querySelector('.panel');
      if (btn) btn.setAttribute('aria-expanded', 'false');
      if (panel) panel.hidden = true;
    });
  }
  panelItems.forEach(function (item) {
    var btn = item.querySelector('.nav__link');
    var panel = item.querySelector('.panel');
    if (!btn || !panel) return;
    btn.addEventListener('click', function () {
      var open = btn.getAttribute('aria-expanded') === 'true';
      closeAllPanels(item);
      btn.setAttribute('aria-expanded', String(!open));
      panel.hidden = open;
      item.classList.toggle('is-open', !open);
    });
    item.addEventListener('keydown', function (e) {
      if (e.key !== 'Escape') return;
      closeAllPanels();
      btn.focus();
    });
    // Pointer users expect hover; keyboard users get click. Both close on leave.
    item.addEventListener('mouseenter', function () {
      if (window.matchMedia('(hover: hover)').matches && window.innerWidth >= 1080) {
        closeAllPanels(item);
        btn.setAttribute('aria-expanded', 'true');
        panel.hidden = false;
        item.classList.add('is-open');
      }
    });
    item.addEventListener('mouseleave', function () {
      if (window.matchMedia('(hover: hover)').matches && window.innerWidth >= 1080) {
        btn.setAttribute('aria-expanded', 'false');
        panel.hidden = true;
        item.classList.remove('is-open');
      }
    });
  });
  d.addEventListener('click', function (e) {
    if (!e.target.closest('.nav__item--has-panel')) closeAllPanels();
  });

  /* -- 2. Mobile drawer -------------------------------------------------- */
  var burger = d.querySelector('.burger');
  var drawer = d.getElementById('mobile-nav');
  if (burger && drawer) {
    burger.addEventListener('click', function () {
      var open = burger.getAttribute('aria-expanded') === 'true';
      burger.setAttribute('aria-expanded', String(!open));
      drawer.hidden = open;
      d.documentElement.style.overflow = open ? '' : 'hidden';
      if (!open) {
        var first = drawer.querySelector('a');
        if (first) first.focus();
      }
    });
    drawer.addEventListener('keydown', function (e) {
      if (e.key !== 'Escape') return;
      burger.setAttribute('aria-expanded', 'false');
      drawer.hidden = true;
      d.documentElement.style.overflow = '';
      burger.focus();
    });
  }

  /* -- 3. Sticky header state ------------------------------------------- */
  var hdr = d.querySelector('[data-sticky-header]');
  if (hdr) {
    var ticking = false;
    var onScroll = function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        hdr.classList.toggle('is-stuck', window.scrollY > 24);
        ticking = false;
      });
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* -- 4. Hero route draw ------------------------------------------------ */
  var route = d.querySelector('[data-route]');
  if (route) {
    if (reduce) {
      route.classList.add('is-drawn');
    } else {
      requestAnimationFrame(function () {
        requestAnimationFrame(function () { route.classList.add('is-drawn'); });
      });
    }
  }

  /* -- 5. Scroll reveal, capped stagger ---------------------------------- */
  var items = d.querySelectorAll('[data-reveal]');
  if (reduce || !('IntersectionObserver' in window)) {
    items.forEach(function (el) { el.style.opacity = 1; el.style.transform = 'none'; });
  } else {
    items.forEach(function (el) {
      el.style.opacity = 0;
      el.style.transform = 'translateY(18px)';
      el.style.transition = 'opacity 280ms cubic-bezier(.16,1,.3,1), transform 280ms cubic-bezier(.16,1,.3,1)';
    });
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var i = Math.min(+(en.target.dataset.reveal || 0), 6);
        en.target.style.transitionDelay = (i * 70) + 'ms';
        en.target.style.opacity = 1;
        en.target.style.transform = 'none';
        io.unobserve(en.target);
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.15 });
    items.forEach(function (el) { io.observe(el); });
  }

  /* -- 6. Frontier Route rail: progress + current section ---------------- */
  var rail = d.querySelector('[data-rail]');
  if (rail && 'IntersectionObserver' in window) {
    var progress = rail.querySelector('[data-rail-progress]');
    var links = Array.prototype.slice.call(rail.querySelectorAll('[data-rail-link]'));
    var sections = links.map(function (l) { return d.getElementById(l.dataset.railLink); });
    var railTicking = false;

    var update = function () {
      if (railTicking) return;
      railTicking = true;
      requestAnimationFrame(function () {
        var doc = d.documentElement;
        var max = doc.scrollHeight - window.innerHeight;
        var pct = max > 0 ? Math.min(Math.max(window.scrollY / max, 0), 1) : 0;
        if (progress) progress.style.height = (pct * 100) + '%';

        // The rail lives in the left margin over the light page field. It
        // fades in once the dark hero has scrolled away, so its ink labels are
        // never rendered on the dark band where they would be unreadable.
        rail.classList.toggle('is-visible', window.scrollY > window.innerHeight * 0.55);

        var mid = window.scrollY + window.innerHeight * 0.4;
        var currentIdx = -1;
        sections.forEach(function (sec, i) {
          if (sec && sec.offsetTop <= mid) currentIdx = i;
        });
        links.forEach(function (l, i) {
          var li = l.parentElement;
          li.classList.toggle('is-current', i === currentIdx);
          li.classList.toggle('is-past', i < currentIdx);
        });
        railTicking = false;
      });
    };
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
    update();
  }

  /* -- 7. "Where are you?" router panel ---------------------------------- */
  /* The server ships plain anchors and all panes visible. Only once we know JS
     is running do we hide panes and promote the list to a tablist — so the
     content is never gated behind a script that failed to load. */
  var router = d.querySelector('[data-router]');
  if (router) {
    var list = router.querySelector('[data-router-options]');
    var opts = Array.prototype.slice.call(router.querySelectorAll('.router__opt'));
    var panes = Array.prototype.slice.call(router.querySelectorAll('[data-router-pane]'));

    list.setAttribute('role', 'tablist');
    list.querySelectorAll('li').forEach(function (li) { li.setAttribute('role', 'presentation'); });
    opts.forEach(function (o, i) {
      o.setAttribute('role', 'tab');
      o.setAttribute('aria-controls', 'rpane-' + i);
    });
    panes.forEach(function (p, i) {
      p.setAttribute('role', 'tabpanel');
      p.setAttribute('aria-labelledby', 'rtab-' + i);
      p.tabIndex = 0;
    });

    var select = function (idx, focus) {
      opts.forEach(function (o, i) {
        o.setAttribute('aria-selected', String(i === idx));
        o.tabIndex = i === idx ? 0 : -1;
      });
      panes.forEach(function (p, i) { p.hidden = i !== idx; });
      if (focus) opts[idx].focus();
    };

    opts.forEach(function (o, i) {
      o.addEventListener('click', function (e) { e.preventDefault(); select(i, false); });
      o.addEventListener('keydown', function (e) {
        var n = null;
        if (e.key === 'ArrowDown' || e.key === 'ArrowRight') n = (i + 1) % opts.length;
        if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') n = (i - 1 + opts.length) % opts.length;
        if (e.key === 'Home') n = 0;
        if (e.key === 'End') n = opts.length - 1;
        if (n === null) return;
        e.preventDefault();
        select(n, true);
      });
    });
    select(0, false);
  }

  /* -- 8. Hero contour drift: desktop, pointer, motion-allowed only ------ */
  var contours = d.querySelector('[data-drift]');
  if (contours && !reduce && window.innerWidth >= 1024) {
    var driftTicking = false;
    window.addEventListener('scroll', function () {
      if (driftTicking) return;
      driftTicking = true;
      requestAnimationFrame(function () {
        var y = Math.min(window.scrollY, 900);
        contours.style.transform = 'translate3d(0,' + (y * 0.07) + 'px,0)';
        driftTicking = false;
      });
    }, { passive: true });
  }
})();
