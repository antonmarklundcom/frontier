# Deploying Paraguay Frontier to Hostinger

No build step, no database, no Node, no Composer. The release is a zip whose
root is the document root: it extracts straight into `public_html`.

Two deployments are described, and they are not the same event:

- **Staging** — a subdomain, closed to crawlers, done today. This is the only
  way to verify the `.htaccess` rules, because PHP's built-in server ignores
  `.htaccess` entirely and nothing on a laptop can prove those rules work.
- **Launch** — the live domain, open to crawlers. Blocked until
  `PRODUCTION-DATA-REQUIRED.md` is cleared. See "Going live" at the end.

---

## 1. Build the release

```bash
php tools/build-release.php
```

It refuses to build if `php -l` or `tools/qa.php` fails. On success it writes
`release/paraguayfrontier-YYYY-MM-DD-HHMM.zip` and prints the state of the
build — which config file it read, whether `launched` is set, and which
placeholders are still open.

What ships: `index.php`, `.htaccess`, `robots.txt`, `sitemap.xml`,
`manifest.webmanifest`, `assets/`, `app/`, the route directories, and the two
`config/*.example.php` files.

What does not: `.git/`, `docs/`, `tools/`, and — deliberately —
`config/site.php` and `config/env.php`. Your real values live on the server
only. A deploy therefore can never overwrite them with local ones, and a
credential can never reach the repository by way of a release zip.

## 2. Hostinger setup

In hPanel, for the target domain or subdomain:

1. **PHP version** — Advanced → PHP Configuration → **8.1 or newer**. The code
   uses `str_contains`, `str_starts_with`, typed properties and `?->`; on PHP
   7.x it fatals on the first request.
2. **PHP options** — `display_errors` **off**. An error must reach the log, not
   a prospect. `/errors/500/` is the page they should see instead.
3. **SSL** — issue the free certificate and turn on Force HTTPS. The
   `.htaccess` also forces HTTPS; both on is correct, and the rule is written to
   respect `X-Forwarded-Proto` so it cannot loop behind Hostinger's proxy.
4. For staging, create a subdomain (e.g. `staging.paraguayfrontier.com`). It
   gets its own `public_html`. Keep the site's `robots.txt` as-is there — it
   already says `Disallow: /`.

## 3. Upload

hPanel → File Manager → open `public_html` → Upload the zip → right-click →
Extract → **into the current directory**.

Afterwards `public_html/index.php` must exist. If you instead have
`public_html/paraguayfrontier-2026-.../index.php`, the extract added a folder
level: move the contents up one and delete the empty folder. Every path in the
site is absolute from the document root, so an extra level breaks everything at
once, in an obvious way.

Confirm `.htaccess` came across. File Manager hides dotfiles by default —
Settings → Show hidden files. A missing `.htaccess` is the single most common
cause of "the home page works but every other page 404s".

## 4. Create `config/site.php` on the server

The site runs without it (`bootstrap.php` falls back to `site.example.php`), but
then every contact surface stays suppressed. Copy `config/site.example.php` to
`config/site.php` in File Manager and fill in what you have. Values still
written as `[LIKE_THIS]` are treated as unknown and the UI that depends on them
is omitted rather than shown with a placeholder in it.

The values that change the site's character, and exactly what each one switches
on **today**:

| Key | Format | Filling it in does this |
|---|---|---|
| `whatsapp` | E.164 digits only, `595991234567` | renders the WhatsApp link in the footer and in every consultation CTA block. Currently zero WhatsApp links exist on any page. |
| `email` | `you@paraguayfrontier.com` | renders the footer email link, and adds `email` to the Organization schema. Currently zero `mailto:` links exist. |
| `calendar_url` | full `https://` URL | nothing yet — no template reads it. It is stored for `/book-consultation/`, which still has to be written as a content file. |
| `address`, `company_reg`, `founder` | plain strings | nothing yet — no template reads them. They are wired into the schema and footer when those pages are written. |

So two values — `whatsapp` and `email` — are what actually take the site from
"no way to contact anyone" to "contactable on every page". The booking page is a
content-writing job, not a config job.

Leave `'launched' => false` until section 7.

`config/env.php` (SMTP, CRM) is only needed once the consultation form posts
somewhere. Copy `config/env.example.php` to `config/env.php` when you set that
up, and give it permissions `600` if File Manager lets you.

## 5. Verify the deploy

From your machine, against the uploaded site:

```bash
php tools/smoke-test.php https://staging.paraguayfrontier.com
```

It requests all 32 registered URLs, then probes the `.htaccess` rules. It
detects Apache/LiteSpeed and only enforces the rewrite checks when a server that
honours `.htaccess` is actually answering — which is why running it against
`php -S` locally reports those lines as `skip`.

Expected on a correct deploy, all green:

- every route `200`, except `/errors/404/` → `404` and `/errors/500/` → `500`
  (deliberate: an error document that answers `200` is worse than none)
- no `[PLACEHOLDER]` string anywhere in any rendered page
- `/about` → `301` to `/about/`
- `/app/bootstrap.php` and `/config/site.example.php` → `403`
- `http://` → `301` to `https://`
- `X-Content-Type-Options`, `Referrer-Policy`, `Content-Security-Policy`,
  `X-Frame-Options` all present on `/`

Then look at it on a phone, on the real connection. That is the part no script
covers, and the reason staging exists.

### If something is wrong

| Symptom | Cause | Fix |
|---|---|---|
| Home page fine, all other routes 404 | `.htaccess` missing or dotfiles hidden | re-upload `.htaccess` |
| Every page is a blank white screen | PHP < 8.1, or a fatal with `display_errors` off | switch PHP version; read the error log in hPanel |
| Raw PHP source displayed | PHP handler not applied to the directory | check the domain is mapped to this `public_html` |
| `403` on legitimate pages | over-broad deny rule, or wrong ownership on extract | check file permissions are 644 / directories 755 |
| CSP header missing | `mod_headers` unavailable | Hostinger's LiteSpeed supports it; confirm the `.htaccess` uploaded whole |
| Redirect loop on HTTPS | Force HTTPS in hPanel fighting rule 1 | leave both on; if it loops, turn off hPanel's and keep the `.htaccess` rule |

## 6. Redeploying

Rebuild, upload, extract over the top, overwrite when prompted. `config/site.php`
and `config/env.php` are not in the zip, so they survive untouched. Delete stale
files by hand if a route is ever removed from the registry — extraction adds and
overwrites, it never deletes.

## 7. Going live

Do not do any of this while `docs/PRODUCTION-DATA-REQUIRED.md` still has open
launch blockers. The order matters:

1. Fill in `config/site.php` completely — no `[PLACEHOLDER]` values left.
2. Set `'launched' => true`.
3. Replace `robots.txt` with the open version written in the comment at the
   bottom of that file.
4. `php tools/build-sitemap.php` — it lists only pages that have real content
   files, so unwritten routes stay out of it.
5. `php tools/qa.php` — it must report 0 failures with `launched` true.
6. Rebuild, upload, and run `smoke-test.php` against the live domain. The
   "home page is INDEXABLE" note is now the one you want to see.
7. Google Search Console: verify the domain, submit `/sitemap.xml`, request
   indexing on the home page.

A partial launch is legitimate and is the fastest honest route to a site that
earns: publish `/`, `/integrity/`, `/editorial-standards/` and a working
`/book-consultation/`, and leave the guides unwritten. Pages with no content
file render the "in preparation" page and stay `noindex` and out of the sitemap
on their own — no configuration needed, and nothing unreviewed gets indexed.
