# QA report — home page build

Date: 2026-08-17 · Scope: home page, shared system, all 32 routes resolving.

## What was actually verified, and how

| Check | Method | Result |
|---|---|---|
| PHP syntax, every file | `php -l` on all project PHP | Pass |
| All 32 routes respond | `php -S` + rendering each registry id | Pass (`/errors/404/` correctly returns 404) |
| Exactly one `<h1>` per page | `tools/qa.php`, rendered HTML | Pass, 32/32 |
| Unique title / description / URL | `tools/qa.php` | Pass, no duplicates |
| Self-referencing canonical | `tools/qa.php` | Pass, 32/32 |
| JSON-LD parses | `json_decode` on rendered `ld+json` | Pass, 32/32 |
| No dead internal links | crawl of every `href` against the registry + filesystem | Pass (one bug found and fixed: root `href` produced `//`) |
| No placeholder text reaches HTML | regex for `[UPPER_CASE]` in rendered text | Pass |
| No secrets in client assets | regex over css/js | Pass |
| Horizontal overflow | Chromium at 320 / 375 / 768 / 1024 / 1440 / 1920 px | Pass (bug found and fixed at 320px) |
| Console errors | Chromium, desktop + mobile | None |
| Touch targets ≥ 44px | measured every `a`/`button` at 390px | Pass (7 controls found undersized and fixed) |
| Keyboard tab order + focus rings | 14 tab presses, checked `activeElement` and outline | Pass, logical order, 2px outline on every stop |
| `prefers-reduced-motion` | Chromium `reducedMotion: 'reduce'` | Pass — no hidden reveals, route renders complete |
| Works with JavaScript disabled | Chromium `javaScriptEnabled: false` | Pass — 1,902 words readable, all 6 router panes visible |
| Page weight | Chromium response accounting | 293 KB total (fonts 192, document 58, CSS 35, JS 9) |
| LCP / CLS | PerformanceObserver, local server | LCP 200 ms, CLS 0.0011 |

## Bugs found by looking at screenshots, and fixed

1. **Header invisible over the dark hero.** The masthead is sticky *above* the
   hero, not over it, so `background: transparent` revealed the light page
   field and the light-coloured wordmark vanished. Now a solid ink bar.
2. **Navigation links rendered ink-on-ink.** The generic `li { color: ink-70 }`
   prose rule was leaking into the nav list. Scoped out for nav, footer, panel,
   drawer and rail lists.
3. **Eyebrows and ghost buttons invisible on dark sections.** The dark sections
   carried their own class but not `.on-ink`, so the on-dark colour rules never
   applied.
4. **The overlap never overlapped.** The guides section's bottom padding was
   larger than the panel's negative margin, and `isolation: isolate` on the
   grain helper trapped the panel in its own stacking context.
5. **White panel text on white.** The light panel sits inside an `.on-ink`
   section and inherited the on-dark heading colour.
6. **Mobile drawer misaligned.** It was inset by a hard-coded 76px that only
   matched one viewport; now full-viewport with the header floating above it.
7. **Root links emitted `href="//"`.**
8. **44px overflow at 320px** from the header brand line.
9. **Router content gated behind JavaScript** — five of six panes were
   server-rendered `hidden`. Now all panes render and JS upgrades the list
   into a tablist.

## Not verified — do not claim these

- **Live Hostinger behaviour.** Nothing has been uploaded. `.htaccess` rewrite
  rules, `ErrorDocument`, compression and header directives are untested against
  Hostinger's actual Apache configuration.
- **Form delivery.** The consultation form handler is not built yet. No message
  has been sent or received.
- **Legal and tax accuracy.** No qualified reviewer has read any content.
- **Lighthouse scores.** LCP/CLS above are from a local PHP dev server on
  loopback, not a throttled mobile profile on real hosting.
- **Indexing.** The site is closed to crawlers and has never been submitted.

---

## Second pass — `/integrity/` and `/editorial-standards/`

Both pages are now written and live (still `noindex`, like the rest of the site).
They were the highest-value gap: the home page links to both and promises what
they contain, and until now both landed on an "in preparation" notice.

| Check | Result |
|---|---|
| Both routes render, 200 | Pass |
| One h1, canonical, valid JSON-LD | Pass |
| FAQPage schema present, 4 questions, matches visible FAQs | Pass |
| No console errors, no overflow at 390 / 1440 px | Pass |
| `<details>` FAQ toggles by click and by keyboard | Pass |
| QA harness across all 32 routes | 0 failures, 0 warnings |

Bugs found and fixed in this pass:

10. **FAQ schema crashed on multi-paragraph answers.** `strip_tags()` was called
    on an array. Answers now accept a string or a list of paragraphs, and
    `FAQPage` is emitted *only* when the page actually renders a visible FAQ
    block — so markup and structured data cannot disagree.
11. **Interior page header was centre-aligned** while every section below it was
    left-aligned, because `max-width` sat on the `.wrap` element itself.

Still not verified: live Hostinger behaviour, form delivery, legal/tax review.
