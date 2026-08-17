<?php
/**
 * Terms of use. Structure complete, copy unwritten.
 *
 * BLOCKED on a lawyer. These are terms for using the website, not the service
 * agreement — the service agreement is a separate signed document and this page
 * must not pretend to be it. The general-information disclaimer that appears in
 * the site footer is defined here and must not contradict it.
 */
declare(strict_types=1);

return [
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Legal',
 'intro' => '{{ 40-60 words: what these terms cover and what they do not — specifically, that engagement terms live in a signed agreement. }}'],
['type' => 'prose', 'eyebrow' => 'Using this site', 'heading' => 'The general-information disclaimer',
 'body' => ['{{ 80-120 words: the disclaimer in full, consistent with the footer wording in app/content/en/global.php. If the wording changes here, change it there too. }}']],
['type' => 'prose', 'eyebrow' => 'Detail', 'heading' => 'Terms in full',
 'body' => ['{{ 40-60 words: intro. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'No advice relationship',      'def' => '{{ 50-80 words }}'],
     ['term' => 'Accuracy and dating',         'def' => '{{ 50-80 words: consistent with the editorial standards page }}'],
     ['term' => 'Links to other sites',        'def' => '{{ 40-70 words }}'],
     ['term' => 'Intellectual property',       'def' => '{{ 40-70 words }}'],
     ['term' => 'Limitation of liability',     'def' => '{{ 50-80 words: drafted by the lawyer, not adapted from a template }}'],
     ['term' => 'Governing law',               'def' => '{{ 40-70 words }}'],
   ]]]],
['type' => 'callout', 'label' => 'This page is not your service agreement',
 'body' => ['{{ 40-70 words: the distinction, stated plainly, including which document governs the work itself. }}']],
['type' => 'related', 'items' => [['page' => 'privacy'], ['page' => 'integrity'], ['page' => 'editorial-standards']]],

],
];
