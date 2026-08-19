<?php
/**
 * How long Paraguay residency takes — Tier 1.
 * Structure complete, copy unwritten.
 *
 * HARD RULE for this page: it must own the "how long" query without publishing
 * a duration for any stage the government controls. Describe sequence, describe
 * what the reader can start today, describe what causes delay. The absence of a
 * headline number is the argument, not an omission.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Why will you not tell me how many months it takes?',
   'a_html' => ['{{ 60-90 words: because the review stage is not ours to predict and a published figure would be a guess presented as a commitment. Say what we give instead. }}']],
  ['q' => 'What can I start today?',
   'a_html' => ['{{ 60-90 words: the records that can be requested before any decision is made, and why starting them early costs nothing. }}']],
  ['q' => 'How long do I need to be in Paraguay?',
   'a_html' => ['{{ 60-90 words: which stages require presence and which do not. Be precise about what "present" means for each. }}']],
  ['q' => 'What causes most of the delay?',
   'a_html' => ['{{ 60-90 words: the honest ranking — applicant-side record gathering usually dominates, then authentication, then review. }}']],
],

'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Residency · Timeline',
 'intro' => '{{ 45-70 words: the lede. What this page gives instead of a number, and why that is the more useful thing to plan around. }}',
],

['type' => 'quick-answer',
 'question' => 'How long does Paraguayan residency take?',
 'answer_html' => [
   '{{ 60-90 words: answer the question honestly — the sequence has stages you control and stages you do not, and only the first kind can be planned. Do not give a total. }}',
   '{{ 40-60 words: what determines the part the reader controls, which is usually the majority of the elapsed time. }}',
 ],
 'points_html' => [
   '{{ one line: the stage that starts before any decision }}',
   '{{ one line: the stage that requires being in Paraguay }}',
   '{{ one line: the stage that is entirely the government\'s }}',
   '{{ one line: the stage after approval that people forget }}',
 ],
 'caveat_html' => '{{ 30-50 words: what would make any published estimate wrong for this reader — nationality, records, policy changes, caseload. }}',
],

['type' => 'steps',
 'eyebrow' => 'Sequence',
 'heading' => 'Stage by stage, and whose desk it is on',
 'intro_html' => ['{{ 40-60 words: how to read the sequence, and the note that stages overlap rather than queue neatly. }}'],
 'items' => [
   ['title' => '{{ stage 1 title — preparation, before committing }}',
    'body_html' => ['{{ 50-80 words: what happens, what the reader does }}'], 'who' => 'You',
    'blocker_html' => '{{ 20-35 words: the usual hold-up here }}'],
   ['title' => '{{ stage 2 title — obtaining and authenticating records }}',
    'body_html' => ['{{ 50-80 words }}'], 'who' => 'You',
    'blocker_html' => '{{ 20-35 words }}'],
   ['title' => '{{ stage 3 title — arrival and Paraguayan-side records }}',
    'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 4 title — filing }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 5 title — government review }}',
    'body_html' => ['{{ 50-80 words: describe what is happening and what "no news" means. No duration. }}'], 'who' => 'Government',
    'blocker_html' => '{{ 20-35 words: what can pause a file at this stage }}'],
   ['title' => '{{ stage 6 title — after approval }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
 ],
 'footnote_html' => '{{ 30-50 words: repeat, once, that we publish no total, and where a reader can get a schedule for their own dates. }}',
],

['type' => 'prose',
 'eyebrow' => 'Delay',
 'heading' => 'What actually causes the waiting',
 'body_html' => [
   '{{ 60-90 words: intro — most delay is not where readers expect it. }}',
   ['type' => 'defs', 'items' => [
     ['term' => '{{ cause 1 }}', 'def_html' => '{{ 40-70 words: how it arises and how to avoid it }}'],
     ['term' => '{{ cause 2 }}', 'def_html' => '{{ 40-70 words }}'],
     ['term' => '{{ cause 3 }}', 'def_html' => '{{ 40-70 words }}'],
     ['term' => '{{ cause 4 }}', 'def_html' => '{{ 40-70 words }}'],
   ]],
 ],
],

['type' => 'callout',
 'label' => 'Any timeline you have been quoted elsewhere',
 'body_html' => [
   '{{ 60-90 words: how to interrogate a quoted timeline — ask which stages it covers and what happens if it is missed. Attack the practice, not a named competitor. }}',
 ],
],

['type' => 'faq', 'eyebrow' => 'Timing questions', 'heading' => 'The questions behind "how long?"'],

['type' => 'sources',
 'intro_html' => ['{{ 25-40 words: what is sourced here, given that no duration is published. }}'],
 'items' => [
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Procedure and application stages',
    'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => 'Departamento de Identificaciones', 'authority' => 'Cédula issuance',
    'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => '{{ further primary source — delete if unused }}', 'authority' => '{{ issuing body }}',
    'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
 ],
],

['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],

['type' => 'related',
 'items' => [
   ['page' => 'guides.residency.documents'],
   ['page' => 'guides.residency.requirements'],
   ['page' => 'process'],
 ],
],

['type' => 'next-step',
 'heading' => 'A schedule built around your dates',
 'body_html' => ['{{ 40-60 words: what the consultation produces — the sequence applied to the reader\'s travel and records, with the uncontrolled stage left honestly open. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'process', 'label' => 'How working with us works'],
 'diy_html' => '{{ 30-50 words: who does not need us. }}',
],

],
];
