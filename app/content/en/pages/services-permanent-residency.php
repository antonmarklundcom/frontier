<?php
/**
 * Permanent residency conversion support. Structure complete, copy unwritten.
 * Mirrors services-residency.php; keep the two consistent in shape so a reader
 * comparing them is comparing content rather than layout.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'When can the conversion be started?',        'a_html' => ['{{ 60-90 words: the conditions, cited to the residency guide. }}']],
  ['q' => 'What if my temporary status has lapsed?',    'a_html' => ['{{ 60-90 words: what can be repaired and what cannot. }}']],
  ['q' => 'Do I need to be in the country?',            'a_html' => ['{{ 60-90 words }}']],
  ['q' => 'Can you take this on if someone else filed the original?', 'a_html' => ['{{ 60-90 words: yes/no and what we would need. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Services · Permanent residency',
 'intro' => '{{ 50-80 words: lede. Who this is for — someone already holding temporary status. }}'],
['type' => 'quick-answer', 'eyebrow' => 'In one paragraph',
 'question' => 'What does conversion support consist of?',
 'answer_html' => ['{{ 60-90 words }}'],
 'points_html' => ['{{ deliverable 1 }}', '{{ deliverable 2 }}', '{{ deliverable 3 }}'],
 'caveat_html' => '{{ 30-50 words: eligibility, records and the government\'s decision. }}'],
['type' => 'steps', 'eyebrow' => 'The engagement', 'heading' => 'What happens, in order',
 'intro_html' => ['{{ 40-60 words }}'],
 'items' => [
   ['title' => '{{ stage 1 — reviewing the existing file }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 2 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
   ['title' => '{{ stage 3 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 4 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Government'],
 ],
 'footnote_html' => '{{ 25-40 words: no duration for the review stage. }}'],
['type' => 'scope', 'eyebrow' => 'Scope', 'heading' => 'Included, and deliberately not included',
 'lede' => '{{ 40-60 words }}', 'yes_heading' => 'Included', 'no_heading' => 'Not included',
 'yes' => ['{{ line }}', '{{ line }}', '{{ line }}'], 'no' => ['{{ line }}', '{{ line }}', '{{ line }}'],
 'callout' => ['label' => 'If your standing has slipped', 'text' => '{{ 30-50 words: what we assess before agreeing to take it on. }}']],
['type' => 'faq', 'eyebrow' => 'Conversion questions', 'heading' => 'Before converting.'],
['type' => 'related', 'items' => [['page' => 'guides.residency.temporary-vs-permanent'], ['page' => 'guides.residency.maintaining'], ['page' => 'packages']]],
['type' => 'next-step', 'heading' => 'Have your current status looked at first',
 'body_html' => ['{{ 40-60 words }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'process', 'label' => 'How working with us works'],
],

],
];
