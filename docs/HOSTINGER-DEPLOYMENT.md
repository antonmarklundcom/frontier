# Hostinger deployment

The release is a zip whose **root is the document root**. There is no wrapper
directory: extracting it inside `public_html` puts `index.php` directly at
`public_html/index.php`. That is deliberate — a nested folder is the most common
way a PHP upload ends up serving a directory listing instead of a site.

Build it with:

```bash
php tools/build-release.php
# -> release/paraguayfrontier-mvp-hostinger.zip
```

The build script verifies its own output and exits non-zero if the archive has
backslash paths, is missing a root-level file, or has picked up `docs/` or a
server-owned config file.

---

## 1. Check the PHP version first

In hPanel, open the PHP configuration for the domain and confirm **PHP 8.1 or
newer**. The code uses `str_contains`, `str_starts_with` and typed properties,
so 8.0 and below will fatal on the first request.

While you are there, confirm `mod_rewrite` and `mod_headers` are available. On
Hostinger's shared Apache they normally are, but every directive in `.htaccess`
is wrapped in `<IfModule>` so a missing module degrades rather than 500s. The
one exception is `ErrorDocument`, which is unconditional and standard.

## 2. Upload and extract

1. hPanel → File Manager → open `public_html`.
2. Delete any default `index.html` or parking page already there.
3. Upload `paraguayfrontier-mvp-hostinger.zip`.
4. Extract **into `public_html` itself**, not into a subfolder.
5. Confirm `public_html/index.php` and `public_html/app/bootstrap.php` exist. If
   you see `public_html/paraguayfrontier-mvp-hostinger/index.php`, the extract
   nested — move the contents up one level.
6. Delete the zip from the server.

SFTP works equally well; the only thing that matters is where `index.php` lands.

## 3. Create the server-owned config

The release ships `config/site.example.php` but **not** `config/site.php`. That
is intentional: your live configuration must survive a redeploy, so the release
never overwrites it.

Copy `config/site.example.php` to `config/site.php` and fill in:

```php
'email'        => 'you@paraguayfrontier.com',
'whatsapp'     => '595XXXXXXXXX',   // E.164 digits only, no + and no spaces
'calendar_url' => 'https://...',
'launched'     => false,            // keep false until the checklist is clear
```

Until you do, the site still runs — `app/bootstrap.php` falls back to the
example file — but every contact surface stays hidden, because the code
suppresses UI that depends on an unresolved `[PLACEHOLDER]` rather than
rendering the placeholder to a visitor.

Never put SMTP or CRM credentials in `config/site.php`. Those belong in
`config/env.php`, created from `config/env.example.php`, which is excluded from
every release for the same reason.

## 4. Verify includes and the deny rules

Load the home page. Raw PHP source means the host is not executing PHP for that
directory. A working page with no styling means the CSS path is wrong — check
that `public_html/assets/css/site.css` exists.

Then run the two checks that catch `.htaccess` problems:

- `https://paraguayfrontier.com/app/bootstrap.php` → must return **403**
- `https://paraguayfrontier.com/config/site.php` → must return **403**

If either returns 200 or a blank page, the deny rule is not applying. Fix that
before going further — those files are not secret today, but `config/env.php`
will hold credentials.

## 5. Email delivery

Not configured yet, and the consultation form is not built yet either. When it
is: use **authenticated SMTP** with credentials in `config/env.php`, not PHP
`mail()`, which on shared hosting fails SPF/DKIM and lands in spam.

**Do not describe the form as working until a real message has arrived in the
destination inbox.** A 200 response from the handler is not delivery.

## 6. Going live (not yet)

All of these happen together, in this order:

1. Clear every item in `docs/PRODUCTION-DATA-REQUIRED.md`.
2. Set `'launched' => true` in `config/site.php`.
3. Replace `robots.txt` with the block commented at the bottom of the current
   file — the `Allow: /` version with the sitemap line.
4. Run `php tools/build-sitemap.php` locally and upload the regenerated
   `sitemap.xml`. It stays empty while `launched` is false, so regenerating it
   is not optional.
5. Verify the domain in Google Search Console **by DNS TXT record**, not an HTML
   file or meta tag. TXT survives redeploys.
6. Submit `https://paraguayfrontier.com/sitemap.xml`.
7. Spot-check three live pages for `<meta name="robots" content="index,follow`.

Step 3 is the one people forget, and forgetting it is the most common reason a
finished site never ranks.

## 7. Rolling back

Keep the previous release zip. To roll back, re-extract it over the top — every
file it contains is overwritten wholesale. `config/site.php` and
`config/env.php` are untouched by any release, so your configuration survives
the rollback automatically. Clear the LiteSpeed cache if it is enabled; asset
URLs are cache-busted by file mtime, which usually makes that unnecessary.

## 8. What has not been tested

Nothing in this document has been executed against a real Hostinger account. The
release zip has been built, extracted and served successfully on a local PHP 8.4
server, which proves the archive structure and the application, but **not**:

- whether Hostinger's Apache honours these specific `.htaccess` directives
- the HTTPS and non-www redirects
- the `ErrorDocument` mappings
- compression and cache headers
- SMTP delivery

Work through `docs/HOSTINGER-LIVE-TEST-CHECKLIST.md` on the live host. Until it
is complete, the correct description of this project is "packaged for
Hostinger", not "deployed".
