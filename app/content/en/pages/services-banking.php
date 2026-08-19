<?php
/**
 * Banking preparation support. Structure complete, copy unwritten.
 * HARD RULE: this page sells preparation and introduction. It must never imply
 * an account can be obtained, arranged, or made likely by hiring us.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Can you get me an account?',              'a_html' => ['{{ 60-90 words: no. What we do instead, in concrete terms. }}']],
  ['q' => 'Which banks do you work with?',           'a_html' => ['{{ 60-90 words: describe the relationship honestly; disclose any referral arrangement. }}']],
  ['q' => 'What if I am declined?',                  'a_html' => ['{{ 60-90 words: what happens next and what our fee covered. }}']],
  ['q' => 'Do I need residency first?',              'a_html' => ['{{ 60-90 words }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Services · Banking',
 'intro' => '{{ 50-80 words: lede, opening with the limit rather than the offer. }}'],
['type' => 'quick-answer', 'eyebrow' => 'In one paragraph',
 'question' => 'What does banking preparation consist of?',
 'answer_html' => ['{{ 60-90 words: file preparation, document assembly, introduction, and accompanying you. Nothing about outcomes. }}'],
 'points_html' => ['{{ deliverable 1 }}', '{{ deliverable 2 }}', '{{ deliverable 3 }}'],
 'caveat_html' => '{{ 30-50 words: the bank decides, well-prepared applications are declined, and our fee is for the preparation. }}'],
['type' => 'scope', 'eyebrow' => 'Scope', 'heading' => 'Preparation, not access',
 'lede' => '{{ 40-60 words }}', 'yes_heading' => 'We do', 'no_heading' => 'We cannot',
 'yes' => ['{{ line }}', '{{ line }}', '{{ line }}'], 'no' => ['{{ line }}', '{{ line }}', '{{ line }}'],
 'callout' => ['label' => 'Fees and outcomes', 'text' => '{{ 30-50 words: what the fee buys, stated so that a decline is not a surprise about what was paid for. }}']],
['type' => 'callout', 'label' => 'Anyone promising you an account',
 'body_html' => ['{{ 60-90 words: what such a promise really means, and why we do not make it. }}']],
['type' => 'faq', 'eyebrow' => 'Banking questions', 'heading' => 'Asked before every introduction.'],
['type' => 'related', 'items' => [['page' => 'guides.banking'], ['page' => 'guides.tax.ruc'], ['page' => 'integrity']]],
['type' => 'next-step', 'heading' => 'Have your file assessed honestly first',
 'body_html' => ['{{ 40-60 words: including that we will say when a file is not ready to present. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'guides.banking', 'label' => 'Banking as a foreign resident'],
],

],
];
