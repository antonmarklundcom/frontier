# PR batches — the executable build manifest

Written 2026-08-19 for BUILD-PLAN §4. This file is the work order for a build
session running unattended in its own chat: pick the next unblocked PR, build
it, validate locally, open the PR, merge it once the gate is green, move on.
One batch is sized to finish in one session. Owner decisions
2026-08-19: merge-when-the-gate-is-green is the standing policy; Chat 1 runs
PR-01…06 + PR-10, Chat 2 runs PR-11…16 (see BUILD-PLAN §4); the site is
English-only for now, so PR-04 ships the locale plumbing dormant.

Reconciled with `main` on 2026-08-19, which had moved ahead of this file on a
parallel branch. Two cards changed as a result and say so in place: PR-01
(the gate runs locally, not on a GitHub runner) and PR-10 (its block templates
already shipped with Phase 2a, so the card is now an audit). `main` is the
trunk; every PR here is opened against it.

## Standing rules for every build session

1. **Validate before pushing.** `php -l` over every tracked PHP file, then
   `php tools/qa.php`, `php tools/build-release.php`, and a check that
   `tools/build-sitemap.php` produces no diff against the committed
   `sitemap.xml`. All clean, locally, before the PR. From PR-01 onward
   `tools/validate.php` runs all four and the `pre-push` hook enforces them,
   so "I forgot" stops being a failure mode.
2. **The truthfulness rules outrank everything in this file.** No invented
   number, price, time, statistic or testimonial, anywhere, in any locale.
   If a PR seems to need one, the PR is wrong — stop and log it.
3. **Never publish a guide.** A guide reaches the public only after its named
   reviewer signs off — that is the owner's call, never a build session's. In
   the code this is enforced twice over: a page with any unwritten copy slot
   resolves to `draft` and renders the in-preparation notice (`app/draft.php`),
   and the whole site is `noindex` while `'launched' => false`. A green
   validation gate is a code gate, not a content-review gate; nothing a build
   session does may narrow the distance between "written" and "published".
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

**PR-01 · The validation gate** — `tools/validate.php` runs the four checks of
standing rule 1 and exits non-zero on the first failure; `tools/install-hooks.php`
installs a `pre-push` hook that runs it, so a broken push never leaves the
machine; `docs/` explains both, including how to bypass in an emergency
(`git push --no-verify`) and what that forfeits.

*Changed from the original card, owner decision 2026-08-19.* This card
originally specified `.github/workflows/ci.yml`. The repository is private,
where GitHub Actions bills per minute against the account, and nothing in the
deploy path uses a GitHub runner — Hostinger pulls from git directly. A
workflow would therefore spend metered minutes to re-run checks that already
run locally in seconds against a warm checkout. The gate moves to a
`pre-push` hook and no file is created under `.github/`.

What this forfeits, stated so nobody rediscovers it as a surprise: a hook
binds pushes made from a checkout, not commits authored in the GitHub web UI,
and it cannot be a *required status check* on a protected branch. With a
single committer neither matters. If the repository gains collaborators,
reopen this card — and if a workflow is added then, `on: pull_request` only,
`ubuntu-latest`, `timeout-minutes: 5`.

Accept: `php tools/validate.php` passes on a clean tree; each of the four
gates demonstrably fails it when broken (verified by seeding a fault and
removing it, never by pushing a red commit); the installed hook blocks a push
carrying a seeded fault. Needs: nothing.

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
real site. Needs: PR-01 merged (so the checks join the gate immediately).

**PR-06 · Raw-HTML discipline** — one `raw_html()` helper in
`app/helpers.php`; the five raw-echo block templates (`hero`, `statement`,
`prose`, `faq`, `callout`) route through it; every raw-echoed content key
renamed with an `_html` suffix and content files updated. Accept: rendered
HTML byte-identical; `grep` for bare `<?=` outside `e()`/`raw_html()` comes
back empty; QA green. Needs: nothing (rebase cost only, keep it last in the
batch).

## Batch 1 — content system + Tier 1 guides (BUILD-PLAN Phase 2)

**PR-10 · Guide blocks — now an audit.** *Changed 2026-08-19:* the block
templates this card was written to create (`quick-answer`, `definition`,
`checklist`, `comparison`, `steps`, `sources`, `reviewer`, plus `next-step`
and `form`) all shipped on `main` as part of Phase 2a, before this manifest
was reconciled with it. Re-creating them would be duplicate work.

The card therefore becomes: audit the shipped blocks against the discipline
this batch establishes — every dynamic value escaped, every fixed label
through `t()` rather than hardcoded English, every raw-HTML echo through
`raw_html()` with an `_html` key (PR-06), every `page => id` reference
resolvable (PR-05) — and fix what falls short. Accept: QA green including the
new PR-05 checks; a scratch page exercising every block renders correctly at
390/1440 px; no block emits an unescaped dynamic value or a hardcoded
user-facing string. Needs: Batch 0 merged.

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
