<?php
/**
 * Tax hub. Structure complete, copy unwritten.
 * Every claim here needs the tax reviewer. Nothing on this page may read as
 * planning advice for any particular reader.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Will moving to Paraguay lower my tax bill?', 'a' => ['{{ 60-90 words: refuse the general answer and explain what it depends on. }}']],
  ['q' => 'Do I need a Paraguayan accountant?',         'a' => ['{{ 60-90 words: when yes, when no. }}']],
  ['q' => 'Do I need an adviser at home as well?',      'a' => ['{{ 60-90 words: usually yes, and why the two conversations have to happen together. }}']],
  ['q' => 'Is any of this advice?',                     'a' => ['{{ 40-60 words: no — general information, and here is the line. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Guides · Tax',
 'intro' => '{{ 50-80 words: lede. Three separate things get called "tax" in this category; this cluster separates them. }}'],
['type' => 'quick-answer',
 'question' => 'How does Paraguay tax a foreign resident?',
 'answer' => ['{{ 70-110 words: the landscape — territoriality, registration, residency tests. }}',
              '{{ 40-60 words: the home-country half that no Paraguayan page can answer. }}'],
 'points' => ['{{ point 1 }}', '{{ point 2 }}', '{{ point 3 }}'],
 'caveat' => '{{ 30-50 words: general information, not advice; nationality and existing exposure change everything. }}'],
['type' => 'knowledge', 'eyebrow' => 'The cluster', 'heading' => 'Three pages, three different questions',
 'lede' => '{{ 30-50 words: which page answers which question. }}',
 'cta' => ['page' => 'guides.tax.vs-legal', 'label' => 'Start with the distinction'],
 'items' => [
   ['page' => 'guides.tax.vs-legal',    'title' => 'Tax residency vs legal residency', 'body' => '{{ 12-22 words }}'],
   ['page' => 'guides.tax.territorial', 'title' => 'Territorial taxation',             'body' => '{{ 12-22 words }}'],
   ['page' => 'guides.tax.ruc',         'title' => 'The RUC explained',                'body' => '{{ 12-22 words }}'],
 ]],
['type' => 'callout', 'label' => 'The sentence to be sceptical of',
 'body' => ['{{ 60-90 words: the standard marketing claim about Paraguayan tax, and what is missing from it. }}']],
['type' => 'faq', 'eyebrow' => 'Tax questions', 'heading' => 'Before you plan anything.'],
['type' => 'reviewer', 'reviewer_key' => 'tax_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.residency'], ['page' => 'guides.banking'], ['page' => 'services.ruc']]],
['type' => 'next-step', 'heading' => 'Getting the Paraguayan half right',
 'body' => ['{{ 40-60 words: what we do, and the hand-off to a Paraguayan accountant and to the reader\'s own adviser. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.ruc', 'label' => 'RUC and tax registration support'],
 'diy' => '{{ 30-50 words: who does not need us. }}'],
],
];
