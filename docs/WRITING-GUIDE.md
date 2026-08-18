# Writing guide

How to turn a scaffolded page into a published one. Written for whoever — or
whatever — does the writing pass, including a model working through
`docs/COPY-BRIEF.md` unattended.

Read this before writing a single sentence. The rules below are not style
preferences; several of them are the reason the site exists, and one violated
claim undoes the positioning of every other page.

---

## 1. What a scaffolded page is

Every route now has a content file under `app/content/en/pages/`. Each file
holds the finished **structure** — which blocks appear, in what order, with what
headings — and leaves the **prose** as briefs:

```php
'intro' => '{{ 45-70 words: the lede. Who this page is for, what it covers. }}',
```

Your job is to replace the entire string, braces included, with real prose:

```php
'intro' => 'You are probably reading this with a folder of half-gathered records…',
```

Change nothing else. Not the block order, not the keys, not the structure. If a
brief asks for something that turns out to be wrong — a row that does not exist,
a checklist item that is not really required — delete that entry rather than
padding it, and say so in the commit message.

## 2. How publication actually works

There is no publish button and no status to flip.

| State | What makes it that | What a visitor sees |
|---|---|---|
| `planned` | no content file | "In preparation" notice |
| `draft` | content file with at least one `{{ brief }}` left | "In preparation" notice |
| `live` | content file with no briefs left | the page |

`resolve_page()` in `app/draft.php` works this out on every request. A draft is
`noindex,nofollow`, is excluded from `sitemap.xml`, and shows visitors the same
honest notice as a route nobody has started. Fill the last brief on a page and
it becomes live by itself.

This means two things. Half-writing a page is safe — nothing leaks. And you
cannot accidentally publish a page by forgetting to update a flag.

**But `live` is not the same as `published`.** The site as a whole stays
`noindex` until `config/site.php` sets `'launched' => true`, which must not
happen until `docs/PRODUCTION-DATA-REQUIRED.md` is clear — including the legal
and tax review of every guide. Writing a page well does not clear that gate.

## 3. Reading your work in the real layout

```bash
PF_PREVIEW=1 php -S 127.0.0.1:8080 -t .
```

Draft pages then render their outline in the finished design, with every
unwritten passage marked `⟦ like this ⟧` and a banner at the top counting what
is left. Without `PF_PREVIEW=1` you get what a visitor gets.

Preview is forced off whenever `launched` is true, and `config/site.example.php`
ships with it off, so a server with no configuration of its own can never serve
an outline.

## 4. The rules that are not negotiable

These are enforced by `tools/qa.php` where a machine can check them, and by the
reviewer where it cannot.

**Never publish a number we cannot stand behind.** No processing times, no
approval rates, no client counts, no years of experience, no visa-free
destination counts, no tax-saving figures, no cost-of-living figures without a
dated source. This includes softened forms: "usually about three months" is the
same claim with a hedge in front of it.

**Prices appear in exactly two places** — `/packages/`, once real prices exist,
and a written quote to a specific client. Never as an example, never as a
"from" figure, never to make a table look complete.

**Every factual claim traces to a primary source.** Paraguayan law as published;
then the authority that actually decides (Migraciones, DNIT, Banco Central,
SEPRELAD, Identificaciones, the MRE); then qualified professional review; then
our own experience, labelled as experience. Relocation blogs, forums and
competitor pages are never authority for a fact. Record what you used in the
page's `sources` block, with the URL you actually opened — a source with no URL
recorded renders as plain text, which is fine. Inventing a plausible government
URL is not.

**Distinguish the three statuses, every time.** Legal residency, tax
registration (RUC) and tax residency are different things. Never let a sentence
imply that acquiring one acquires another.

**Never promise an outcome.** Not approval, not a timeline, not a bank account,
not citizenship, not a tax result. Eligibility is not approval; preparation is
not access.

**Keep the paragraphs that cost us money.** Several briefs ask for a "when you
should not hire us" or "you may not need us" passage. Those are mandatory. They
are the product — a reader who has been told once that they might not need you
believes the rest of the page.

**No testimonials, reviews, case studies, client names or media mentions**
unless they are real, consented to, and verifiable. There is no review schema on
this site and there must not be.

**Attack claims, not competitors.** Several pages dismantle the category's
standard pitch. Do it by explaining why the claim is wrong, never by naming a
firm.

## 5. Voice

- British spelling. Second person. Past the point, not around it.
- Short sentences carrying one idea each. No exclamation marks, no rhetorical
  questions used as headings, no "in today's world" openers.
- Say the uncomfortable thing in the same sentence as the useful thing, rather
  than in a disclaimer underneath it.
- Spanish terms in their Paraguayan form on first use, with the English in
  brackets: *cédula* (identity card). The `definition` block has a `spanish`
  field for this.
- Where the honest answer is "it depends on your nationality", write that, and
  then write what it depends on. Silently picking the common case is the
  failure mode this site is built against.

## 6. Markup in content strings

Prose fields accept `<strong>`, `<em>` and `<a href="…">` and nothing else.
Anything structural — a list, a definition list, a subheading — is a data
structure the template renders:

```php
'body' => [
  'A paragraph.',
  ['type' => 'list', 'items' => ['One.', 'Two.']],
  ['type' => 'h3',   'text'  => 'A subheading'],
  ['type' => 'defs', 'items' => [['term' => 'Apostille', 'def' => 'What it is.']]],
],
```

Internal links are written by page id, never by URL:
`href(page_url('guides.residency.documents'))` inside a template, and in content
files as a `['page' => 'guides.residency.documents']` reference. A URL change in
the registry then propagates everywhere. QA fails on an unknown id.

## 7. The block vocabulary

| Block | Use it for |
|---|---|
| `page-header` | H1, lede, and the review stamp. First block on every interior page. |
| `quick-answer` | The reader's question answered in the first screen, with its limit attached. |
| `definition` | One term defined, then bounded by what it is *not*. |
| `checklist` | Grouped, printable preparation lists with owner and validity per item. |
| `comparison` | A decision table. Stacks under column labels on a phone. |
| `steps` | A sequence where each stage says whose desk it is on. |
| `prose` | Everything else, including `defs` and `list` parts. |
| `callout` | A caution. Signal Red is reserved for this; never decoration. |
| `faq` | Renders `$page['faqs']`; FAQPage schema is emitted only when this block is present. |
| `sources` | What the page rests on. Required on any page making factual claims. |
| `reviewer` | The review stamp. Says "not yet reviewed" honestly while that is true. |
| `related` | Three neighbouring pages, by id. |
| `next-step` | The quiet foot-of-guide CTA, with the "you may not need us" note. |
| `form` | The consultation enquiry form. `/book-consultation/` only. |

Home-page-only blocks (`hero`, `router`, `pathways`, `scope`, `journey`,
`knowledge`, `ribbon`, `guides`, `statement`, `consultation-cta`) are reusable
but heavy; a guide should end with `next-step`, not `consultation-cta`.

## 8. Order of work

`docs/COPY-BRIEF.md` lists every remaining passage, by page, with its key path.
Regenerate it with `php tools/copy-brief.php`; for one page,
`php tools/copy-brief.php guides.residency.documents`.

Write in this order — it is commercial priority, not page count:

1. `/book-consultation/` — the home page's CTAs currently dead-end here.
2. `/guides/residency/documents/` — the most linkable page in the category.
3. `/guides/tax/tax-vs-legal-residency/` — the distinction the category blurs.
4. `/guides/residency/costs/` and `/guides/residency/timeline/`.
5. The residency and tax hubs, then the remaining detail guides.
6. Services and `/process/`. `/packages/` is blocked on real prices; `/about/`
   on a real named founder; `/privacy/` and `/terms/` on a lawyer.

## 9. Before you call a page done

```bash
php -l app/content/en/pages/<file>.php   # syntax
php tools/qa.php                          # 0 failures, 0 warnings
php tools/copy-brief.php                  # confirm the page has left the list
PF_PREVIEW=1 php -S 127.0.0.1:8080 -t .   # read it in the layout
```

Then check by eye, because QA cannot:

- Does the first screen answer the question the title asks?
- Is there a number anywhere that we cannot source?
- Does the page say, once, what it will not tell the reader and why?
- Would a sceptical Paraguayan lawyer recognise the procedure described?
- Is the `sources` block filled with what you actually read?

A page that passes all of that is still not published. It is `live`, awaiting
the reviewer named in `docs/PRODUCTION-DATA-REQUIRED.md`, and the site remains
`noindex` until that review has happened.
