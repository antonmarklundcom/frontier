<?php
/**
 * Citizenship hub. Structure complete, copy unwritten.
 * Naturalisation is discretionary and judicial. The page must not read as a
 * countdown to a second passport, and must not mention visa-free travel counts.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'How many years before I can apply?',        'a_html' => ['{{ 60-90 words: the statutory position, cited, plus why eligibility to apply is not the same as being naturalised. }}']],
  ['q' => 'Is naturalisation automatic once eligible?', 'a_html' => ['{{ 60-90 words: no — a judicial process with discretion. Describe what it involves. }}']],
  ['q' => 'Do I have to give up my current citizenship?', 'a_html' => ['{{ 60-90 words: the Paraguayan position and the reminder that the reader\'s own country decides its own. }}']],
  ['q' => 'Does time outside Paraguay count?',          'a_html' => ['{{ 60-90 words: how presence is assessed. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Guides · Citizenship',
 'intro' => '{{ 50-80 words: lede. Set the horizon honestly — years, discretion, and a court. }}'],
['type' => 'quick-answer',
 'question' => 'Can residency lead to Paraguayan citizenship?',
 'answer_html' => ['{{ 70-110 words: the direct answer with the discretionary nature stated in the first two sentences. }}',
              '{{ 40-60 words: what a reader should do now if this is their long-term goal. }}'],
 'points_html' => ['{{ point 1 }}', '{{ point 2 }}', '{{ point 3 }}'],
 'caveat_html' => '{{ 30-50 words: nothing here predicts an outcome, and law can change over a horizon this long. }}'],
['type' => 'steps', 'eyebrow' => 'The route', 'heading' => 'What the process involves',
 'intro_html' => ['{{ 40-60 words: the shape of it, from residency to a judicial decision. }}'],
 'items' => [
   ['title' => '{{ stage 1 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
   ['title' => '{{ stage 2 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'You'],
   ['title' => '{{ stage 3 }}', 'body_html' => ['{{ 50-80 words }}'], 'who' => 'Government'],
 ],
 'footnote_html' => '{{ 25-40 words: no duration for a judicial stage. }}'],
['type' => 'callout', 'label' => 'What we do not sell',
 'body_html' => ['{{ 60-90 words: state plainly that we do not offer a citizenship product, do not promise outcomes, and do not deal in passport marketing. }}']],
['type' => 'faq', 'eyebrow' => 'Citizenship questions', 'heading' => 'The long horizon.'],
['type' => 'sources', 'intro_html' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => '{{ the constitutional and statutory provisions, by number }}', 'authority' => 'Paraguayan law', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
   ['name' => '{{ the court or authority that decides naturalisation }}', 'authority' => 'Decision-making body', 'url' => '{{ exact URL used }}', 'note_html' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.residency.maintaining'], ['page' => 'guides.residency.temporary-vs-permanent'], ['page' => 'integrity']]],
['type' => 'next-step', 'heading' => 'Planning for a decade, not a purchase',
 'body_html' => ['{{ 40-60 words: what a consultation covers for someone with this horizon — mostly, keeping the residency clean. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'guides.residency.maintaining', 'label' => 'Keeping residency in good standing'],
 'diy_html' => '{{ 30-50 words: most of this is waiting and record-keeping the reader can do alone. }}'],
],
];
