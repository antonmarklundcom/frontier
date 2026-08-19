<?php
/**
 * RUC and tax registration support. Structure complete, copy unwritten.
 * Selling registration to someone who does not need it is the failure mode
 * here. The "when you should not" callout is mandatory on this page.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do I actually need a RUC?',                'a_html' => ['{{ 60-90 words: the honest test, linking the RUC guide. }}']],
  ['q' => 'What happens after registration?',         'a_html' => ['{{ 60-90 words: the filing rhythm and who does it. }}']],
  ['q' => 'Do you do the monthly filings?',           'a_html' => ['{{ 60-90 words: what we do versus what a Paraguayan accountant does. }}']],
  ['q' => 'Can you cancel a RUC I no longer need?',   'a_html' => ['{{ 60-90 words }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Services · RUC',
 'intro' => '{{ 50-80 words: lede, opening with who does not need this. }}'],
['type' => 'quick-answer', 'eyebrow' => 'In one paragraph',
 'question' => 'What does RUC support consist of?',
 'answer_html' => ['{{ 60-90 words }}'],
 'points_html' => ['{{ deliverable 1 }}', '{{ deliverable 2 }}', '{{ deliverable 3 }}'],
 'caveat_html' => '{{ 30-50 words: registration creates obligations; we say so before, not after. }}'],
['type' => 'steps', 'eyebrow' => 'The engagement', 'heading' => 'What happens, in order',
 'intro_html' => ['{{ 40-60 words }}'],
 'items' => [
   ['title' => '{{ stage 1 — establishing whether you need one }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 2 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
   ['title' => '{{ stage 3 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 4 — the handover to ongoing compliance }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
 ]],
['type' => 'callout', 'label' => 'When you should not register',
 'body_html' => ['{{ 60-90 words: the readers who should walk away from this service. Mandatory paragraph. }}']],
['type' => 'faq', 'eyebrow' => 'Registration questions', 'heading' => 'Before you register.'],
['type' => 'related', 'items' => [['page' => 'guides.tax.ruc'], ['page' => 'guides.tax.vs-legal'], ['page' => 'packages']]],
['type' => 'next-step', 'heading' => 'Find out whether you need one at all',
 'body_html' => ['{{ 40-60 words }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'guides.tax.ruc', 'label' => 'The RUC explained'],
 'diy_html' => '{{ 30-50 words }}'],
],
];
