<?php
/**
 * Services overview. Structure complete, copy unwritten.
 * The scope block on this page is not optional: the overview must state what we
 * do not do before it describes what we sell.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do I have to buy a package?',            'a' => ['{{ 60-90 words: the engagement shapes available, honestly described. }}']],
  ['q' => 'Are you lawyers?',                       'a' => ['{{ 60-90 words: no — say exactly what we are, and when we bring in a lawyer or accountant. }}']],
  ['q' => 'What if I only need one part of this?',  'a' => ['{{ 60-90 words: how partial engagements work. }}']],
  ['q' => 'What happens at the first consultation?', 'a' => ['{{ 60-90 words: the working session, and that it can end in "do not proceed". }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Services',
 'intro' => '{{ 50-80 words: lede. What we take on, in one paragraph, framed as execution and coordination rather than influence. }}'],
['type' => 'pathways', 'eyebrow' => 'What we do', 'heading' => 'Four engagements',
 'lede' => '{{ 30-50 words: how the four relate and which order they usually happen in. }}',
 'items' => [
   ['page' => 'services.residency', 'variant' => 'card--ink', 'kicker' => 'Most engagements start here',
    'title' => 'Residency application support', 'body' => '{{ 20-35 words }}', 'more' => 'What this covers'],
   ['page' => 'services.permanent-residency', 'variant' => 'card--hair', 'kicker' => 'Later',
    'title' => 'Permanent residency', 'body' => '{{ 20-35 words }}', 'more' => 'What this covers'],
   ['page' => 'services.ruc', 'variant' => 'card--hair', 'kicker' => 'Only if you need it',
    'title' => 'RUC and tax registration', 'body' => '{{ 20-35 words }}', 'more' => 'What this covers'],
   ['page' => 'services.banking', 'variant' => 'card--accent', 'kicker' => 'Preparation only',
    'title' => 'Banking preparation', 'body' => '{{ 20-35 words }}', 'more' => 'What this covers'],
 ]],
['type' => 'scope', 'eyebrow' => 'Scope', 'heading' => 'What we will and will not claim',
 'lede' => '{{ 40-60 words: the boundary statement for the whole business. }}',
 'yes_heading' => 'We do', 'no_heading' => 'We do not',
 'yes' => ['{{ line 1 }}', '{{ line 2 }}', '{{ line 3 }}', '{{ line 4 }}', '{{ line 5 }}'],
 'no'  => ['{{ line 1 }}', '{{ line 2 }}', '{{ line 3 }}', '{{ line 4 }}', '{{ line 5 }}'],
 'callout' => ['label' => 'Where we hand over', 'text' => '{{ 30-50 words: the point at which a lawyer or accountant takes the work, and why we say so rather than stretching. }}']],
['type' => 'faq', 'eyebrow' => 'Engagement questions', 'heading' => 'Before you enquire.'],
['type' => 'related', 'items' => [['page' => 'process'], ['page' => 'packages'], ['page' => 'integrity']]],
['type' => 'next-step', 'heading' => 'Start with a working session',
 'body' => ['{{ 40-60 words: what the paid consultation produces. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'process', 'label' => 'How working with us works'],
 'diy' => '{{ 30-50 words: who should not hire us. }}'],
],
];
