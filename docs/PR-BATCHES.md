# PR batches — the executable build manifest

Written 2026-08-19 for BUILD-PLAN §4. This file is the work order for a build
session running unattended in its own chat: pick the next unblocked PR, build
it, validate locally, open the PR, enable auto-merge, move on once CI is
green. One batch is sized to finish in one session. Owner decisions
2026-08-19: auto-merge-when-green is the standing policy; Chat 1 runs
PR-01…06 + PR-10, Chat 2 runs PR-11…16 (see BUILD-PLAN §4); the site is
English-only for now, so PR-04 ships the locale plumbing dormant.

## Standing rules for every build session

1. **Validate before pushing.** `find . -name '*.php' -not -path './release/*'
   -exec php -l {} \;` then `php tools/qa.php` then, when the release surface
   changed, `php tools/build-release.php`. All clean, locally, before the PR.
2. **The truthfulness rules outrank everything in this file.** No invented
   number, price, time, statistic or testimonial, anywhere, in any locale.
   If a PR seems to need one, the PR is wrong — stop and log it.
3. **Never publish a guide.** Guides are written as `status => 'planned'` and
   stay there; only the owner flips a page live after its named reviewer signs
   off. CI green is a code gate, not a content-review gate.
4. **Scope discipline.** A PR does what its card says. Improvements discovered
   along the way go to `docs/BUILD-LOG.md`, not into the diff.
5. **After every PR**, append to `docs/BUILD-LOG.md`: what shipped, what was
   deliberately skipped, risks or bugs noticed (fixed or not), and ideas worth
   the owner's attention. This is the owner's AFK feedback channel — write it
   for a human catching up, not as a changelog.
6. Branch naming `pr/<nn>-<slug>`; commits explain *why*; no model names in
   any pushed artifact.

## Batch 0 — foundations (BUILD-PLAN Phase 1.5)

Order matters only where "needs" says so. PR-01 first, always.

**PR-01 · CI workflow** — `.github/workflows/ci.yml`: PHP 8.4
(`shivammathur/setup-php`), `php -l` over every tracked PHP file,
`php tools/qa.php`, `php tools/build-release.php`, plus a check that
`php tools/build-sitemap.php` produces no diff against the committed
`sitemap.xml`. Accept: workflow runs on push + PR; each of the four gates
demonstrably fails the build when broken (verify by reasoning, not by pushing
red commits). *After merge, owner action: require the CI check on the default
branch and enable auto-merge — that is what makes "merge when green" real.*

**PR-02 · Production error handling** — `app/bootstrap.php`:
`ini_set('display_errors','0')`, `set_exception_handler` +
`register_shutdown_function` rendering the 500 page (with correct status code)
instead of a stack trace; log to `error_log`. Accept: a deliberately thrown
exception in a scratch test renders the 500 page with nothing leaked; QA still
0 failures. Needs: nothing.

**PR-03 · .htaccess hardening** — add literal `site.php` and `env.php` to the
`<FilesMatch>` deny block (so `config/env.php` credentials never depend on
`mod_rewrite` being loaded); add
`Strict-Transport-Security "max-age=31536000; includeSubDomains"` beside the
existing security headers. Accept: with rewrites conceptually off, the config
files are still denied by `FilesMatch`; note in BUILD-LOG that live-host
verification joins `docs/HOSTINGER-LIVE-TEST-CHECKLIST.md`. Needs: nothing.

**PR-04 · i18n plumbing** — implement `docs/TRANSLATION-ARCHITECTURE.md` §3–§4
exactly: locale-parameterized `registry()`/`navigation()`/`strings()`/content
resolution, locale threaded through `page_url()`/`href()`, `<html lang>` /
`og:locale` (fix to `en_US` format) / `schema.php` `inLanguage` derived, the
eight stray-string sites moved into `content/en/global.php`, switcher +
hreflang code paths present but dormant while `locales` is `['en']`. Accept:
rendered HTML for all 32 routes is byte-identical except the `og:locale` fix;
QA 0 failures. Needs: nothing, but merge before Batch 1 (guides multiply
strings).

**PR-05 · QA harness extensions** — `tools/qa.php`: (a) every
`status=>'live'` entry has a non-empty content file — hard fail, distinct from
the runtime "in preparation" fallback; (b) unknown-block-type check on every
page, not just home; (c) every block `'page' => id` reference and every
`navigation.php` id resolves in the registry; (d) every registry entry
reachable from navigation or at least one block (warning, not failure);
(e) `checkdate()` guard on `last_reviewed`. Accept: each new check
demonstrated to catch a seeded fault, then the seed removed; 0 failures on the
real site. Needs: PR-01 merged (so the checks gate PRs immediately).

**PR-06 · Raw-HTML discipline** — one `raw_html()` helper in
`app/helpers.php`; the five raw-echo block templates (`hero`, `statement`,
`prose`, `faq`, `callout`) route through it; every raw-echoed content key
renamed with an `_html` suffix and content files updated. Accept: rendered
HTML byte-identical; `grep` for bare `<?=` outside `e()`/`raw_html()` comes
back empty; QA green. Needs: nothing (rebase cost only, keep it last in the
batch).

## Batch 1 — content system + Tier 1 guides (BUILD-PLAN Phase 2)

**PR-10 · Guide blocks** — new block templates `quick-answer`, `definition`,
`checklist`, `comparison`, `steps`, `sources`, `reviewer` (+ extend `faq`/
`related` if the guides need it), with the same escaping and `t()` discipline
as existing blocks. Accept: QA block-coverage passes; a scratch page
exercising every new block renders correctly at 390/1440 px. Needs: Batch 0
merged (PR-05's checks, PR-04's string discipline).

**PR-11…14 · The four Tier 1 guides** — one PR each, independent of each
other: `/guides/residency/documents/` (with the interactive checklist tool),
`/guides/tax/tax-vs-legal-residency/`, `/guides/residency/costs/` (with the
cost-category selector), `/guides/residency/timeline/`. Written against
primary sources only (Migraciones, DNIT, BCP, MRE, Identificaciones, the
official legal database); every claim sourced in the `sources` block; tools
are vanilla JS + localStorage and degrade to complete static content without
JS; pages stay `planned`. Accept: QA green; no-JS render complete; no
invented number anywhere. Needs: PR-10.

**PR-15 · Route self-assessment** — the 4–5-question "where am I in the
route?" widget on `/guides/residency/`, routing to the right guide/service.
Same no-JS and no-invented-numbers rules. Needs: PR-10.

**PR-16 · Checklist email capture → VenderCRM** — owner decision 2026-08-19:
the document checklist doubles as a lead magnet. Optional email field on the
checklist tool ("send me this checklist and corrections when rules change"),
posting to a server-side PHP handler that forwards to the VenderCRM leads
endpoint — API key in `config/env.php` only, never client-side; honeypot,
minimum-completion-time and rate limiting like the consultation form; the
checklist itself works fully without entering an email, and the copy promises
only what will actually be sent. Placeholder-suppression applies: with no CRM
key configured, the email field is omitted, not broken. Accept: handler
locally testable; no claim of delivery until a real submission lands in
VenderCRM (owner verifies). Needs: PR-11 (the checklist page) and the CRM
key; share the handler's security plumbing with PR-20 if PR-20 lands first.

## Batch 2 — commercial pages + form (BUILD-PLAN Phase 3)

**Blocked on owner data** (`docs/PRODUCTION-DATA-REQUIRED.md`): prices,
inclusions, calendar URL, consultation fee, refund policy, SMTP. Only PR-20
can be built ahead of it.

**PR-20 · Consultation form handler** — browser → own PHP handler →
VenderCRM, CRM key server-side only (`config/env.php`), CSRF, honeypot,
minimum-completion-time, rate limiting, POST-redirect-GET to `/thank-you/`
(which sets expectations: what happens next, in what timeframe). Buildable
against `env.example.php` placeholders — the placeholder-suppression pattern
already governs unconfigured state. Accept: handler unit-testable locally;
the site claims nothing about the form working until a real message has been
received (that claim is the owner's to make, per the deployment doc).

**PR-21 · Services + process + packages + book-consultation + about** — only
once the data exists; `/packages/` is never written with placeholder numbers.

## Later batches (sketch, cards written when reached)

- **Batch 3** = Phase 4: hubs, `/faq/`, `/privacy/`, `/terms/`, release +
  live-test support.
- **Batch 4** = Phase 6: second-locale content, after the owner's language
  decision and a signed translation/review arrangement.
- **Phase 7 portal is a separate repo and a separate plan** — never a batch
  here.
