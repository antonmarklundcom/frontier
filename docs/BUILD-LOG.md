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
