<?php
/**
 * Site-wide FAQ. Structure complete, copy unwritten.
 * Rule: this page answers, then routes. Every answer that has a guide behind it
 * should end by linking that guide rather than duplicating it. Questions are
 * grouped so the page stays usable as it grows.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Can I get Paraguayan residency without living there?',   'a_html' => ['{{ 60-90 words, then link the residency guide }}']],
  ['q' => 'How long does it take?',                                  'a_html' => ['{{ 60-90 words: the no-estimate policy, stated as a policy }}']],
  ['q' => 'What does it cost?',                                      'a_html' => ['{{ 60-90 words: categories, then link the costs guide }}']],
  ['q' => 'Will I stop paying tax at home?',                         'a_html' => ['{{ 60-90 words: no general answer, then link tax vs legal residency }}']],
  ['q' => 'Do I need a RUC?',                                        'a_html' => ['{{ 60-90 words }}']],
  ['q' => 'Can you get me a bank account?',                          'a_html' => ['{{ 60-90 words: no, and what we do instead }}']],
  ['q' => 'Do I need to speak Spanish?',                             'a_html' => ['{{ 60-90 words }}']],
  ['q' => 'Can my family come with me?',                             'a_html' => ['{{ 60-90 words }}']],
  ['q' => 'What if I have a criminal record?',                       'a_html' => ['{{ 60-90 words: disclosure over concealment }}']],
  ['q' => 'Is any of this legal advice?',                            'a_html' => ['{{ 40-60 words: no, and where the line is }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'FAQ',
 'intro' => '{{ 45-70 words: lede. Short answers here, the full reasoning in the guides. }}'],
['type' => 'faq', 'eyebrow' => 'Everything, briefly', 'heading' => 'The questions we are actually asked.'],
['type' => 'callout', 'label' => 'If your question is not here',
 'body_html' => ['{{ 40-60 words: how to ask, and the promise that questions asked often enough become guides. }}']],
['type' => 'related', 'items' => [['page' => 'guides.residency'], ['page' => 'guides.tax'], ['page' => 'guides.banking']]],
['type' => 'next-step', 'heading' => 'A question about your own situation',
 'body_html' => ['{{ 40-60 words }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'editorial-standards', 'label' => 'How these answers are researched'],
],

],
];
