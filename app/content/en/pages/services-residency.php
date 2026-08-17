<?php
/**
 * Residency application support. Structure complete, copy unwritten.
 * A service page here sells the work, not the outcome. No approval language,
 * no timelines, no prices — prices live on /packages/ once they exist.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'What exactly do you do that I could not?',  'a' => ['{{ 60-90 words: the concrete work — sequencing, authentication coordination, in-country appearances, file assembly. }}']],
  ['q' => 'Do I have to travel to Paraguay?',          'a' => ['{{ 60-90 words: which stages require presence. }}']],
  ['q' => 'What do you need from me?',                 'a' => ['{{ 60-90 words: records, disclosure, responsiveness — and why the awkward facts matter most. }}']],
  ['q' => 'What if my application is refused?',        'a' => ['{{ 60-90 words: what happens next, and what our agreement says about it. No remedy promise beyond the signed agreement. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Services · Residency',
 'intro' => '{{ 50-80 words: lede. Who this is for and what it consists of. }}'],
['type' => 'quick-answer',
 'eyebrow' => 'In one paragraph',
 'question' => 'What does residency support actually consist of?',
 'answer' => ['{{ 60-90 words: the work itself, in the order it happens. }}'],
 'points' => ['{{ deliverable 1 }}', '{{ deliverable 2 }}', '{{ deliverable 3 }}', '{{ deliverable 4 }}'],
 'caveat' => '{{ 30-50 words: what is excluded, and that approval is the government\'s decision. }}'],
['type' => 'steps', 'eyebrow' => 'The engagement', 'heading' => 'What happens, in order',
 'intro' => ['{{ 40-60 words: from consultation to cédula, with ownership marked at each stage. }}'],
 'items' => [
   ['title' => '{{ stage 1 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 2 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'You'],
   ['title' => '{{ stage 3 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 4 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Government'],
   ['title' => '{{ stage 5 }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Us'],
 ],
 'footnote' => '{{ 25-40 words: no total duration, and why. }}'],
['type' => 'scope', 'eyebrow' => 'Scope', 'heading' => 'Included, and deliberately not included',
 'lede' => '{{ 40-60 words }}', 'yes_heading' => 'Included', 'no_heading' => 'Not included',
 'yes' => ['{{ line }}', '{{ line }}', '{{ line }}', '{{ line }}'],
 'no'  => ['{{ line }}', '{{ line }}', '{{ line }}', '{{ line }}'],
 'callout' => ['label' => 'Third-party costs', 'text' => '{{ 30-50 words: government fees, translation and authentication are paid to those parties and not marked up. }}']],
['type' => 'callout', 'label' => 'When you should not hire us for this',
 'body' => ['{{ 60-90 words: the situations where a reader is better served doing it alone or going straight to a lawyer. This paragraph is required. }}']],
['type' => 'faq', 'eyebrow' => 'Service questions', 'heading' => 'What clients ask first.'],
['type' => 'related', 'items' => [['page' => 'guides.residency.documents'], ['page' => 'packages'], ['page' => 'process']]],
['type' => 'next-step', 'heading' => 'A working session before any engagement',
 'body' => ['{{ 40-60 words: we do not take an engagement without one; say why. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'integrity', 'label' => 'What we control, and what we do not'],
],

],
];
