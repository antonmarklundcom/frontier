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
