# Paraguay Frontier

English-language authority and lead-generation site for Paraguay residency, tax
registration and banking preparation. Semantic HTML5, hand-written CSS, vanilla
JavaScript and PHP 8 — no framework, no build step, no database, deployable to
Hostinger shared hosting by unzipping into `public_html`.

**Status: every one of the 32 routes now has its structure built. Six pages are
written (home, integrity, editorial standards, thank-you, 404, 500); the other
26 are drafts whose prose is still an outline of briefs — see
`docs/COPY-BRIEF.md` and `docs/WRITING-GUIDE.md`. Drafts render the honest
"in preparation" notice to visitors. The whole site is `noindex,nofollow` until
`docs/PRODUCTION-DATA-REQUIRED.md` is cleared.**

## Local development

```bash
php -S 127.0.0.1:8080 -t .              # what a visitor sees
PF_PREVIEW=1 php -S 127.0.0.1:8080 -t . # draft outlines rendered in the layout
```

PHP 8.1+ is required (`str_starts_with`, `match`, enums are not used, but typed
properties and `??=` are). No Composer, no npm, no compile step.

## How the site is put together

```
index.php                     two lines: bootstrap + render_page('home')
app/
  bootstrap.php               single entry point for every route
  helpers.php                 escaping, URLs, placeholder suppression
  seo.php                     robots policy, canonical, breadcrumbs
  schema.php                  JSON-LD graph assembly
  draft.php                   copy slots, draft state, preview mode
  form.php                    consultation enquiry: validation, SMTP, CRM
  page-renderer.php           registry lookup, block dispatch
  content/en/
    registry.php              every URL on the site, one entry each
    navigation.php            header + footer structure, by page id
    global.php                locale-wide strings
    pages/<id>.php            one file per route, content as structured data
  templates/
    layout.php                the only <html> document in the project
    partials/                 head, header, footer, breadcrumbs, route rail
    blocks/                   24 block templates — see docs/WRITING-GUIDE.md
config/site.example.php       copy to config/site.php and fill in
config/env.example.php        SMTP and CRM credentials — server only, never committed
storage/                      rate-limit state, created at runtime, web-denied
tools/                        make-routes, build-sitemap, qa, copy-brief,
                              build-release, smoke-test
assets/                       css, js, self-hosted fonts, images
```

### Three page states, decided by the code

| State | What makes it that | What a visitor sees |
|---|---|---|
| `planned` | no content file | "In preparation" notice |
| `draft` | content file with an unwritten `{{ brief }}` in it | "In preparation" notice |
| `live` | content file with no briefs left | the page |

`resolve_page()` derives this on every request, so a page publishes itself when
its last brief is replaced and there is no status flag to forget. Drafts are
`noindex` and absent from the sitemap. `tools/qa.php` fails the build if the
registry's `status` field disagrees, or if a brief ever reaches visitor HTML.

### Adding a page

1. Add an entry to `app/content/en/registry.php` (url, title, description, h1,
   type, cluster, intent — plus `post_handler` if the route accepts a POST).
2. Run `php tools/make-routes.php` — it writes the two-line `index.php`.
3. Write `app/content/en/pages/<id>.php` returning `['blocks' => [...]]`.
4. Run `php tools/qa.php`, `php tools/copy-brief.php` and
   `php tools/build-sitemap.php`.

Templates never need touching. Header, footer, metadata, schema and breadcrumbs
are all derived from the registry, so page 130 costs the same as page 3.

### Writing the remaining copy

`docs/WRITING-GUIDE.md` is the brief: what the rules are, what each block is
for, and the order to work in. `docs/COPY-BRIEF.md` is the worklist — every
unwritten passage on the site, by page, with the key path that leads to it.

```bash
php tools/copy-brief.php                          # regenerate the worklist
php tools/copy-brief.php guides.residency.costs   # just one page, to stdout
```

### Checks

```bash
php tools/qa.php             # metadata, links, schema, drafts, blocks, form, secrets
php tools/build-sitemap.php  # regenerate sitemap.xml from the registry
find . -name '*.php' -not -path './release/*' -exec php -l {} \;
```

## Truthfulness rules baked into the code

- `is_placeholder()` in `app/helpers.php` detects `[LIKE_THIS]` config values.
  Any UI that depends on one — the WhatsApp button, the email link, the company
  registration line — is **omitted**, never rendered with the placeholder
  showing. `tools/qa.php` fails the build if a placeholder ever reaches HTML.
- `robots_directive()` returns `noindex,nofollow` for the whole site while
  `config.launched` is `false`, and for any page without a content file,
  regardless of configuration.
- `schema_graph()` emits `sameAs`, `Person` and `email` only when real values
  exist, and never emits `AggregateRating`, `Review` or unverified
  `LocalBusiness` fields.
- No statistic, price, processing time, approval rate, testimonial or team name
  appears anywhere in the content. Where a competitor would put a number, this
  site states a policy.

## Deployment

```bash
php tools/build-release.php                       # lints, runs QA, writes release/*.zip
php tools/smoke-test.php https://your-host.tld    # after uploading
```

`build-release.php` refuses to build if `php -l` or `tools/qa.php` fails. The
zip's root is the document root — `index.php`, `.htaccess`, `assets/`, `app/`,
the `config/*.example.php` files and the route directories — extracted directly
into `public_html`, with no extra nesting level. `docs/`, `tools/`, `.git/` and
the real `config/site.php` / `config/env.php` are excluded, so a deploy can
never overwrite the server's own values or ship a credential.

`smoke-test.php` requests every registered URL over HTTP, checks that no
placeholder reached a visitor, and probes the `.htaccess` rules — the only way
to verify them, since PHP's built-in server ignores `.htaccess`.

Full procedure, including the Hostinger panel settings and the go-live order:
`docs/HOSTINGER-DEPLOYMENT.md`.
