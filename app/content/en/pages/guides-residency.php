<?php
/**
 * Residency hub. Structure complete, copy unwritten.
 * A hub earns its place by routing, not by repeating its children. Write the
 * landscape and the decision points; leave the detail to the pages beneath it.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Where should I start?',                       'a' => ['{{ 60-90 words: route the reader by situation, linking the right child guide. }}']],
  ['q' => 'Can I do this without a lawyer or an agent?', 'a' => ['{{ 60-90 words: honestly — who can, who should not, and what the failure modes are. }}']],
  ['q' => 'Is Paraguay a good idea for me at all?',      'a' => ['{{ 60-90 words: the cases where the answer is no, stated first. }}']],
  ['q' => 'How current is this guidance?',               'a' => ['{{ 40-60 words: dating and review policy, linking editorial standards. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Guides · Residency',
 'intro' => '{{ 50-80 words: lede for the whole cluster. What Paraguayan residency is, what it is not, and how to use the pages below. }}'],
['type' => 'quick-answer',
 'question' => 'How does Paraguayan residency work?',
 'answer' => ['{{ 70-110 words: the landscape in one paragraph — routes, sequence, who decides. }}',
              '{{ 40-60 words: the two or three decisions a reader has to make before anything else. }}'],
 'points' => ['{{ decision 1 }}', '{{ decision 2 }}', '{{ decision 3 }}'],
 'caveat' => '{{ 30-50 words: what varies by nationality and personal history. }}'],
['type' => 'knowledge', 'eyebrow' => 'The cluster', 'heading' => 'Start with the question you actually have',
 'lede' => '{{ 30-50 words: how the pages below are ordered and which to read first. }}',
 'cta' => ['page' => 'guides.residency.documents', 'label' => 'Start with documents'],
 'items' => [
   ['page' => 'guides.residency.requirements',           'title' => 'Requirements', 'body' => '{{ 12-22 words: what this page answers }}'],
   ['page' => 'guides.residency.documents',              'title' => 'Documents and apostilles', 'body' => '{{ 12-22 words }}'],
   ['page' => 'guides.residency.timeline',               'title' => 'Timeline', 'body' => '{{ 12-22 words }}'],
   ['page' => 'guides.residency.costs',                  'title' => 'Costs', 'body' => '{{ 12-22 words }}'],
   ['page' => 'guides.residency.temporary-vs-permanent', 'title' => 'Temporary vs permanent', 'body' => '{{ 12-22 words }}'],
   ['page' => 'guides.residency.maintaining',            'title' => 'Maintaining residency', 'body' => '{{ 12-22 words }}'],
 ]],
['type' => 'prose', 'eyebrow' => 'Reality check', 'heading' => 'What residency does and does not change',
 'body' => ['{{ 60-90 words: intro. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'What it changes', 'def' => '{{ 50-80 words }}'],
     ['term' => 'What it does not change', 'def' => '{{ 50-80 words: tax at home, banking access, obligations elsewhere }}'],
     ['term' => 'What it commits you to', 'def' => '{{ 50-80 words }}'],
   ]]]],
['type' => 'callout', 'label' => 'If you are reading this because of a video',
 'body' => ['{{ 60-90 words: the gap between the pitch and the paperwork, written without contempt for the reader. }}']],
['type' => 'faq', 'eyebrow' => 'Starting out', 'heading' => 'First questions.'],
['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.tax'], ['page' => 'guides.banking'], ['page' => 'guides.living']]],
['type' => 'next-step', 'heading' => 'When reading has taken you as far as it can',
 'body' => ['{{ 40-60 words: what a consultation adds beyond this cluster. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services', 'label' => 'What we do'],
 'diy' => '{{ 30-50 words: the honest note that several of these guides end in "you may not need us". }}'],
],
];
