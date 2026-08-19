# The validation gate

Four checks stand between a change and the remote. They run on this machine,
before the push, and a failure stops the push.

```
php tools/validate.php          run every gate, stop at the first failure
php tools/validate.php --all    run every gate, report all failures
```

| Gate | What it proves |
|---|---|
| `syntax` | Every PHP file git tracks parses under the local PHP. |
| `qa` | `tools/qa.php` finds no failures: metadata uniqueness and length, registry integrity, rendered output, draft integrity, block coverage, the enquiry form, no secrets in client assets, correct indexing posture. |
| `release` | `tools/build-release.php` can still produce the zip that gets uploaded — a different question from "the source parses". |
| `sitemap` | The committed `sitemap.xml` is what the generator produces from the current registry. This gate never edits the working tree; it regenerates, compares, and puts the committed file back. |

## Installing the hook

```
php tools/install-hooks.php
```

That sets `core.hooksPath` to the versioned `.githooks/` directory, so
`.githooks/pre-push` runs `tools/validate.php` on every push. It is
idempotent, and it must be run **once per checkout** — git deliberately never
ships executable hooks to anyone who clones, so a fresh clone or a fresh
build container starts with no hooks at all.

Because hooks are per-checkout, `.claude/settings.json` runs the installer on
session start, so an automated session in a fresh container is gated too
rather than silently ungated.

Undo with `git config --unset core.hooksPath`.

## Bypassing it

```
git push --no-verify
```

This skips the gate entirely. What that forfeits is the whole of the table
above — most consequentially, an unbuildable release or a stale sitemap can
reach the default branch, where the next person's first symptom is a failing
build they did not cause. Use it when the gate itself is broken (no PHP on
PATH, for instance), and fix the gate in the next commit.

## Why this is not a GitHub Actions workflow

The original plan (`docs/PR-BATCHES.md`, PR-01) specified
`.github/workflows/ci.yml`. Owner decision, 2026-08-19: it runs locally
instead.

- The repository is **private**, where GitHub Actions minutes are metered and
  billed against the account. Every push on every branch would spend them.
- Nothing in the deploy path uses a GitHub runner. Hostinger pulls from git
  and builds on its own servers; GitHub holds the code and fires a webhook.
  A workflow would therefore buy no deployment capability at all.
- The four gates are the same four commands either way. Run locally against a
  warm checkout they take seconds and cost nothing.

**What this forfeits**, stated so nobody rediscovers it as a surprise:

1. A hook binds pushes made from a checkout. A file edited directly in the
   GitHub web UI is committed server-side and never passes through it.
2. A hook cannot be a **required status check** on a protected branch, so
   branch protection cannot enforce it and GitHub's auto-merge has no check
   to wait for. "Merge when green" means "the person merging saw the gate
   pass", not "GitHub refused to merge until it did".
3. A contributor who has not run `tools/install-hooks.php` is ungated.

With a single committer, none of the three is a live risk. If this repository
gains collaborators, reopen the decision — and if a workflow is added then,
make it `on: pull_request` only, `ubuntu-latest`, with `timeout-minutes`, so
the cost stays bounded.
