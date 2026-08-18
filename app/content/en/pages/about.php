<?php
/**
 * About. Structure complete, copy unwritten.
 *
 * BLOCKED on real people: the founder name, biography and a real team
 * photograph (docs/PRODUCTION-DATA-REQUIRED.md). Never generate a portrait for
 * a trust slot, and never write a founder story before there is a named person
 * to attach it to — Person schema stays suppressed until config carries a real
 * name, and this page stays a draft until the same is true.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Are you a law firm?',                 'a' => ['{{ 60-90 words: no. What we are, and who we bring in. }}']],
  ['q' => 'Where are you actually based?',       'a' => ['{{ 60-90 words: answer once the address is confirmed; be specific about in-country presence. }}']],
  ['q' => 'How long have you been doing this?',  'a' => ['{{ 60-90 words: a truthful answer, with no "years of experience" figure that cannot be evidenced. }}']],
  ['q' => 'Why is there no client list?',        'a' => ['{{ 60-90 words: confidentiality, and no testimonials that are not real and consented to. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'About',
 'intro' => '{{ 50-80 words: lede. Who runs this, from where, and why the site is written the way it is. }}'],
['type' => 'prose', 'eyebrow' => 'Who', 'heading' => 'The people doing the work',
 'body' => [
   '{{ 80-120 words: the founder, named. Real background only — no invented credentials, no "team of experts" where there is one person. }}',
   '{{ 60-90 words: who else is involved, including the lawyer and accountant relationships, described as relationships rather than staff. }}',
 ]],
['type' => 'prose', 'eyebrow' => 'Why', 'heading' => 'Why this site reads differently',
 'body' => [
   '{{ 80-120 words: the positioning stated as a belief rather than a boast — what the category does badly and what was done instead. }}',
   ['type' => 'list', 'items' => ['{{ commitment 1 }}', '{{ commitment 2 }}', '{{ commitment 3 }}', '{{ commitment 4 }}']],
 ]],
['type' => 'ribbon', 'eyebrow' => 'Standards', 'items' => [
   ['label' => '{{ standard 1 label }}', 'text' => '{{ 15-30 words: a verifiable policy, never a statistic }}'],
   ['label' => '{{ standard 2 label }}', 'text' => '{{ 15-30 words }}'],
   ['label' => '{{ standard 3 label }}', 'text' => '{{ 15-30 words }}'],
   ['label' => '{{ standard 4 label }}', 'text' => '{{ 15-30 words }}'],
 ]],
['type' => 'faq', 'eyebrow' => 'About us', 'heading' => 'Fair questions.'],
['type' => 'related', 'items' => [['page' => 'integrity'], ['page' => 'editorial-standards'], ['page' => 'process']]],
['type' => 'next-step', 'heading' => 'Judge us on a working session',
 'body' => ['{{ 40-60 words }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services', 'label' => 'What we do'],
],

],
];
