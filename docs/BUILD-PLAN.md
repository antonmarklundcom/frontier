# Paraguay Frontier — build and traffic plan

Where the project is, what comes next, and the commercial reasoning behind the
sequence. Written after the home page shipped, 2026-08-17.

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

### Phase 2a — structure for the whole site — done

Split from the original Phase 2 once it became clear that structure and prose
are different jobs with different constraints: structure is an architecture
decision that should be made once, in one head, for the whole site; prose is
research, and research is where the time and the review burden actually sit.

Delivered: the nine remaining block templates (`quick-answer`, `definition`,
`checklist`, `comparison`, `steps`, `sources`, `reviewer`, `next-step`, `form`),
the copy-slot system in `app/draft.php`, a content file for all 29 remaining
routes carrying its finished block structure, the enquiry-form pipeline, and
`docs/COPY-BRIEF.md` — 811 briefs, each naming what its passage must contain.

The gate moved into the code. A page with any unwritten brief resolves to
`draft`: `noindex`, out of the sitemap, and shown to visitors as the same
"in preparation" notice as a route nobody started. It becomes live when its last
brief is replaced. There is no status to remember to flip, and no way to publish
a half-written page by mistake.

### Phase 2b — the writing pass (next)

Work `docs/COPY-BRIEF.md` in the order given in `docs/WRITING-GUIDE.md`:
`/book-consultation/` first, because the home page's CTAs dead-end there today,
then the four Tier 1 guides against primary sources (Migraciones, DNIT, Banco
Central, MRE, Identificaciones, the official legal database).

Each guide is written, then **held** for the legal or tax reviewer named in
`docs/PRODUCTION-DATA-REQUIRED.md`. A written but unreviewed guide is `live` in
the code's sense and still unpublished in the site's sense — the whole site
stays `noindex` until launch, so the review gate holds regardless.

### Phase 3 — commercial pages

Blocked on real inputs rather than on work: `/packages/` needs agreed prices and
inclusions, `/about/` a named founder and a real photograph, `/privacy/` and
`/terms/` a lawyer. The structure for all four is built and waiting.

The enquiry pipeline itself is done — browser → own PHP handler → email +
VenderCRM, CRM key server-side only, with CSRF, honeypot, minimum completion
time, rate limiting and POST-redirect-GET. It renders **disabled**, with the
reason stated on the page, until SMTP is configured. The site cannot claim the
form works until a real message has been received on real hosting.

### Phase 4 — deployment and live verification

Release builder and smoke test exist (`tools/build-release.php`,
`tools/smoke-test.php`). What remains is running them against Hostinger and
clearing `docs/HOSTINGER-LIVE-TEST-CHECKLIST.md`, which is still entirely
unchecked — nothing has ever been uploaded.

### Phase 5 — launch

Clear `docs/PRODUCTION-DATA-REQUIRED.md`, set `'launched' => true`, replace
`robots.txt`, regenerate the sitemap, verify by DNS TXT in Search Console,
submit. Not before.

### Phase 6 — Spanish under `/es/`

The architecture already separates content by locale and emits no `hreflang`
until Spanish pages exist. Spanish must be professionally localised, with its
own review dates and its own reviewer — a machine-translated legal page is a
liability, not a growth channel.

---

## 4. What would make this fail

- **Publishing unreviewed guides to hit a page count.** The whole positioning
  rests on the review claim being true. One wrong apostille instruction that
  costs a reader a trip to Asunción undoes every honest page.
- **Adding a statistics band to the home page.** The absence of numbers is the
  differentiator, not an omission to be fixed later.
- **Letting the guides become SEO filler.** Depth should come from usefulness —
  a decision table, a real sequence, a named failure mode — never word count.
- **Shipping `/packages/` with invented prices** to look complete.
