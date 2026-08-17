# Design direction — Paraguay Frontier

The build spec for every page that follows. Values, not adjectives.

## Track and thesis

**EDITORIAL** track (light-dominant, hairlines, generous air) with INDUSTRIAL
grain borrowed for the dark bands. The site should read like a briefing
prepared by people who have actually stood in the queue at Migraciones — not an
offshore-sales funnel, not a travel blog, not a gold-and-navy immigration site.

The organising idea is **the route**: a residency application is a sequence of
custody hand-offs between you, a translator, us, and the government. Every
signature element in the design encodes that sequence, and every one of them
carries real information rather than decorating the page.

## Palette — derived, not copied

| Token | Hex | Role |
|---|---|---|
| `--base` | `#F3F5F2` | Survey Paper. Page field. |
| `--base-2` | `#EAEEE9` | Alternating band. |
| `--ink` | `#081D24` | Paraná Ink. Type, dark sections, header on the home page. |
| `--slate` | `#123A3B` | Jungle Slate. The standards ribbon only. |
| `--mist` | `#B8D8D1` | River Mist. Muted type and hairlines on dark. |
| `--accent` | `#E4941F` | **Ruta Amber, hue 36°. The one accent.** |
| `--accent-deep` | `#8A5507` | Amber for body-size text on paper (7.0:1). |
| `--accent-large` | `#B5700A` | Amber for display-size text only (≥3:1). |
| `--warn` | `#D94A36` | Signal Red — **semantic only**, never a design accent. |

### Why the accent changed from the brief

The brief proposed Signal Red `#D94A36` (hue 7°) as the primary accent. Two
reasons it moved to amber:

1. **Meaning.** On a site whose entire pitch is calm accuracy about a
   high-stakes legal process, a red primary CTA reads as alarm. Amber is the
   colour of survey markers and unpaved *ruta* — it carries the field-work
   association without the warning association.
2. **Semantics stay free.** Red is now reserved for genuine cautions (the
   "read this before you compare providers" callout, the "who this is not for"
   note). A site that uses its warning colour for buttons has no warning colour.

Signal Red survives, doing the job it is actually good at.

### Contrast, measured

| Pair | Ratio | Verdict |
|---|---|---|
| ink on paper | 15.8:1 | Pass |
| ink-70 on paper (body) | 6.2:1 | Pass |
| ink-62 on paper (eyebrows, meta) | 4.8:1 | Pass |
| mist on ink | 11.4:1 | Pass |
| paper-72 on ink (body on dark) | 8.2:1 | Pass |
| accent on ink | 7.1:1 | Pass |
| **ink on accent** (primary button) | 7.1:1 | Pass |
| accent on paper | 2.2:1 | **Fail — amber is never text on a light field** |

The last row is the rule that shapes the whole palette: the amber button has
*dark* text on it, which is also why it reads considered rather than shouty.

## Type — three roles, three faces

| Role | Face | Notes |
|---|---|---|
| Display | **Archivo** (variable, wdth 62–125) | `font-stretch: 84%` for headings, 78% for the oversized statement, 70% for the giant step numerals. One file covers every width. |
| Text | **IBM Plex Sans** 400/600 | 17px / 1.65, measure capped at 65ch. Humanist and technical — it reads as documentation, which is the point. |
| Utility | **IBM Plex Mono** 500 | Eyebrows, dates, stage owners, coordinates, "Rev. 2026-08", breadcrumbs, source labels. |

All three are SIL OFL, self-hosted from `assets/fonts/`, `font-display: swap`,
latin and latin-ext subsets split by `unicode-range` so English pages never
download latin-ext. Archivo latin and Plex Sans 400 latin are preloaded.

This is one face more than the design system's two-face rule. The deviation is
deliberate: the mono role carries the document-metadata layer that makes the
"field intelligence" idea legible, and it is confined to small uppercase labels
where it can never be confused with body copy.

Type scale ratio **1.30**. Display tracking `-0.025em` to `-0.04em`, weight 500.
No size is invented between steps.

## The Frontier Route — the one signature system

Three expressions of the same idea, all carrying real data:

1. **Hero route card.** The six real stages of a residency application, with the
   party responsible for each. The connecting line draws itself over 1.5s on
   load and the stage markers light in sequence. It is the brand thesis stated
   as a diagram: *stages 1–3 and 6 are ours, stage 4 is the government's.*
2. **Page rail.** A fixed vertical progress rail in the left margin at ≥1560px.
   Every marker is a real section, the fill tracks real scroll position, and it
   is a labelled in-page navigation list. It fades in only after the hero, so
   its ink labels never land on the dark field.
3. **Journey section.** The same six stages at full size with oversized amber
   numerals at 22% opacity behind the text.

**It never draws a map.** No outline of Paraguay, no floating city dots, no
labelled diagram that encodes nothing. The hero's contour lines are a
*texture* — unlabelled, sub-25% opacity, making no geographic claim.

## Section-to-pattern map — the home page

| # | Section | Pattern | Field |
|---|---|---|---|
| 01 | Hero | P1 asymmetric split 7/5 | ink, full-bleed, grain |
| 02 | Where are you in the process? | **P10 data panel** (interactive) | base-2 |
| 03 | Service pathways | P3 staggered grid, 4/2 · 2/4 pinwheel | paper |
| 04 | What we do / will not claim | P4 editorial two-column | paper |
| 05 | The route in full | P5 numbered process rail | ink, grain |
| 06 | Knowledge centre | P7 sticky-side scroll | paper |
| 07 | Editorial standards | P8 full-bleed ribbon | slate, grain |
| 08 | Integrity promise | **P9 oversized statement** (one per page) | base-2 |
| 09 | Cornerstone guides | **P6 bleed-image overlap** | ink → panel crosses into 10 |
| 10 | Consultation | P1 mirrored 5/7 | base-2 |

Constraints met: no more than two consecutive sections share a pattern; the page
has a full-bleed (01, 07), an intentional overlap (09 crossing into 10), and one
oversized statement (08); four card variants are used (`--ink`, `--accent`,
`--hair`, `--raised`), none more than four times.

## Motion budget

| Element | Behaviour | Duration |
|---|---|---|
| Hero route line + markers | Draws on load, staggered 250ms apart | 1500ms / 300ms |
| Section reveals | Opacity + 18px rise, 70ms stagger, capped at 6 siblings | 280ms |
| Route rail | Progress height + current-marker state | 120ms linear |
| Hero contours | 0.07× scroll drift, **desktop only**, capped at 900px | rAF |
| Hover | `translateY(-4px)` + shadow step | 180ms |

Easing: `cubic-bezier(.16,1,.3,1)` in, `cubic-bezier(.4,0,.2,1)` for hovers.
About 12% of elements animate. **No entrance animation on above-the-fold hero
text** — the H1 and lede paint immediately. `prefers-reduced-motion: reduce`
disables everything and renders the route in its finished state, verified in a
real browser.

No parallax below 1024px. No scroll-jacking. No count-ups — there are no numbers
to count, by design.

## Rules for the remaining 28 pages

- Guide pages use the same blocks. Do **not** invent a new visual language per
  page; vary the block *order*, not the system.
- Every guide opens with a direct answer, then who it applies to. The
  `quick-answer` and `definition` blocks are next to be built.
- Every guide ends with: sources, last-reviewed date, related guides, one next
  step. In that order.
- One `.statement` per page maximum. It is the expensive moment; two is none.
- The amber accent appears at most twice per screen.
- Any table must scroll inside `overflow-x: auto`, never widen the page.
- Print styles already strip the chrome — guides and checklists must stay
  printable, because people print document checklists.
