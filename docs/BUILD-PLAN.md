# Paraguay Frontier — build and traffic plan

Where the project is, what comes next, and the commercial reasoning behind the
sequence. Written after the home page shipped, 2026-08-17.
Revised 2026-08-19 after a full repo audit: added Phase 1.5 (foundations),
the interactive tools in Phase 2, the second-locale decision in Phase 6,
Phase 7 (client portal, deferred), and the PR execution model in
`docs/PR-BATCHES.md`.

---

## 1. The positioning bet

Paraguay residency is a crowded, low-trust category. Almost every competitor
runs the same play: big statistics, guaranteed outcomes, tax-freedom language,
invented testimonials. That play converts impulsive buyers and repels the exact
audience worth having — people with real assets, real families and real
home-country tax exposure, who are researching for months and can smell a sales
funnel.

**The bet: be the site that tells you what can go wrong.**

Concretely, this is what the home page already does and what every page must
keep doing:

- State the scope boundary *before* the pitch — the "what we will not claim"
  list is above the fold of the second screen.
- Publish a policy where a competitor publishes a number. "We do not publish an
  estimate for government review, because any number we published would be a
  guess dressed up as a commitment" is more persuasive to this audience than
  any processing-time claim, and it is also true.
- Name the four stages that are ours and the two that are not.
- Say out loud that several guides will tell you that you do not need us.

That positioning is not just ethics. It is the only durable moat in a category
where anyone can copy a price list, and it is what makes the guides worth
linking to — which is where the traffic comes from.

---

## 2. Where the traffic actually comes from

Ranked by expected value per unit of effort, not by search volume.

### Tier 1 — the "expensive question" pages (build first)

People do not search "Paraguay residency" and buy. They search a specific fear.
These four pages capture the highest-intent fears in the category and each one
naturally ends in a consultation:

1. `/guides/residency/documents/` — apostilles, sworn translation, validity
   windows, and the order to obtain records in. This is the single most useful
   page that does not exist well anywhere, and it is the page people bookmark
   and send to their spouse.
2. `/guides/tax/tax-vs-legal-residency/` — the distinction the whole category
   blurs. High search volume, high confusion, and the page that most cleanly
   demonstrates that you know what you are talking about.
3. `/guides/residency/costs/` — separated into our fee, government fees,
   translation, travel and ongoing costs. Competitors publish one number;
   publishing the *categories* is more useful and more honest.
4. `/guides/residency/timeline/` — realistic sequencing and the specific causes
   of delay. Owns the "how long does it take" query without promising a number.

### Tier 2 — the decision hubs

`/guides/residency/`, `/guides/tax/`, `/guides/banking/`,
`/guides/citizenship/`, `/guides/living/`. These rank slowly and mainly exist to
consolidate topical authority and to funnel internal link equity to Tier 1.
Build them after Tier 1, not before — a hub with nothing under it is thin.

### Tier 3 — commercial pages

`/services/*`, `/packages/`, `/process/`, `/book-consultation/`, `/about/`.
These convert traffic; they rarely earn it. `/packages/` is blocked on real
prices and should not be published with placeholder numbers.

### Tier 4 — the long tail (phase two, ~100 additional pages)

Residency by nationality, apostille guides per country, cédula, denials and
common mistakes, digital nomads, families, retirees, investors and SUACE, VAT,
dividends, crypto reporting, source-of-funds preparation, cost of living, cities
and neighbourhoods, healthcare, schools, company formation, real estate.

Score each by: search relevance × commercial relevance ÷ (legal-review burden ×
maintenance burden). "Residency for [nationality]" scores highest — high intent,
low legal-review burden per page, and it scales.

### Non-search traffic worth more than it looks

- **The document checklist as a lead magnet.** A genuinely good, dated,
  downloadable preparation checklist is the most linkable asset in this
  category and the most natural email capture. Label it a draft until reviewed.
- **Answering in public.** The expat and nomad forums where these questions get
  asked badly are a better early channel than any link-building campaign, if the
  answers are real answers with the site as a footnote rather than the point.
- **The integrity page as a comparison tool.** People shopping three providers
  will read it. Make it the page you would want a sceptical lawyer to read.

---

## 3. Phases

### Phase 1 — done

Design system, PHP architecture, 32 routes resolving, home page written and
verified, QA harness, sitemap generator, palette registered.

### Phase 1.5 — Foundations (next, before any more content)

Small, independent hardening PRs that make every later phase cheaper and make
"merge when green" mean something. Found by the 2026-08-19 audit; full PR
breakdown in `docs/PR-BATCHES.md` (Batch 0).

1. **CI** — GitHub Actions running `php -l` over every file, `php tools/qa.php`
   and `php tools/build-release.php` on every push and PR. All three already
   exit non-zero on failure; CI is a ~30-line YAML away. Everything else in
   this plan assumes it exists. After it lands, protect the default branch so
   the CI check is required — that is what makes auto-merge safe.
2. **Production error handling** — `ini_set('display_errors','0')`, a
   `set_exception_handler()` and shutdown handler in `app/bootstrap.php`
   routing fatals to the 500 page instead of a stack trace.
3. **`.htaccess` hardening** — add `site.php`/`env.php` literally to the
   `<FilesMatch>` deny list so credential protection does not depend on
   `mod_rewrite`; add HSTS (site already force-redirects to HTTPS).
4. **QA harness extensions** — every `status => 'live'` registry entry must
   have a non-empty content file (build-time failure, not the silent
   "in preparation" downgrade); block-type validation on every page, not just
   home; every block `page => id` reference and every `navigation.php` id must
   resolve; every registry entry must be reachable from navigation or a block.
5. **i18n plumbing** (content still English-only) — parameterize `registry()`,
   `navigation()`, `strings()` and content-file resolution by locale; move the
   ~10 hardcoded template/helper strings (including the WhatsApp greeting in
   `helpers.php` and the "Written by"/"Reviewed by" labels) into
   `content/<locale>/global.php`; derive `inLanguage`, `og:locale` and
   `<html lang>` from the locale; hreflang emits automatically once a second
   locale has live pages. Spec: `docs/TRANSLATION-ARCHITECTURE.md`. Doing this
   while three pages exist is cheap; retrofitting under 130 pages is not.
6. **Raw-HTML discipline** — one `raw_html()` helper and an `_html` key-name
   convention for the five block templates that echo trusted markup, so the
   trust boundary is grep-able before the content set and author count grow.

### Phase 2 — Tier 1 guides

Build the `quick-answer`, `definition`, `checklist`, `comparison`, `steps`,
`sources`, `reviewer`, `faq` and `related` blocks, then write the four Tier 1
guides against primary sources (Migraciones, DNIT, Banco Central, MRE,
Identificaciones, the official legal database).

Each guide is written, then **held** for the legal or tax reviewer named in
`docs/PRODUCTION-DATA-REQUIRED.md`. Unreviewed guides stay `planned` and stay
out of the sitemap. This is enforced by the code, not by discipline.

**Interactive tools inside the Tier 1 pages** — each one deepens the page it
lives on rather than adding a route, works with vanilla JS + `localStorage`,
degrades to plain content without JavaScript, and never invents a number:

- The **document checklist as a tool**, on `/guides/residency/documents/`:
  check items off, filter by nationality and civil status, print. This is the
  lead-magnet idea from §2 upgraded from a PDF to the most linkable asset in
  the category.
- A **cost-category selector** on `/guides/residency/costs/`: which cost
  categories apply to your situation — never an amount.
- A **"where am I in the route?" self-assessment** (4–5 questions) routing the
  visitor to the right guide or service; doubles as qualification before the
  consultation form.

### Phase 3 — commercial pages and the consultation form

Requires real prices, real inclusions, a real calendar URL and a refund policy
drafted by a lawyer. The form is
browser → own PHP handler → VenderCRM, with the CRM key server-side only, plus
CSRF, honeypot, minimum-completion-time, rate limiting and POST-redirect-GET.
The site cannot claim the form works until a real message has been received.

### Phase 4 — hubs, trust pages, legal pages, Hostinger deployment

`/integrity/`, `/editorial-standards/`, `/privacy/`, `/terms/`, `/faq/`, plus the
Hostinger release zip and live verification.

### Phase 5 — launch

Clear `docs/PRODUCTION-DATA-REQUIRED.md`, set `'launched' => true`, replace
`robots.txt`, regenerate the sitemap, verify by DNS TXT in Search Console,
submit. Not before.

### Phase 6 — second locale (`/es/`, and possibly `/de/` first)

The plumbing ships in Phase 1.5; this phase is content only. Every locale must
be professionally localised, with its own review dates and its own reviewer —
a machine-translated legal page is a liability, not a growth channel.

**Open decision (owner): which language earns the first translation budget.**
The commercial case for **German** is strong — DACH emigrants are one of the
largest and most sceptical, research-heavy segments in this category, and the
German-language competition is mostly the hype-funnel type this site is built
to beat. **Spanish** buys local credibility and reads well to Paraguayan
partners and reviewers. The architecture cost is identical either way; only
the translation order is being decided.

### Phase 7 — client portal (separate app; gated on real clients, not a date)

**Deliberately not part of this site.** The marketing site stays static —
no login, no database, no accounts; that is why it deploys as a zip, has
near-zero attack surface, and loads in 200 ms. Until portal day, VenderCRM is
the admin surface: leads, pipeline, follow-up.

When there are roughly 5–10 active clients and "where is my file?" is a daily
question, build a **separate app** (Next.js + MySQL + Drizzle on the existing
Hostinger stack, e.g. `portal.paraguayfrontier.com`) with these roles:

| Role | Purpose |
|---|---|
| Client | Case stage on the same six-stage route the site already draws; document checklist with upload; what is blocking and whose move it is |
| Employee / case manager | Update stages, request documents, manage assigned clients |
| Reviewer (lawyer / accountant) | Sign off documents and content — the review gate made visible as workflow |
| Admin (owner) | Users, packages, exports, everything |

Gating it on real clients is not caution for its own sake: a portal stores
passports and personal records (GDPR-grade liability) and must not exist
before revenue justifies operating it.

---

## 4. How the build is executed

The build runs as batched PRs defined in `docs/PR-BATCHES.md`, written so a
single model in a single chat can execute a whole batch unattended: each PR
has scope, files, acceptance criteria and dependencies, CI is the merge gate,
and every build session appends what shipped, what was skipped and what risks
it noticed to `docs/BUILD-LOG.md`. Batch 0 is Phase 1.5; Batch 1 is Phase 2;
Batch 2 is Phase 3 and is the only one blocked on owner-supplied data
(`docs/PRODUCTION-DATA-REQUIRED.md`).

---

## 5. What would make this fail

- **Publishing unreviewed guides to hit a page count.** The whole positioning
  rests on the review claim being true. One wrong apostille instruction that
  costs a reader a trip to Asunción undoes every honest page.
- **Adding a statistics band to the home page.** The absence of numbers is the
  differentiator, not an omission to be fixed later.
- **Letting the guides become SEO filler.** Depth should come from usefulness —
  a decision table, a real sequence, a named failure mode — never word count.
- **Shipping `/packages/` with invented prices** to look complete.
