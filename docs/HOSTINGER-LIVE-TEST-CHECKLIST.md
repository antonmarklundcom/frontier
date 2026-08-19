# Hostinger live-test checklist

Run this **on the live host**, in a browser, against the real domain. Everything
in it is currently unverified — the local build proves the code, not the
hosting. Record the date and the result next to each line; a checklist with
blank results is not evidence.

Tested on: ______________  By: ______________

---

## A. It is actually serving

- [ ] `https://paraguayfrontier.com/` returns the home page, not a directory
      listing, not a parking page, not raw PHP source
- [ ] `public_html/index.php` is at the root, with no wrapper directory
- [ ] PHP version reported by the host is 8.1 or newer
- [ ] The Frontier Route card in the hero draws its line on load
- [ ] Fonts render as Archivo (condensed headings), not a fallback grotesque

## B. `.htaccess` — the part most likely to differ from local

Most of this section is automated. Run it first and only hand-check what it does
not cover:

```bash
php tools/smoke-test.php https://paraguayfrontier.com
```

It requests every route, fails on any placeholder that reached a visitor, and
probes the deny and redirect rules — enforcing them only when Apache or
LiteSpeed is answering. The `Cache-Control`, `Content-Encoding` and www-redirect
lines below are still yours to check by hand.

- [ ] `http://paraguayfrontier.com/` redirects to `https://` (301)
- [ ] `https://www.paraguayfrontier.com/` redirects to the non-www host (301)
- [ ] `/guides/residency` (no trailing slash) redirects to `/guides/residency/`
- [ ] `/app/bootstrap.php` returns **403**
- [ ] `/config/site.php` returns **403**
- [ ] `/config/env.php` returns **403** or **404** — this is the one that holds
      the SMTP password and the CRM key
- [ ] `/app/errors.php` returns **403** (proves the by-name deny list is
      complete, not just the `/app` rewrite)
- [ ] `/docs/` returns 403 or 404 (docs are excluded from the release, so 404 is
      the expected result)
- [ ] `/assets/` returns 403, not a directory listing
- [ ] A URL that does not exist returns the custom 404 page **with a 404 status**
      — check the status in devtools, not just the page body
- [ ] `Content-Security-Policy`, `X-Content-Type-Options`, `Referrer-Policy`
      and `Strict-Transport-Security` appear in the response headers
- [ ] `Strict-Transport-Security` reads `max-age=31536000; includeSubDomains`.
      Once a browser has seen this header it will refuse plaintext for a year,
      so verify HTTPS works on every hostname the site answers on **before**
      trusting it — including any subdomain, because of `includeSubDomains`
- [ ] `Cache-Control: public, max-age=31536000, immutable` appears on
      `/assets/css/site.css`
- [ ] `Content-Encoding: gzip` or `br` appears on the HTML response

If the CSP header blocks anything, the console will say so. Nothing on the site
loads a third-party resource today, so it should be silent.

## C. Rendering on real devices

Test on an actual phone, not only devtools emulation.

- [ ] iPhone Safari — home page, no horizontal scroll, hero legible
- [ ] Android Chrome — same
- [ ] The mobile menu opens, covers the viewport, and the X closes it
- [ ] The "Where are you in the process?" panel switches on tap
- [ ] `/integrity/` and `/editorial-standards/` FAQ items open and close
- [ ] Desktop 1440px — the left-margin route rail appears after the hero and
      tracks scroll (it is intentionally hidden below 1560px)
- [ ] Print preview of `/integrity/` drops the header, nav and footer links

## D. Speed, measured on the real host

- [ ] PageSpeed Insights **mobile** on the live URL: performance ≥ 90
- [ ] LCP < 2.5s, CLS < 0.1, INP < 200ms in the field or lab data
- [ ] Fonts load once, `woff2`, no flash of fallback lasting more than a moment

Local numbers were LCP 200ms / CLS 0.001 on loopback with no throttling. They
are not a prediction of the live result and must not be quoted as one.

## E. Indexing posture — verify it is still CLOSED

Until launch, all of these must be true:

- [ ] `/robots.txt` serves `Disallow: /`
- [ ] Every page carries `<meta name="robots" content="noindex,nofollow">`
- [ ] `/sitemap.xml` serves an empty `<urlset>`
- [ ] `site:paraguayfrontier.com` in Google returns nothing

If any page is indexable before the production-data checklist is clear, stop and
set `'launched' => false`.

## F. Form delivery — only when the form exists

- [ ] A submission from the live site arrives in the destination inbox
- [ ] The message is not in spam (check SPF/DKIM alignment)
- [ ] Submitting returns the thank-you page via redirect, so a refresh does not
      resubmit
- [ ] An invalid submission shows a usable error, not a blank page or a 500
- [ ] The honeypot and minimum-completion-time checks reject an instant submit
- [ ] No API key or credential appears in the page source or in any network
      request the browser makes

**Until the first box in section F is ticked with a real received message, the
form is not working, regardless of what the browser shows.**
