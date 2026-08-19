# Build log

Append-only. Every build session adds an entry after each PR: what shipped,
what was deliberately skipped, risks or bugs noticed, and ideas worth the
owner's attention. Written for a human catching up, per
`docs/PR-BATCHES.md` standing rule 5.

---

## 2026-08-19 — repo audit and plan revision (no code changed)

Full audit of the codebase as shipped by the 2026-08-17 session. Zero syntax
errors, no secrets in the repo, no exploitable XSS today, unusually disciplined
PHP for a no-framework site. Findings that became work items (now Batch 0 in
`docs/PR-BATCHES.md`):

- No CI existed; qa/release tooling already exit non-zero, so CI is cheap and
  is the prerequisite for merge-when-green.
- An uncaught exception would leak a stack trace: no error handler, and
  `display_errors` was left to the host's default.
- `config/env.php` protection depended solely on `mod_rewrite`; HSTS missing.
- QA blind spots: live-page/content-file sync unchecked at build time,
  block-type validation home-only, navigation ids and block page-references
  unvalidated.
- i18n: content cleanly separated but the renderer hardcodes `content/en/` in
  four places; ~10 user-facing strings live outside the content layer;
  `head.php` referenced a `docs/TRANSLATION-ARCHITECTURE.md` that did not
  exist (now written).
- Five block templates echo trusted raw HTML with no naming convention marking
  the trust boundary.

Decisions taken into the plan: no auth/roles on this site — client portal
deferred to Phase 7 as a separate app, gated on real clients; i18n plumbing
now, translated content later; which language translates first (German vs
Spanish) left as an owner decision in Phase 6.

Owner decisions, same day: **English only for now** — Phase 1.5 plumbing
ships dormant so a later locale gets a clean SEO setup with no template work;
**auto-merge when green** is the standing policy for build sessions (owner
enables branch protection + required CI check after PR-01); **two build
chats** — chat 1 for Batch 0 + PR-10, chat 2 for the guide writing and tools;
**checklist email capture goes to VenderCRM** (added as PR-16).

---

## 2026-08-19 — PR-00 · the manifest lands on `main`

**Why this PR exists at all.** The build session was asked to execute Batch 0
against `docs/PR-BATCHES.md`, and that file was not on `main`. The repository
had two parallel lines of work: `main` (the newer code — the copy-slot draft
system, nine block templates, the enquiry pipeline, `COPY-BRIEF.md`,
`WRITING-GUIDE.md`, `smoke-test.php`, an extended QA harness) and
`claude/paraguay-frontier-mvp-e2e4ju` (the audit line, which held
`PR-BATCHES.md`, `TRANSLATION-ARCHITECTURE.md` and `BUILD-LOG.md`). They
forked at the home-page commit and never rejoined. GitHub's *default branch*
setting still points at the audit line, so the newer work on `main` was the
stranded one.

Owner decision, taken at the top of this session: **`main` is the trunk.**

**Shipped.** `docs/PR-BATCHES.md`, `docs/TRANSLATION-ARCHITECTURE.md` and
`docs/BUILD-LOG.md` copied onto `main`, and `docs/BUILD-PLAN.md` reconciled by
hand — both lines had edited it, so neither version could simply win. The
result keeps `main`'s Phase 2a/2b split and its corrected Phase 3 and 4 (which
describe work that is genuinely done), and grafts in the audit line's Phase
1.5, the Phase 6 second-locale decision, Phase 7 (the deferred client portal)
and the §4 execution model.

Two cards in `PR-BATCHES.md` were rewritten rather than copied, each carrying
a note in place explaining the change:

- **PR-01** was a GitHub Actions workflow. Owner decision this session: the
  repository is private, Actions bills per minute against the account, and no
  part of the deploy path touches a GitHub runner. The gate becomes a local
  `pre-push` hook. See PR-01's own entry for what that forfeits.
- **PR-10** was "build the guide blocks". All nine already shipped on `main`
  with Phase 2a. Re-creating them would have been duplicate work, so the card
  became an audit of the shipped blocks against this batch's discipline.

**Deliberately skipped.** No code changed — this PR is documentation only, so
that the reconciliation is reviewable on its own rather than buried inside the
first functional PR. The two stale branches were not deleted or merged; that
is the owner's call, and nothing in Batch 0 depends on it.

**Risks and things noticed.**

- *The default branch is wrong.* GitHub still has
  `claude/paraguay-frontier-mvp-e2e4ju` as the repository default. Until the
  owner changes it to `main` in repository settings, PRs opened by hand
  default to the wrong base, and a fresh clone checks out the older line.
  This is the single highest-value two-click fix in the repository right now.
- *Standing rule 3 described a gate that no longer exists.* It spoke of
  `status => 'planned'` as the publication gate; `main` has since replaced
  that with the copy-slot `draft` resolution in `app/draft.php`, which is
  strictly stronger (a page cannot be published half-written even by
  accident). The rule was rewritten to describe the mechanism that actually
  runs. Worth knowing that the manifest was, on this point, describing an
  older codebase.
- *Two branches diverging silently is the real defect here*, not either
  branch. Both were produced by build sessions that could not see each other.
  The cheap prevention is the one already decided: one trunk, every session
  based on it, every session appending to this log.

**Worth the owner's attention.** `docs/COPY-BRIEF.md` on `main` carries 811
briefs — that is the actual remaining shape of this project, and it is a
writing job, not an engineering one. Batch 0 makes that writing cheaper and
safer to land; it does not shorten it.

---

## 2026-08-19 — PR-01 · the validation gate

**Shipped.** `tools/validate.php` runs four gates and exits non-zero on the
first failure (`--all` to see every one): tracked-file `php -l`,
`tools/qa.php`, `tools/build-release.php`, and a sitemap-freshness check that
regenerates `sitemap.xml`, compares it to the committed file and always puts
the committed file back — the gate reports, it never edits the working tree.
`.githooks/pre-push` runs it; `tools/install-hooks.php` points
`core.hooksPath` at the versioned hooks directory. `docs/VALIDATION.md`
explains all of it, including the bypass and its cost.

Each gate was verified by seeding a fault and watching it fail, then removing
the seed: a broken tracked PHP file (syntax), a duplicated registry title
(qa, and release with it, since the release builder re-runs QA before
packaging), and a truncated `sitemap.xml` (sitemap). The hook was verified by
attempting a real push with a seeded fault and watching it refuse.

**The decision behind it.** The card originally specified
`.github/workflows/ci.yml`. Owner decision this session: the repository is
private, so Actions minutes are metered against the account, and the deploy
path never touches a GitHub runner — Hostinger pulls from git and builds on
its own servers. The four gates are the same four commands either way, and
locally they cost nothing. `docs/VALIDATION.md` states what that forfeits
rather than leaving it to be rediscovered: no gate on edits made in the
GitHub web UI, no required status check on a protected branch, and therefore
no true "GitHub refuses to merge until green" — merging is now a person
seeing the gate pass and then merging.

**One small scope addition, deliberately.** `.claude/settings.json` runs
`tools/install-hooks.php` on session start. Git never ships hooks to a clone,
so hooks are per-checkout — and this project is built by automated sessions in
fresh containers that would each start ungated. Without this, the gate would
have been real on a laptop and theatre everywhere the work actually happens.
It is three lines and it is the difference between the PR working and looking
like it works.

**Deliberately skipped.** No `.github/` directory was created, not even a
disabled workflow. No pre-commit hook — the gate runs the release build, which
is too slow to sit in front of every commit, and blocking at push is where it
buys the protection. No lint-staged-style partial validation; the tree is
small enough that whole-tree checks finish in seconds.

**Risks and things noticed.**

- *The gate can be walked around and that is intentional.* `--no-verify`
  exists, and anyone who has not run the installer is ungated. This is the
  accepted cost of the zero-minutes decision, written down in
  `docs/VALIDATION.md` so it is a known trade rather than a discovered hole.
- *`tools/build-release.php` writes a zip into `release/` on every run*, so
  every validation leaves a build artifact behind. `release/` is gitignored so
  nothing reaches the repository, but the directory grows unbounded on a
  long-lived checkout. Not fixed — out of scope for this card, and harmless in
  ephemeral containers. Worth a `--dry-run` flag on the release builder if it
  ever becomes annoying.
- *The sitemap gate is the one most likely to surprise someone.* It fails on a
  perfectly good change if the registry moved and nobody re-ran
  `tools/build-sitemap.php`. That is the point, but the failure message now
  names the exact command to run, because a gate that fails without telling
  you what to type is a gate people learn to bypass.

**Worth the owner's attention.** GitHub's default branch is still
`claude/paraguay-frontier-mvp-e2e4ju`, not `main`. This is now the second log
entry saying so. Every PR in this batch is opened explicitly against `main`,
so the work is unaffected — but a fresh clone still lands on the older line,
and that will eventually bite someone.

---

## 2026-08-19 — PR-02 · production error handling

**Shipped.** `app/errors.php`, required from `bootstrap.php` immediately after
`helpers.php` so it is installed before anything else can fail. On a web
request: `display_errors` off, `log_errors` on, `error_reporting(E_ALL)`, a
`set_exception_handler()` and a `register_shutdown_function()` that catches
the fatal types an exception handler cannot see. Both log one line naming the
kind, message, file, line, method and URI — then render the site's own 500
page with a real 500 status.

Three details that are the actual substance of the file:

- **CLI is excluded.** `tools/qa.php`, `tools/build-release.php` and the rest
  of the validation gate all require `bootstrap.php`. Under CLI, PHP's default
  loud-trace-on-the-terminal behaviour is exactly what the person who broke it
  wants, and an HTML error page written to stdout would corrupt tool output.
- **Recursion is guarded.** If rendering the 500 page itself throws — a broken
  registry, template or config — the handler falls back to a hardcoded,
  dependency-free HTML document. A re-entrancy flag stops a failure inside the
  handler from looping.
- **Output buffers are discarded** before rendering, so a visitor never gets
  half a page glued to an error page. If headers were already sent the status
  code is unrecoverable; the handler says so in a comment and degrades to an
  HTML comment rather than pretending.

**Verified over real HTTP**, not by reasoning. A scratch route was made to
throw an uncaught `RuntimeException` carrying a canary string, and a second to
trigger a fatal (call to undefined function), both served through `php -S`:

- both returned **500**, both rendered the site's own "Something went wrong"
  page, and a normal page still returned 200;
- the canary string, the exception class, the words "Stack trace" and the
  absolute filesystem path were all **absent** from both response bodies;
- all of that detail was present in the error log, which is where it belongs.

The scratch routes were removed.

**Deliberately skipped.** No debug or dev-mode flag. `config/site.php` has no
such key today, adding one is not on this card, and inventing configuration is
how "display_errors was on in production" happens. The consequence is real and
worth stating: **debugging a broken page locally now means reading the error
log rather than the browser.** For `php -S` that log is the terminal, so the
cost is small — but if it becomes annoying, the right fix is one explicit
`'debug' => false` key in the config, defaulting off, never an environment
sniff.

Also skipped: adding `errors` to the `<FilesMatch>` deny list in `.htaccess`.
That file belongs to PR-03 and is edited there.

**Risks and things noticed.**

- *The `<FilesMatch>` deny list in `.htaccess` is already incomplete*, before
  this PR: it names `bootstrap|helpers|page-renderer|seo|schema|form-security`
  but `app/draft.php` and `app/form.php` exist and are not listed. Nothing is
  exposed today, because a rewrite rule blocks `^app/` wholesale — but that is
  precisely the `mod_rewrite` dependency PR-03 exists to remove. Handing PR-03
  a list that is missing three names would have left the hardening half-done,
  so PR-03 will complete the list rather than just append to it.
- *`error_log()` goes wherever the host points it.* On Hostinger that is the
  account's PHP error log; nothing in this repository configures a path, and
  nothing should — a hardcoded path is a permissions failure waiting to
  happen. Worth one line in the live-test checklist: confirm after the first
  deploy that the log is actually reachable, because an error handler whose
  logs nobody can read is only half a handler.
- *`E_CORE_WARNING` and `E_COMPILE_WARNING` are treated as fatal* by the
  shutdown handler. They are in the fatal mask because in practice they end
  the request, but if a host emits one benignly at startup the site would
  render a 500 for it. No such case is known on this stack; noted so the
  symptom is recognisable if it ever appears.

**Worth the owner's attention.** The 500 page is now reachable by real
visitors for the first time, which makes its copy load-bearing rather than
decorative. It currently says the problem is ours and has been logged — which
is true. When the consultation form goes live it should probably also give a
way to reach a human that does not depend on the site working, since a visitor
who hits a 500 mid-enquiry has just lost what they typed.

---

## 2026-08-19 — PR-03 · `.htaccess` hardening

**Shipped.** Three changes to `.htaccess`, all of them about not depending on
`mod_rewrite`:

1. **`config/site.php` and `config/env.php` are denied by name.** `env.php`
   holds the SMTP password and the VenderCRM API key. Until this PR its only
   protection was rewrite rule 4 (`^(app|config|docs|tools)`), which lives
   inside `<IfModule mod_rewrite.c>` — so on a host that had not loaded
   `mod_rewrite`, the whole block would be skipped silently and the
   credentials would be served as plain text. `FilesMatch` needs no module and
   matches by basename, so it holds regardless.
2. **The by-name deny list for `/app` was completed, not merely extended.** It
   read `bootstrap|helpers|page-renderer|seo|schema|form-security` — which
   named a file that does not exist (`form-security.php`, presumably renamed to
   `form.php` at some point) while omitting three that do (`draft.php`,
   `form.php`, and `errors.php` from PR-02). Now all eight `app/*.php` files
   are listed and nothing is listed that is not there, verified by script
   rather than by eye.
3. **HSTS**, `max-age=31536000; includeSubDomains`. The site already
   force-redirects to HTTPS; HSTS closes the gap that redirect leaves, which
   is the very first plaintext request before the redirect can happen.

Verification joins `docs/HOSTINGER-LIVE-TEST-CHECKLIST.md` (section B), and
`tools/smoke-test.php` gained probes for `/config/env.php` and
`/app/errors.php` plus an `Strict-Transport-Security` header check, so the
next deploy tests this automatically rather than relying on someone
remembering.

**Deliberately skipped.** No `preload` on the HSTS header. Preloading is
effectively irreversible — removal takes months and a browser release cycle —
and that is an owner decision, not a build-session one. No CSP tightening;
`'unsafe-inline'` is still in `script-src` and `style-src`, which is a real
weakness but a different card. No change to the `/storage` posture.

**Risks and things noticed.**

- *This cannot be verified locally, at all.* `.htaccess` is only read by Apache
  or LiteSpeed; the local `php -S` server ignores it entirely, and
  `tools/smoke-test.php` knows this — it detects the server banner and downgrades
  its deny-rule checks to "reported only" off real hosting. So the honest status
  of this PR is: **the rules are correct by inspection and by a scripted
  completeness check, and unproven until the first Hostinger deploy.** Nothing
  has ever been uploaded, so section B of the live checklist is still entirely
  unticked.
- *HSTS is the one change here that can take the site down and stay down.*
  Once a browser sees the header it refuses plaintext to that host — and with
  `includeSubDomains`, to every subdomain — for a year. If a subdomain is ever
  added without a valid certificate, it is unreachable for that visitor and no
  server-side change fixes it. The checklist now says so at the point of
  verification, which is the only place a warning is any use.
- *The deny list is a hand-maintained list that must stay in sync with a
  directory listing* — exactly the kind of thing that silently rots. This PR
  proved it had already rotted once. A one-line QA check comparing the
  `FilesMatch` alternation against `app/*.php` would make the rot impossible;
  that belongs in PR-05, and is written down there rather than done here.
- *`/storage` is covered, but by accident rather than design.* The rate-limit
  state files are `rate-<hash>.json`, and the existing `\.(md|csv|json|lock)`
  rule denies them by extension without needing `mod_rewrite`. `app/form.php`
  also writes a `Require all denied` into `storage/` when it creates the
  directory. Two independent protections, neither of which was put there for
  this reason. Fine today; worth knowing it is coincidence if the state format
  ever changes away from `.json`.

**Worth the owner's attention.** The `Content-Security-Policy` still allows
`'unsafe-inline'` for both scripts and styles, which means the CSP would not
stop an injected inline script. That is defensible while the site has no
user-generated content and no third-party JavaScript — but the Batch 1
interactive tools (the document checklist, the cost selector, the
self-assessment) are the first real inline JavaScript this site will carry, and
that is the moment to move them to external files and drop `'unsafe-inline'`.
Worth doing then, while there are three scripts, rather than later.

---

## 2026-08-19 — PR-04 · i18n plumbing (dormant)

**Shipped.** `docs/TRANSLATION-ARCHITECTURE.md` §3–§4, implemented. The site is
still English-only and the rendered HTML is unchanged; what changed is that
adding a second locale is now a content job rather than a renderer job.

- **`app/locale.php`** — the locale layer: `locales()`, `default_locale()`,
  `locale()`, `set_locale()`, `locale_lang()`, `og_locale()` and
  `locale_alternates()`. `set_locale()` refuses a locale the site does not
  serve and falls back to the default, because a route asking for an
  unconfigured locale is a bug and serving the default is the safe reading.
- **`registry()`, `navigation()`, `strings()`, `resolve_page()`, `page()`,
  `page_url()`, `page_title()`, `t()`** all take an optional locale, defaulting
  to the current request's. Static caches are keyed by locale rather than
  single-valued, because the QA harness and the sitemap builder legitimately
  read more than one locale in one process.
- **`render_page($id, $locale = 'en', $httpStatus = 200)`** sets the locale
  once; everything downstream reads `locale()`. `tools/make-routes.php` emits
  the locale explicitly, so a `/es/` route will differ from its English twin by
  exactly one argument. All 32 routes regenerated.
- **Derived, not hardcoded:** `<html lang>`, `og:locale` (the one intentional
  output change — `en` was never a valid Open Graph value, which wants
  `language_TERRITORY`, so it is now `en_US`), and all three `inLanguage`
  sites in `app/schema.php`.
- **Eleven string sites moved into `content/en/global.php`** — the eight the
  audit named, plus three it missed: the breadcrumb "Home" in `seo.php`, the
  "In preparation" badge in the nav panel, and four `aria-label`s (`Primary`,
  `Mobile`, `Breadcrumb`, `Page sections`) which are user-facing to anyone
  using a screen reader and were being treated as if they were not.
- **`navigation.php` footer headings** became labelled entries
  (`['heading' => …, 'pages' => […]]`) instead of array keys. A key cannot be
  translated without changing the structure, and a structure that differs per
  locale is one every template has to special-case.
- **hreflang and the language switcher exist and are dormant.** `head.php`
  derives its alternates from `locale_alternates()`, which returns nothing
  while one locale is configured — so not a single tag is printed today.
  `partials/language-switcher.php` returns early rather than rendering an
  empty element. Both were written to the §5 rules: a switcher links to the
  same page when it is live in the other locale and to that locale's home page
  when it is not (never to an in-preparation notice), and there is no
  `Accept-Language` or IP redirect anywhere — a visitor researching a legal
  process must never be silently moved off the page they chose.

**Verified.** All 32 routes were rendered to disk before and after the change
and compared byte for byte. Every file differs by exactly one line — the
`og:locale` fix — and **zero files differ by anything else**. The dormant
machinery was then exercised directly with a simulated two-locale config:
`locales()`, `og_locale()` for four languages, and `set_locale()` correctly
refusing an unconfigured locale and falling back. Gate green.

**Deliberately skipped.**

- *`href()` was not given a locale parameter*, though §3 item 3 lists it.
  Threading one through would have been dead code: each locale has its own
  registry with its own `url` values, so a Spanish page's URL is already
  `/es/guias/...` by the time it is read. The locale is in the string before
  `href()` ever sees it — that is precisely what makes localised slugs possible
  instead of a translated site living under English paths. `page_url()` and
  `page_title()` did get the parameter, since they read the registry.
  Documented in `page_url()`'s docblock so the deviation is discoverable at the
  code rather than only here.
- *`manifest.webmanifest`* — §4 lists it as a per-locale or generated file. It
  is a static file served directly, not rendered through the app, so localising
  it means either generating it at build time or serving one per locale, and
  both are decisions with a deploy consequence. Not this card.
- *The block templates' hardcoded English* — see below. That is PR-10's card.

**Risks and things noticed.**

- *The Phase 2a block templates carry far more untranslated English than the
  audit found*, because they were written after the audit. `form.php` alone has
  fifteen or so user-facing sentences hardcoded — labels, hints, the privacy
  note, the not-live explanation — and `reviewer.php`, `sources.php` and
  `draft-notice.php` have several each. None of it is a bug today; all of it
  would have to move before a second locale renders correctly. This is exactly
  what PR-10's audit card now exists for, and it is a materially bigger job
  than "check the blocks escape their output".
- *A missing string renders as its own key.* `t()` returns the key when it is
  absent, so an untranslated Spanish page would show `stamp_written_by` rather
  than silently falling back to English. That is the right default — an
  untranslated string must be impossible to miss — but it means a locale file
  with a typo'd key ships a visible token. PR-05 should check that every
  locale's `global.php` has the same key set as the default locale's.
- *`og_locale()` maps a language to a territory* (`en` → `en_US`,
  `es` → `es_ES`). Those territories are Open Graph convention, not a claim
  about audience — worth knowing before someone reads `es_ES` as a decision to
  target Spain rather than Paraguay. No consumer of `og:locale` treats the
  territory as targeting; if that ever changes, the map is one place.

**Worth the owner's attention.** The plumbing is done, which means the cost of
a second locale is now entirely the cost of translation and review — no
template work, no URL migration, and hreflang that cannot fall out of sync
because it is derived rather than maintained. That was the whole point of doing
it at three written pages instead of at a hundred and thirty. The decision it
does *not* make for you is which language, or whether to spend on one at all;
BUILD-PLAN Phase 6 still holds that as open, and nothing else depends on it.

---

## 2026-08-19 — PR-05 · QA harness extensions

**Shipped.** Seven checks, each proved against a seeded fault and the seed then
removed.

The card's five:

- **(a) A `status => 'live'` registry entry must have a content file with
  blocks in it.** `resolve_page()` quietly downgrades a missing file to
  `planned` and the site renders the in-preparation notice — correct at
  runtime, exactly wrong at build time, where it hides the fact that a page the
  registry advertises as finished does not exist. Now a hard failure with its
  own message, distinct from the existing status-mismatch check.
- **(b) Unknown block types on every page** and **(c) block `page => id`
  references** were already covered on `main` — the harness had moved ahead of
  the card. Verified rather than rewritten.
- **(c, second half) Every `navigation.php` id resolves.** New, and the most
  valuable of the seven: see below.
- **(d) Every registry entry reachable from navigation or a block**, as a
  warning. Home, the two error pages and `/thank-you/` are exempt — they are
  reached by the server or by a redirect, not by a link.
- **(e) `checkdate()` on `last_reviewed`**, plus a future-date check.
  `2026-02-30` passes a regex and is not a day; a date in the future claims a
  review that has not happened. Both now fail.

Two more, promised in earlier entries of this log rather than invented here:

- **The `.htaccess` deny list is checked against `app/*.php`** (promised in
  PR-03's entry). It fails if a file on disk is not denied by name, warns if
  the list names a file that no longer exists, and fails if the `site|env`
  config rule has gone missing.
- **Locale string-key parity** (promised in PR-04's entry): every configured
  locale must define the same keys as the default, and its content directory
  must exist. Trivially satisfied with one locale — the point is that it stops
  being trivial the moment a second is added.

**Two real defects found while writing this, both fixed here.**

1. *The deny-list check failed on its first run.* PR-04 added `app/locale.php`
   and did not add it to `.htaccess` — the exact rot PR-03's entry predicted,
   reproduced inside a single batch, by the same session that wrote the
   warning. That is the argument for the check, made better than any reasoning
   could: a hand-maintained list that must track a directory needs a machine
   watching it. `.htaccess` is fixed in this PR.
2. *A one-character typo in `navigation.php` takes the entire site down.*
   Seeding `'page' => 'abuot'` made `page()` return null, `$cp['url']` null,
   and `href(null)` a `TypeError` — fatal, on **every** page, since the header
   renders everywhere. It also meant QA itself died mid-render and never
   reached the check that would have named the cause. So the structural checks
   were moved to run **before** the render loop: QA now prints
   `navigation.php references unknown page id 'abuot'` instead of dumping half
   a page of HTML and a stack trace. With PR-01's gate in front of the push and
   PR-02's handler in front of the visitor, this class of typo can no longer
   reach production — but it can still ruin an afternoon locally.

**Deliberately skipped.** `app/templates/partials/header.php` was **not** made
defensive against a null page. It is the template that turns the typo into a
site-wide fatal, and a two-line guard would fix it — but templates are PR-10's
card, this PR is the harness, and the harness now makes the fault unshippable.
Written down here so it is a decision rather than an oversight: **PR-10 should
add the guard.**

**Risks and things noticed.**

- *The reachability check is a warning and should stay one.* A page can
  legitimately be linked only from prose inside a block, and the walker only
  understands structured `page => id` references. Making it a failure would
  train people to add fake navigation entries to silence it, which is worse
  than an orphan.
- *The deny-list check parses `.htaccess` with a regex.* If someone reformats
  that `FilesMatch` line — splits it, changes the quoting — the check fails
  with "no by-name PHP deny list" rather than silently passing. That is the
  right failure direction, but the message should be read as "the check cannot
  find the rule", not necessarily "the rule is gone".
- *QA now reads `config/site.example.php`'s locale list*, so a locale added to
  the example config without a content directory fails the build. That is
  intended — the example config is what a fresh checkout and the release zip
  both fall back to — but it means the example config is now load-bearing, not
  decorative.

**Worth the owner's attention.** The harness went from 11 sections to 15 and
still runs in about a second, because every check is static analysis over the
registry rather than a browser. That ratio is why the gate is worth having: it
is cheap enough that nobody is tempted to skip it. The thing it still cannot
check is whether a sentence is *true* — which remains the only quality gate on
this project that a person has to perform.

---

## 2026-08-19 — PR-06 · raw-HTML discipline

**Shipped.** `raw_html()` in `app/helpers.php` is now the site's entire
raw-HTML trust boundary, every raw-echoed content key carries an `_html`
suffix, and two QA checks make both permanent.

The invariant, stated as the test that proves it:

```
grep -rn '<?=' app/templates | grep -vE '<\?=\s*(e\(|raw_html\()'
```

comes back **empty**. Every short echo in all 33 templates is either `e()` —
escaped text — or `raw_html()` — trusted markup from an `_html` key. The point
is not that a bare echo is always wrong; it is that a bare echo is
*invisible*, so nobody can review what they cannot find.

**The card was written before the templates it names existed, so this was
bigger than it looks.** It lists five raw-echo templates (`hero`, `statement`,
`prose`, `faq`, `callout`). Phase 2a landed on `main` afterwards and added
eight more that echo content raw — `checklist`, `comparison`, `definition`,
`next-step`, `quick-answer`, `sources`, `steps`, `form` — plus computed echoes
in another six. Doing only the five named would have left the acceptance test
failing, so all thirteen were done. Same reasoning as PR-10 becoming an audit:
the card describes an older codebase, the invariant is the real deliverable.

**Renamed keys** (~500 occurrences across 31 content files), scoped per block
type rather than globally, because the same key name means different things in
different blocks — `page-header`'s `intro` is escaped while `checklist`'s is
raw, and `related`'s item `note` is escaped while `sources`' is raw. A global
find-and-replace would have been wrong in both directions.

**How the rename was made safe.** Templates read **only** the `_html` key, with
no fallback to the old name. That turns any missed rename into an empty
element, which the byte-identity test catches immediately — and it did: it
found `app/schema.php` reading `$faq['a']` to build FAQPage structured data,
a site outside the templates entirely that a template-only audit would have
missed. All 32 routes now render **byte for byte identical** to before.

**Two QA checks**, both proved against a seeded fault: every template echo goes
through `e()` or `raw_html()`, and every content key `raw_html()` reads ends in
`_html`.

**Things the new checks found that the grep did not.** Three echoes the
acceptance grep missed because they sit mid-line or inside a multi-line
expression: a `selected` attribute in the form's stage select, a
`data-reveal` index in `pathways`, and the reviewer block's inline `<time>`
element. A grep over source text finds what it is shaped to find; the check
parses every `<?=` on every line, which is why it is the thing that stays.

**Deliberately skipped.** The hardcoded English still sitting in `sources.php`,
`reviewer.php`, `form.php` and `draft-notice.php` — that is PR-10's card, and
PR-04's entry already flagged it. The `header.php` null-page guard from PR-05's
entry — also PR-10.

**Risks and things noticed.**

- *`docs/COPY-BRIEF.md` was stale before this PR touched it.* Regenerating it
  after the rename changed the count from 811 passages to **796**: fifteen of
  those had already been written (`/book-consultation/`) and the committed
  brief had never been regenerated. Nobody was misled yet, but the writer's
  worklist was quietly describing a codebase that had moved. It is generated
  from the content files by `php tools/copy-brief.php`, exactly like
  `sitemap.xml` is generated from the registry — and `sitemap.xml` has a
  validation gate while this does not. **Adding a fifth gate for it is the
  single cheapest improvement available right now**, and it is deliberately not
  done here because the gate belongs to PR-01's card, not this one.
- *The `_html` rename shifts every path label in `COPY-BRIEF.md`.* Chat 2 is
  writing against that file. The brief *text* is unchanged and the writing task
  is unchanged — only the path labels move (`blocks.4(steps).items.0.body`
  becomes `…body_html`). A writer mid-file should regenerate rather than
  reconcile by hand.
- *`raw_html()` cannot enforce its own contract*, and should not pretend to. It
  rejects arrays and nulls, which are template bugs, but a string containing a
  `<script>` tag passes through — that is what "trusted" means. The enforcement
  is social and structural: the value comes from a content file written by
  someone with commit access, and the `_html` suffix makes that visible at the
  data. Nothing in this codebase renders visitor input as HTML. **Nothing
  should start**, and the day something does, this helper is the first place to
  re-read.
- *One echo carries an inline comment* (`related.php`) to explain why a
  ternary of `e()` calls is trusted by construction. The QA check accepts
  `<?= /* … */` as a third form. That is a small hole — a comment could in
  principle precede anything — but a bare echo hidden behind a comment is a
  deliberate act, not an accident, and the check exists to catch accidents.

**Worth the owner's attention.** With this merged, the answer to "could this
site have an XSS hole" is checkable rather than arguable: there are exactly
two functions that put a value into HTML, one escapes and one does not, and QA
fails the build if a third way appears. That is worth more than it sounds on a
site whose whole positioning is that it can be trusted with careful reading.
