# Production data required

Every item below is currently a placeholder or an unverified claim. The site is
`noindex,nofollow` and `robots.txt` blocks all crawlers until the **Launch
blockers** section is empty.

Nothing here has been invented. Where a value was unknown, the code suppresses
the surrounding UI rather than displaying a guess.

Last updated: 2026-08-17 (rev 2)

---

## Launch blockers — the site must not be indexed until these are done

| # | Item | Placeholder | Where it appears | Who verifies |
|---|---|---|---|---|
| 1 | Business email | `[BUSINESS_EMAIL]` | `config/site.php`; footer contact, Organization schema | Owner |
| 2 | WhatsApp number | `[WHATSAPP_NUMBER]` | `config/site.php`; footer, consultation CTA, sticky mobile action | Owner |
| 3 | Consultation booking URL | `[CALENDAR_URL]` | `config/site.php`; `/book-consultation/` | Owner |
| 4 | Company registration details | `[COMPANY_REGISTRATION_DETAILS]` | footer legal line | Owner / accountant |
| 5 | Legal reviewer name and credential | `[LEGAL_REVIEWER]` | residency + citizenship guides, `/editorial-standards/` | Paraguayan lawyer |
| 6 | Tax reviewer name and credential | `[TAX_REVIEWER]` | tax + RUC guides, `/editorial-standards/` | Paraguayan accountant |
| 7 | Refund / remedy policy | `[REFUND_POLICY]` | `/integrity/` | Lawyer drafting the service agreement |
| 8 | SMTP credentials, and one real test message received | — | `config/env.php` | Owner |
| 9 | Legal and tax review of every published guide | — | all `/guides/` pages | Reviewers 5 and 6 |
| 10 | Publish a plain statement of how pages are drafted, including what role software plays and where human and professional judgement takes over | — | `/editorial-standards/` promises this statement in a visible callout | Owner |
| 11 | Set `config/site.php` `'launched' => true`, replace `robots.txt`, run `php tools/build-sitemap.php` | — | site-wide | Owner |

**Items 9 and 10 are the real gates.** The home page states that legal and tax pages are
held for qualified review before publication. Publishing an unreviewed guide
would make that statement false, which is worse than publishing nothing.

---

## Needed before the commercial pages can be written

| Item | Placeholder | Notes |
|---|---|---|
| Package prices | `[PACKAGE_PRICE]` | `/packages/` cannot be written without them. No price is invented anywhere. |
| Package inclusions and exclusions | `[PACKAGE_INCLUSIONS]` | Must distinguish our fee, government fees and third-party fees. |
| Founder name | `[FOUNDER_NAME]` | Enables `Person` author schema, which is currently suppressed. |
| Founder biography | `[FOUNDER_BIO]` | `/about/` |
| Team photograph | `[TEAM_PHOTO]` | Real photography only — never AI-generated for a trust slot. |
| Paraguay address | `[PARAGUAY_ADDRESS]` | Required before any `LocalBusiness` schema is added. It is not emitted today. |
| Consultation fee | — | The home page calls it "a paid working session"; the amount must be stated on `/book-consultation/`. |

---

## Explicitly not collected, and why

These are standard on competitor sites. They are absent here deliberately and
should stay absent unless they become genuinely true and verifiable.

- Client counts, approval rates, "years of experience"
- Average or guaranteed government processing times
- Testimonials, case studies, client names, media mentions
- Visa-free destination counts, tax-saving figures
- Government relationships or "official partner" claims
- Review or rating schema

---

## Media still to produce

The home page is designed to work without photography and currently ships with
none. Nothing on it is a marked-but-empty image slot.

| Slot | Page | Ratio | Treatment | Required before launch |
|---|---|---|---|---|
| `hero-bleed` | Home | 21:9 | Asunción street or government-office exterior, scrim + grain behind the hero text | No — the hero is complete without it |
| `proof-photo` | `/about/` | 4:3 | **Real** team photography, never generated | Yes, before `/about/` publishes |
| `section-break` | `/process/` | 21:9 | Document preparation, personal details obscured | No |
| `card-motif` | Service pages | 4:3 | Original diagrams, not stock | No |

The Open Graph card at `assets/images/og-default.png` is original artwork
generated from the site's own type and palette, and carries no claims.
