<?php
/**
 * Editorial standards.
 *
 * Everything claimed here is enforced somewhere in the codebase, not just
 * asserted: the review gate is robots_directive() + the 'status' field, the
 * dating is the last_reviewed field rendered by the page-header block, and
 * tools/qa.php fails the build if an unresolved placeholder reaches HTML.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Why do some pages say "in preparation" instead of just being published?',
   'a' => ['Because they are not finished, and a half-researched page about immigration or tax is worse than no page. A route that is in preparation renders an honest notice, is excluded from our sitemap, and is closed to search engines until the content exists and has been reviewed.']],
  ['q' => 'Is this site legal or tax advice?',
   'a' => ['No. It is general information about Paraguayan procedures. It cannot account for your nationality, your family situation, your existing tax exposure or your history, all of which change the answer. Where a question needs a lawyer or an accountant, our guides say so rather than stretching to cover it.']],
  ['q' => 'How do I report an error?',
   'a' => ['Send us the page URL, the sentence you think is wrong, and — if you have one — the source that says otherwise. We would rather receive a correction that turns out to be mistaken than not receive one that was right.']],
  ['q' => 'Do you accept payment for links or mentions in your guides?',
   'a' => ['No. No page on this site contains paid placement, affiliate links or sponsored mentions. The only commercial relationship we have with a reader is the service they hire us for.']],
],

'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'How our content is made',
 'intro' => 'We publish guidance about immigration, tax and banking — decisions where being confidently wrong costs a reader real money and real time. These are the rules we hold ourselves to, and the mechanisms that make them more than a statement of intent.',
],

['type' => 'prose',
 'heading' => 'The source hierarchy',
 'body' => [
   'When sources disagree, we follow this order and say which one we used.',
   ['type' => 'list', 'items' => [
     '<strong>Paraguayan law as published</strong> — laws, decrees and resolutions in the official record.',
     '<strong>The authority that actually decides</strong> — Dirección Nacional de Migraciones for residency, DNIT for tax and the RUC, the Banco Central del Paraguay and SEPRELAD for banking and compliance, Identificaciones for the cédula, the Ministerio de Relaciones Exteriores for consular and apostille matters.',
     '<strong>Qualified professional review</strong> — a Paraguayan lawyer or accountant confirming how the rule is applied in practice, where practice and text differ.',
     '<strong>Our own direct experience</strong> — clearly labelled as experience, never presented as a rule.',
   ]],
   'We do not cite immigration marketing blogs, relocation content farms or forum posts as authority for a factual claim. If the only thing we can find is secondary commentary, the claim is marked as unverified or left out.',
 ],
],

['type' => 'prose',
 'heading' => 'How a guide gets published',
 'body' => [
   ['type' => 'defs', 'items' => [
     ['term' => '1. Research', 'def' => 'Primary Paraguayan sources first. Every factual claim gets a source recorded against it before any drafting starts.'],
     ['term' => '2. Draft', 'def' => 'Written to answer one question, for one kind of reader, with the direct answer near the top rather than after eight paragraphs of preamble.'],
     ['term' => '3. Qualified review', 'def' => 'Legal content is read by a Paraguayan lawyer; tax content by a Paraguayan accountant. This is a gate, not a formality — an unreviewed page does not publish.'],
     ['term' => '4. Publish, dated', 'def' => 'The page goes live carrying a visible last-reviewed date, the author, and the reviewer.'],
     ['term' => '5. Re-review', 'def' => 'Pages are revisited when the law moves, when a reader reports a problem, or on schedule — whichever comes first.'],
   ]],
   'Step 3 is enforced by the site itself, not by good intentions. A page without finished, reviewed content renders an "in preparation" notice, is excluded from the sitemap, and is served with <code>noindex</code> regardless of any other setting.',
 ],
],

['type' => 'prose',
 'heading' => 'What we will not do',
 'body' => [
   ['type' => 'list', 'items' => [
     'Publish an approval rate, a client count, or an average processing time as our own statistic.',
     'Publish a testimonial, review, case study or client name that is not real and not consented to.',
     'Present an estimate as a guarantee, or eligibility as approval.',
     'Suggest that legal residency, a RUC or a cédula changes your tax residency by itself.',
     'Suggest that a bank account, or citizenship after a given number of years, is automatic.',
     'Write to a word count. A guide is as long as the answer needs and no longer.',
     'Publish a page whose only purpose is to rank for a phrase.',
   ]],
 ],
],

['type' => 'prose',
 'heading' => 'Dating and corrections',
 'body' => [
   'Every guide shows the date it was last reviewed, in full, at the top of the page. If that date is old, you can see that it is old and weigh the page accordingly. We would rather you distrust a stale page than trust it because we hid its age.',
   'Corrections are made in place, with the review date updated. Where a correction changes the practical advice rather than the wording, we say what changed and when.',
   'If you find an error, tell us. Send the page URL, the specific sentence, and a source if you have one.',
 ],
],

['type' => 'callout',
 'label' => 'Two disclosures still to be made on this page',
 'body' => [
   'This page names the review process but not yet the reviewers. The Paraguayan lawyer and accountant who review legal and tax content will be named here, with their credentials, before any guide relying on their review is published.',
   'We also owe readers a plain statement of how these pages are drafted, including what role software plays in research and drafting and where human and professional judgement takes over. That statement will be published here rather than buried in a policy page.',
 ],
],

['type' => 'faq',
 'eyebrow' => 'About this site',
 'heading' => 'Questions readers ask us.',
],

['type' => 'related',
 'items' => [
   ['page' => 'integrity', 'note' => 'What we control, what we do not, and how we present estimates.'],
   ['page' => 'terms',     'note' => 'The general-information disclaimer that applies to every guide here.'],
   ['page' => 'about',     'note' => 'Who runs Paraguay Frontier and how the work is done on the ground.'],
 ],
],

],
];
