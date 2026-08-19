<?php
/**
 * How working with us works. Structure complete, copy unwritten.
 * This page is reassurance through specificity: what happens, who does it, and
 * what "no news" means. No durations for stages we do not control.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'How often will I hear from you?',        'a_html' => ['{{ 60-90 words: the actual communication commitment, including that "no movement" is itself an update. }}']],
  ['q' => 'Who will I be dealing with?',            'a_html' => ['{{ 60-90 words: answer once real names exist; keep it honest about team size. }}']],
  ['q' => 'What do you need from me, and when?',    'a_html' => ['{{ 60-90 words }}']],
  ['q' => 'What if I need to pause?',               'a_html' => ['{{ 60-90 words: what pausing does to records that expire. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'How it works',
 'intro' => '{{ 50-80 words: lede. The engagement described end to end, and the promise that you are told where the file actually is. }}'],
['type' => 'journey', 'eyebrow' => 'The engagement', 'heading' => 'Six stages, four of them ours',
 'lede' => '{{ 30-50 words: which stages we own and which belong to the government or to you. }}',
 'steps' => [
   ['who' => '{{ You / Us / Government }}', 'title' => '{{ stage 1 title }}', 'note' => '{{ 15-30 words }}'],
   ['who' => '{{ owner }}', 'title' => '{{ stage 2 title }}', 'note' => '{{ 15-30 words }}'],
   ['who' => '{{ owner }}', 'title' => '{{ stage 3 title }}', 'note' => '{{ 15-30 words }}'],
   ['who' => '{{ owner }}', 'title' => '{{ stage 4 title }}', 'note' => '{{ 15-30 words }}'],
   ['who' => '{{ owner }}', 'title' => '{{ stage 5 title }}', 'note' => '{{ 15-30 words }}'],
   ['who' => '{{ owner }}', 'title' => '{{ stage 6 title }}', 'note' => '{{ 15-30 words }}'],
 ]],
['type' => 'prose', 'eyebrow' => 'Working together', 'heading' => 'What we expect from each other',
 'body_html' => ['{{ 40-60 words: intro. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'What you can expect from us', 'def_html' => '{{ 50-80 words: response times we can actually keep, honest status, no invented progress }}'],
     ['term' => 'What we need from you',       'def_html' => '{{ 50-80 words: disclosure, records, responsiveness }}'],
     ['term' => 'How we handle bad news',      'def_html' => '{{ 50-80 words: told early, in writing, with options }}'],
   ]]]],
['type' => 'callout', 'label' => '"No movement" is an update',
 'body_html' => ['{{ 60-90 words: the commitment to say when nothing has happened, instead of manufacturing progress. }}']],
['type' => 'faq', 'eyebrow' => 'Working with us', 'heading' => 'Practical questions.'],
['type' => 'related', 'items' => [['page' => 'services'], ['page' => 'packages'], ['page' => 'integrity']]],
['type' => 'next-step', 'heading' => 'The first stage is a paid working session',
 'body_html' => ['{{ 40-60 words }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'integrity', 'label' => 'Our integrity promise'],
],

],
];
