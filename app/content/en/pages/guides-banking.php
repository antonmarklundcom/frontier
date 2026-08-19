<?php
/**
 * Banking hub. Structure complete, copy unwritten.
 * HARD RULE: no page on this site may imply that an account is obtainable,
 * likely, or arrangeable. Banks decide. Write preparation, not access.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Can you guarantee I will get an account?',      'a_html' => ['{{ 60-90 words: no, and what we actually do instead. }}']],
  ['q' => 'What does a bank want to see?',                 'a_html' => ['{{ 60-90 words: the file, in categories, cited where published. }}']],
  ['q' => 'Why are foreign applicants declined?',          'a_html' => ['{{ 60-90 words: the honest reasons, including ones that have nothing to do with the applicant. }}']],
  ['q' => 'Do I need a RUC to open an account?',           'a_html' => ['{{ 60-90 words: verify before asserting; if it varies by bank, say that. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Guides · Banking',
 'intro' => '{{ 50-80 words: lede. What a Paraguayan bank is assessing, and why the honest framing is preparation rather than access. }}'],
['type' => 'quick-answer',
 'question' => 'How hard is it for a foreign resident to open a Paraguayan bank account?',
 'answer_html' => ['{{ 70-110 words: the direct answer, including that well-prepared applications are declined. }}',
              '{{ 40-60 words: what improves the odds and what does not. }}'],
 'points_html' => ['{{ point 1 }}', '{{ point 2 }}', '{{ point 3 }}'],
 'caveat_html' => '{{ 30-50 words: bank policy varies and changes; nothing here binds any bank. }}'],
['type' => 'checklist', 'eyebrow' => 'Preparation', 'heading' => 'The source-of-funds file',
 'intro_html' => ['{{ 40-60 words: what this file is for and why an incomplete one is read as a red flag rather than an omission. }}'],
 'groups' => [
   ['title' => 'Identity and status', 'note_html' => '{{ 25-40 words }}', 'items' => [
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
   ]],
   ['title' => 'Where the money comes from', 'note_html' => '{{ 25-40 words }}', 'items' => [
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
   ]],
   ['title' => 'Local footprint', 'note_html' => '{{ 25-40 words }}', 'items' => [
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'Us'],
     ['item_html' => '{{ item }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'Us'],
   ]],
 ],
 'footnote_html' => '{{ 30-50 words: requirements differ by bank and change without notice. }}'],
['type' => 'callout', 'label' => 'Nobody can promise you an account',
 'body_html' => ['{{ 60-90 words: the strongest statement on the site about scope limits in banking. Say what a provider promising an account is really telling you. }}']],
['type' => 'faq', 'eyebrow' => 'Banking questions', 'heading' => 'Asked before every introduction.'],
['type' => 'sources', 'intro_html' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => 'Banco Central del Paraguay', 'authority' => 'Banking supervision', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => 'SEPRELAD', 'authority' => 'Anti-money-laundering requirements', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
['type' => 'related', 'items' => [['page' => 'services.banking'], ['page' => 'guides.tax.ruc'], ['page' => 'guides.living']]],
['type' => 'next-step', 'heading' => 'Preparing a file that gets a fair hearing',
 'body_html' => ['{{ 40-60 words: what our banking preparation covers, stated as preparation and introduction only. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.banking', 'label' => 'Banking preparation support'],
 'diy_html' => '{{ 30-50 words: who walks into a branch and manages alone. }}'],
],
];
