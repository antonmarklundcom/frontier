<?php
/**
 * Living in Paraguay. Structure complete, copy unwritten.
 * The only page on the site with no legal or tax content — it needs no
 * professional review, but it does need first-hand accuracy. Do not describe
 * anywhere the writer has not verified. No cost-of-living figures unless they
 * are sourced and dated.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do I need Spanish?',                         'a_html' => ['{{ 60-90 words: honestly, including where Guaraní matters. }}']],
  ['q' => 'What is healthcare actually like?',          'a_html' => ['{{ 60-90 words: public and private, and what a resident typically arranges. }}']],
  ['q' => 'Is it safe?',                                'a_html' => ['{{ 60-90 words: answer without either alarm or salesmanship; describe how people actually live. }}']],
  ['q' => 'Should I visit before committing?',          'a_html' => ['{{ 40-60 words: yes, and what to do on that visit. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Guides · Living',
 'intro' => '{{ 50-80 words: lede. Written for someone deciding whether to actually move, not for someone browsing. }}'],
['type' => 'quick-answer',
 'question' => 'What is it actually like to live in Paraguay?',
 'answer_html' => ['{{ 70-110 words: the honest summary, including what people find hardest. }}',
              '{{ 40-60 words: who tends to settle well and who does not. }}'],
 'points_html' => ['{{ point 1 }}', '{{ point 2 }}', '{{ point 3 }}'],
 'caveat_html' => '{{ 30-50 words: this is description, not a recommendation, and Asunción is not the whole country. }}'],
['type' => 'prose', 'eyebrow' => 'Practicalities', 'heading' => 'The things that decide whether a move works',
 'body_html' => ['{{ 40-60 words: intro. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'Housing',        'def_html' => '{{ 50-80 words: how renting works, what a foreigner is asked for }}'],
     ['term' => 'Healthcare',     'def_html' => '{{ 50-80 words }}'],
     ['term' => 'Schooling',      'def_html' => '{{ 50-80 words }}'],
     ['term' => 'Connectivity',   'def_html' => '{{ 50-80 words }}'],
     ['term' => 'Getting around', 'def_html' => '{{ 50-80 words }}'],
     ['term' => 'Climate',        'def_html' => '{{ 50-80 words: the summer is a real factor; say so }}'],
   ]]]],
['type' => 'prose', 'eyebrow' => 'Cost of living', 'heading' => 'What we will and will not tell you about cost',
 'body_html' => ['{{ 60-90 words: explain that we publish no cost-of-living figures unless sourced and dated, and point to what a reader can check themselves. If figures are used, cite and date every one. }}']],
['type' => 'callout', 'label' => 'Visit in January',
 'body_html' => ['{{ 50-80 words: the practical advice about seeing the place at its hardest before committing. }}']],
['type' => 'faq', 'eyebrow' => 'Living questions', 'heading' => 'What people ask before moving.'],
['type' => 'related', 'items' => [['page' => 'guides.residency'], ['page' => 'guides.banking'], ['page' => 'guides.tax']]],
['type' => 'next-step', 'heading' => 'If the move itself is the question',
 'body_html' => ['{{ 40-60 words: what a consultation can and cannot help with here — we do paperwork, not relocation coaching. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'guides.residency', 'label' => 'The residency guide'],
 'diy_html' => '{{ 30-50 words: nobody needs us to decide where to live — say it. }}'],
],
];
