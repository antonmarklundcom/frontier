<?php
/**
 * What Paraguay residency costs — Tier 1.
 * Structure complete, copy unwritten.
 *
 * HARD RULE for this page: no invented figures. Where a fee is published by an
 * authority, cite it with the date it was checked. Where it is ours, it comes
 * from the agreed price list and nowhere else. Where it varies, publish the
 * range and the reason it varies. A cost page with a single confident total is
 * the thing this page exists to argue against, so do not build one.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Why do you not publish one all-in price?',
   'a' => ['{{ 60-90 words: because an all-in number hides which parts are ours, which are the government\'s and which vary with the reader\'s own records. Say what we publish instead. }}']],
  ['q' => 'Which costs do I pay directly to someone else?',
   'a' => ['{{ 60-90 words: name the categories paid to third parties and confirm we do not mark them up. }}']],
  ['q' => 'What makes a case more expensive than the common one?',
   'a' => ['{{ 60-90 words: the specific complications — records from multiple countries, name changes, dependants, non-Hague authentication. }}']],
  ['q' => 'What are the ongoing costs after approval?',
   'a' => ['{{ 60-90 words: renewals, tax filing obligations once registered, and anything else that recurs. }}']],
],

'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Residency · Costs',
 'intro' => '{{ 45-70 words: the lede. The page publishes cost categories rather than one number, and says why that is more useful. }}',
],

['type' => 'quick-answer',
 'question' => 'What does Paraguayan residency actually cost?',
 'answer' => [
   '{{ 60-90 words: the direct answer, structured as "there are five categories of cost and they behave differently". Do not state a total. }}',
   '{{ 40-60 words: what a reader should do with this page — build their own estimate from the categories. }}',
 ],
 'points' => [
   '{{ one line: category 1 — government fees }}',
   '{{ one line: category 2 — authentication and translation }}',
   '{{ one line: category 3 — professional fees }}',
   '{{ one line: category 4 — travel and being present }}',
   '{{ one line: category 5 — what recurs afterwards }}',
 ],
 'caveat' => '{{ 30-50 words: fees change, published amounts go stale, and the date at the foot of the page is the one that matters. }}',
],

['type' => 'comparison',
 'eyebrow' => 'The five categories',
 'heading' => 'Who is paid, and how fixed it is',
 'caption' => 'Each cost category, who receives the money, whether the amount is fixed and what makes it move.',
 'row_header' => 'Cost category',
 'columns' => ['Paid to', 'Fixed or variable', 'What moves it'],
 'rows' => [
   ['label' => 'Government fees',              'cells' => ['{{ recipient }}', '{{ fixed/variable }}', '{{ 12-25 words }}']],
   ['label' => 'Apostille and legalisation',   'cells' => ['{{ recipient }}', '{{ fixed/variable }}', '{{ 12-25 words }}']],
   ['label' => 'Sworn translation',            'cells' => ['{{ recipient }}', '{{ fixed/variable }}', '{{ 12-25 words }}']],
   ['label' => 'Professional fees',            'cells' => ['{{ recipient }}', '{{ fixed/variable }}', '{{ 12-25 words }}']],
   ['label' => 'Travel and time in country',   'cells' => ['{{ recipient }}', '{{ fixed/variable }}', '{{ 12-25 words }}']],
   ['label' => 'Ongoing, after approval',      'cells' => ['{{ recipient }}', '{{ fixed/variable }}', '{{ 12-25 words }}']],
 ],
 'footnote' => '{{ 30-50 words: state which amounts are published by an authority and when they were last checked. Our own fees are on the packages page, not here, and say so. }}',
],

['type' => 'prose',
 'eyebrow' => 'Reading a quote',
 'heading' => 'How to compare two providers honestly',
 'body' => [
   '{{ 70-110 words: the questions to ask any provider — what is included, what is billed separately, whether third-party fees are marked up, what happens if the file has to be resubmitted. }}',
   ['type' => 'list', 'items' => [
     '{{ question 1 to ask a provider }}',
     '{{ question 2 }}',
     '{{ question 3 }}',
     '{{ question 4 }}',
   ]],
   '{{ 40-60 words: the note that a cheaper quote which excludes authentication is not cheaper. }}',
 ],
],

['type' => 'callout',
 'label' => 'What we will not do on this page',
 'body' => [
   '{{ 60-90 words: state that no figure appears here unless it is published by the authority that charges it or is our own quoted fee, and that a total for a stranger\'s situation would be a guess. }}',
 ],
],

['type' => 'faq', 'eyebrow' => 'Cost questions', 'heading' => 'Asked before every engagement.'],

['type' => 'sources',
 'intro' => ['{{ 25-40 words: where the published fee amounts come from and the date they were checked. }}'],
 'items' => [
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Published fee schedule',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words: which fees, and the date checked }}'],
   ['name' => 'Ministerio de Relaciones Exteriores', 'authority' => 'Apostille and legalisation charges',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => '{{ further source, e.g. Identificaciones for the cédula — delete if unused }}',
    'authority' => '{{ issuing body }}', 'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
 ],
],

['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],

['type' => 'related',
 'items' => [
   ['page' => 'packages'],
   ['page' => 'guides.residency.documents'],
   ['page' => 'guides.residency.timeline'],
 ],
],

['type' => 'next-step',
 'heading' => 'A figure for your situation, not for a stranger',
 'body' => ['{{ 40-60 words: what the consultation produces — a written breakdown by category with the uncertain parts marked as uncertain. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'packages', 'label' => 'What our packages include'],
 'diy' => '{{ 30-50 words: the reader who can do this alone and should. }}',
],

],
];
