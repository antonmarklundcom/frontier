<?php
/**
 * Paraguay residency requirements. Structure complete, copy unwritten.
 * House rules: see guides-residency-documents.php.
 * This page describes eligibility conditions. It must never let a reader
 * conclude that meeting them means being approved — that distinction is the
 * spine of the page, not a disclaimer at the bottom.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do I need to prove income or savings?',      'a_html' => ['{{ 60-90 words: the current position, cited. If the answer differs by route, split it. }}']],
  ['q' => 'Does a criminal record disqualify me?',      'a_html' => ['{{ 60-90 words: honest answer about discretion, and why disclosure beats concealment. }}']],
  ['q' => 'Can my family apply with me?',               'a_html' => ['{{ 60-90 words: dependants, spouses, and the extra records each adds. }}']],
  ['q' => 'I meet everything on this page. Am I approved?', 'a_html' => ['{{ 60-90 words: no — eligibility is not approval, and here is what a reviewing officer still weighs. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Residency · Requirements',
 'intro' => '{{ 45-70 words: lede. What the government asks for, by applicant profile, and the gap between qualifying and being granted. }}'],
['type' => 'quick-answer',
 'question' => 'What does Paraguay actually require of a residency applicant?',
 'answer_html' => ['{{ 60-90 words: the direct answer — the conditions in plain English. }}',
              '{{ 40-60 words: the difference between the published conditions and the discretionary decision. }}'],
 'points_html' => ['{{ condition 1 }}', '{{ condition 2 }}', '{{ condition 3 }}', '{{ condition 4 }}'],
 'caveat_html' => '{{ 30-50 words: nationality, route and personal history all move this. }}'],
['type' => 'prose', 'eyebrow' => 'By profile', 'heading' => 'How the answer changes with who you are',
 'body_html' => ['{{ 40-60 words: intro. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'Employed or self-employed abroad', 'def_html' => '{{ 40-70 words }}'],
     ['term' => 'Retired, living on a pension',     'def_html' => '{{ 40-70 words }}'],
     ['term' => 'Married to a Paraguayan citizen or resident', 'def_html' => '{{ 40-70 words }}'],
     ['term' => 'Applying with children',           'def_html' => '{{ 40-70 words }}'],
     ['term' => 'Investing or forming a company',   'def_html' => '{{ 40-70 words }}'],
   ]]]],
['type' => 'checklist', 'eyebrow' => 'Eligibility', 'heading' => 'What you have to be able to show',
 'intro_html' => ['{{ 40-60 words: how to use this — a self-check before spending money on records. }}'],
 'groups' => [
   ['title' => 'Conditions of the person', 'note_html' => '{{ 25-40 words }}', 'items' => [
     ['item_html' => '{{ condition }}', 'note_html' => '{{ 25-45 words: what satisfies it and what does not }}', 'who' => 'You'],
     ['item_html' => '{{ condition }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ condition }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
   ]],
   ['title' => 'Conditions evidenced by documents', 'note_html' => '{{ 25-40 words: cross-reference the documents guide rather than repeating it. }}', 'items' => [
     ['item_html' => '{{ condition }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ condition }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'You'],
     ['item_html' => '{{ condition }}', 'note_html' => '{{ 25-45 words }}', 'who' => 'Us'],
   ]],
 ],
 'footnote_html' => '{{ 30-50 words: dated, changes, report an error. }}'],
['type' => 'callout', 'label' => 'Eligible is not approved',
 'body_html' => ['{{ 60-90 words: what discretion means in practice and what most improves how a file is read. }}']],
['type' => 'faq', 'eyebrow' => 'Eligibility questions', 'heading' => 'Before you spend anything.'],
['type' => 'sources', 'intro_html' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Published requirements', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => '{{ the migration law or decree, by number }}', 'authority' => 'Paraguayan law', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.residency.documents'], ['page' => 'guides.residency.temporary-vs-permanent'], ['page' => 'guides.residency.timeline']]],
['type' => 'next-step', 'heading' => 'A read on your own eligibility',
 'body_html' => ['{{ 40-60 words: what an assessment covers, including being told when the answer is no. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.residency', 'label' => 'Residency application support'],
 'diy_html' => '{{ 30-50 words: who does not need us. }}'],
],
];
