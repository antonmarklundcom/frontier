<?php
/**
 * The RUC explained. Structure complete, copy unwritten.
 * The commercial temptation on this page is to present registration as a
 * benefit. It is an obligation with a filing rhythm attached; write it that way.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do I need a RUC at all?',                'a_html' => ['{{ 60-90 words: who must register, who chooses to, who should not bother. }}']],
  ['q' => 'What does registration commit me to?',   'a_html' => ['{{ 60-90 words: the filing obligations that begin immediately, including nil filings if that is the case. }}']],
  ['q' => 'What happens if I stop filing?',         'a_html' => ['{{ 60-90 words: the consequences, plainly, including any effect on residency or banking. }}']],
  ['q' => 'Can I cancel a RUC?',                    'a_html' => ['{{ 60-90 words: the de-registration route and what it requires. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Tax · RUC',
 'intro' => '{{ 45-70 words: lede. What the number is, who needs it, and the obligation that starts the day it is issued. }}'],
['type' => 'quick-answer',
 'question' => 'What is a RUC, and do you need one?',
 'answer_html' => ['{{ 60-90 words: the direct answer. }}', '{{ 40-60 words: the obligation framing — this is a registration, not a status upgrade. }}'],
 'points_html' => ['{{ who must register }}', '{{ what it enables }}', '{{ what it obliges }}', '{{ what it does not do }}'],
 'caveat_html' => '{{ 30-50 words: activity, residency status and income source all change the answer. }}'],
['type' => 'definition', 'eyebrow' => 'The term', 'term' => 'RUC',
 'spanish' => 'Registro Único de Contribuyentes',
 'body_html' => ['{{ 70-110 words: what the number identifies and which authority maintains it. }}'],
 'not_html' => ['{{ it is not proof of tax residency }}', '{{ it is not a residency document }}', '{{ it is not a bank requirement in itself — unless it is; verify before asserting either way }}']],
['type' => 'steps', 'eyebrow' => 'Registration', 'heading' => 'How registration actually goes',
 'intro_html' => ['{{ 40-60 words: prerequisites before anyone can start. }}'],
 'items' => [
   ['title' => '{{ stage 1 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You', 'blocker_html' => '{{ 20-35 words }}'],
   ['title' => '{{ stage 2 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 3 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Government'],
   ['title' => '{{ stage 4 — the first filing obligation }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
 ],
 'footnote_html' => '{{ 25-40 words: no duration for the stage we do not control. }}'],
['type' => 'callout', 'label' => 'Registering because someone told you to',
 'body_html' => ['{{ 60-90 words: the readers who register with no need and inherit a filing obligation for years. Name the situations. }}']],
['type' => 'faq', 'eyebrow' => 'RUC questions', 'heading' => 'Before you register.'],
['type' => 'sources', 'intro_html' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => 'Dirección Nacional de Ingresos Tributarios (DNIT)', 'authority' => 'RUC registration and filing', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => '{{ the governing resolution, by number }}', 'authority' => 'Paraguayan law', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'tax_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.tax.vs-legal'], ['page' => 'guides.tax.territorial'], ['page' => 'services.ruc']]],
['type' => 'next-step', 'heading' => 'Registration, and the year after it',
 'body_html' => ['{{ 40-60 words: what our support covers and where an accountant takes over the recurring filings. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.ruc', 'label' => 'RUC and tax registration support'],
 'diy_html' => '{{ 30-50 words: who does not need us. }}'],
],
];
