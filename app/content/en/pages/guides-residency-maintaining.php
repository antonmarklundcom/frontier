<?php
/**
 * Keeping residency in good standing. Structure complete, copy unwritten.
 * This is the page nobody else writes, because it is about the years after the
 * sale. Write it as maintenance instructions, not as reassurance.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'How long can I be outside Paraguay?',            'a_html' => ['{{ 60-90 words: the rule for each status, cited. }}']],
  ['q' => 'What happens if I lose my cédula abroad?',       'a_html' => ['{{ 60-90 words: the replacement route and what it needs. }}']],
  ['q' => 'Do I have to file anything if I earn nothing here?', 'a_html' => ['{{ 60-90 words: registration obligations that exist regardless of income. Cross-link the RUC guide. }}']],
  ['q' => 'Can residency be revoked?',                      'a_html' => ['{{ 60-90 words: the grounds, plainly. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Residency · Afterwards',
 'intro' => '{{ 45-70 words: lede. Approval is a start; these are the obligations that keep the status alive. }}'],
['type' => 'quick-answer',
 'question' => 'What do I have to do to keep Paraguayan residency?',
 'answer_html' => ['{{ 60-90 words: the direct answer — presence, renewal, records, filings. }}', '{{ 40-60 words: what most people neglect and what it costs them. }}'],
 'points_html' => ['{{ obligation 1 }}', '{{ obligation 2 }}', '{{ obligation 3 }}', '{{ obligation 4 }}'],
 'caveat_html' => '{{ 30-50 words: differs by status and by whether the reader is registered for tax. }}'],
['type' => 'checklist', 'eyebrow' => 'Maintenance', 'heading' => 'Your standing schedule',
 'intro_html' => ['{{ 40-60 words: how to use this — put these in a calendar the day the cédula arrives. }}'],
 'groups' => [
   ['title' => 'Every year', 'note_html' => '{{ 25-40 words }}', 'items' => [
     ['item_html' => '{{ obligation }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ obligation }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
   ]],
   ['title' => 'On a fixed cycle', 'note_html' => '{{ 25-40 words }}', 'items' => [
     ['item_html' => '{{ obligation }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You', 'validity' => '{{ interval }}'],
     ['item_html' => '{{ obligation }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You', 'validity' => '{{ interval }}'],
   ]],
   ['title' => 'When something changes', 'note_html' => '{{ 25-40 words: address, marital status, new dependants, lost documents. }}', 'items' => [
     ['item_html' => '{{ trigger and what it requires }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ trigger and what it requires }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
   ]],
 ],
 'footnote_html' => '{{ 30-50 words: dated, changes, report an error. }}'],
['type' => 'callout', 'label' => 'Absence is the one that catches people',
 'body_html' => ['{{ 60-90 words: how a status quietly lapses through time spent away, and what the reader should track. }}']],
['type' => 'faq', 'eyebrow' => 'Maintenance questions', 'heading' => 'After the cédula.'],
['type' => 'sources', 'intro_html' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Renewal and absence', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => 'Departamento de Identificaciones', 'authority' => 'Cédula renewal and replacement', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.residency.temporary-vs-permanent'], ['page' => 'guides.tax.ruc'], ['page' => 'guides.citizenship']]],
['type' => 'next-step', 'heading' => 'If your status has already slipped',
 'body_html' => ['{{ 40-60 words: what can usually be repaired, what cannot, and how we assess it. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'diy_html' => '{{ 30-50 words: most readers can run this schedule themselves — say so. }}'],
],
];
