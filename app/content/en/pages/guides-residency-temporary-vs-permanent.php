<?php
/**
 * Temporary versus permanent residency. Structure complete, copy unwritten.
 * The comparison table is the page; the prose exists to explain the rows.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do I have to start with temporary residency?', 'a' => ['{{ 60-90 words: the routes and any exceptions, cited. }}']],
  ['q' => 'What does the conversion depend on?',          'a' => ['{{ 60-90 words: the conditions, and what disqualifies or delays it. }}']],
  ['q' => 'Can I leave the country while temporary?',     'a' => ['{{ 60-90 words: absence rules for each status, stated separately. }}']],
  ['q' => 'Which one do I need for a RUC or a bank account?', 'a' => ['{{ 60-90 words: what each status unlocks in practice, without promising a bank account. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Residency · Status',
 'intro' => '{{ 45-70 words: lede. Two statuses, different obligations, and the decision most readers are actually making. }}'],
['type' => 'quick-answer',
 'question' => 'Should I be looking at temporary or permanent residency?',
 'answer' => ['{{ 60-90 words: the direct answer and the usual sequence. }}', '{{ 40-60 words: who the exception applies to. }}'],
 'points' => ['{{ key difference 1 }}', '{{ key difference 2 }}', '{{ key difference 3 }}'],
 'caveat' => '{{ 30-50 words: what changes this for a given applicant. }}'],
['type' => 'comparison', 'eyebrow' => 'Side by side', 'heading' => 'The two statuses compared',
 'caption' => 'Temporary and permanent Paraguayan residency compared across duration, renewal, absence, obligations and what each unlocks.',
 'row_header' => '', 'columns' => ['Temporary', 'Permanent'],
 'rows' => [
   ['label' => 'How long it lasts',        'cells' => ['{{ 8-20 words }}', '{{ 8-20 words }}']],
   ['label' => 'Renewal',                  'cells' => ['{{ 8-20 words }}', '{{ 8-20 words }}']],
   ['label' => 'Absence from Paraguay',    'cells' => ['{{ 8-20 words }}', '{{ 8-20 words }}']],
   ['label' => 'What it lets you do',      'cells' => ['{{ 8-20 words }}', '{{ 8-20 words }}']],
   ['label' => 'Obligations it creates',   'cells' => ['{{ 8-20 words }}', '{{ 8-20 words }}']],
   ['label' => 'Route to citizenship',     'cells' => ['{{ 8-20 words }}', '{{ 8-20 words }}']],
 ],
 'footnote' => '{{ 30-50 words: the row that decides it for most people, and why. }}'],
['type' => 'steps', 'eyebrow' => 'Conversion', 'heading' => 'Going from temporary to permanent',
 'intro' => ['{{ 40-60 words: what the conversion is and when it can be started. }}'],
 'items' => [
   ['title' => '{{ stage 1 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'You', 'blocker' => '{{ 20-35 words }}'],
   ['title' => '{{ stage 2 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 3 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Government'],
 ],
 'footnote' => '{{ 25-40 words: no duration for the government stage, and why. }}'],
['type' => 'callout', 'label' => 'The status you hold is not the status you assumed',
 'body' => ['{{ 60-90 words: the practical failure — people who believe they hold permanent status and discover otherwise at renewal, at a bank, or on re-entry. }}']],
['type' => 'faq', 'eyebrow' => 'Status questions', 'heading' => 'Choosing between the two.'],
['type' => 'sources', 'intro' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Residency categories', 'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => '{{ the governing law or decree, by number }}', 'authority' => 'Paraguayan law', 'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.residency.maintaining'], ['page' => 'guides.citizenship'], ['page' => 'services.permanent-residency']]],
['type' => 'next-step', 'heading' => 'Which one fits your plans',
 'body' => ['{{ 40-60 words: the questions a consultation settles — time in country, family, tax exposure. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.permanent-residency', 'label' => 'Permanent residency support'],
 'diy' => '{{ 30-50 words: who does not need us. }}'],
],
];
