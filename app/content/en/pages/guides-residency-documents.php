<?php
/**
 * Documents and authentication — Tier 1.
 *
 * STRUCTURE COMPLETE, COPY UNWRITTEN. Every {{ ... }} is a brief for the
 * writing pass; replacing the whole string with real prose is the only edit
 * needed. While any brief remains the page is a draft: noindex, absent from the
 * sitemap, and shown to visitors as the "in preparation" notice.
 *
 * House rules for whoever writes this page:
 *  - No processing-time figures, no prices, no approval rates, no testimonials.
 *  - Every factual claim must trace to a source listed in the sources block.
 *  - Where the honest answer is "it depends on your nationality", say that and
 *    say what it depends on, rather than picking the common case silently.
 *  - British spelling. Second person. Short sentences. No exclamation marks.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Does every document need an apostille?',
   'a' => ['{{ 60-90 words: answer directly, then name the exception class (documents issued inside Paraguay, and countries not party to the Hague Convention, which use consular legalisation instead). }}']],
  ['q' => 'How long does an apostille stay valid?',
   'a' => ['{{ 60-90 words: distinguish the apostille itself from the validity window Migraciones applies to the underlying record. This distinction is the single most common misunderstanding on this page — make it unmissable. }}']],
  ['q' => 'Can I get documents translated in my own country?',
   'a' => ['{{ 60-90 words: explain the sworn-translator requirement and who is accepted. State plainly whether a translation done abroad is usable. }}']],
  ['q' => 'What happens if a document is rejected?',
   'a' => ['{{ 60-90 words: what re-submission actually involves, what has to be re-obtained versus re-authenticated, and why ordering records in the right sequence prevents most of it. No time estimate. }}']],
],

'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Residency · Documents',
 'intro' => '{{ 45-70 words: the lede. Who this page is for (someone assembling records before travelling), what it covers, and the promise that the order of operations matters more than the list itself. }}',
],

['type' => 'quick-answer',
 'question' => 'Which documents does a Paraguayan residency application need, and which of them have to be authenticated?',
 'answer' => [
   '{{ 60-90 words: the direct answer in two or three sentences. Name the two families of record — those issued by your own country and those obtained in Paraguay — and state the general authentication rule for each. }}',
   '{{ 40-60 words: the second paragraph states the thing most readers get wrong: the sequence, because several records expire while others are still being obtained. }}',
 ],
 'points' => [
   '{{ one line: the record class that takes longest to obtain and should be started first }}',
   '{{ one line: which records must be apostilled or legalised before leaving your country }}',
   '{{ one line: what must be translated, and by whom }}',
   '{{ one line: what can only be done inside Paraguay }}',
 ],
 'caveat' => '{{ 30-50 words: the conditions under which this general answer does not hold — nationality, document age, applicants with prior immigration history, and any record issued by a state not party to the Hague Convention. }}',
],

['type' => 'definition',
 'eyebrow' => 'The term everyone gets wrong',
 'term' => 'An apostille',
 'spanish' => 'apostilla',
 'body' => [
   '{{ 70-110 words: what an apostille certifies (the authenticity of the signature and seal on a public document), which authority issues it in the reader\'s own country, and what it does not certify. }}',
 ],
 'not' => [
   '{{ what an apostille is not — misconception 1, e.g. a translation }}',
   '{{ misconception 2, e.g. a validity extension }}',
   '{{ misconception 3, e.g. proof the underlying record is accepted in Paraguay }}',
 ],
],

['type' => 'checklist',
 'eyebrow' => 'Preparation',
 'heading' => 'The document checklist',
 'intro' => [
   '{{ 40-60 words: how to use this list — that it is a preparation aid rather than an official list, that Migraciones publishes the authoritative requirements, and that the reader should check the date at the foot of the page. }}',
 ],
 'groups' => [
   ['title' => 'Obtained in your own country, before you travel',
    'note'  => '{{ 25-40 words: why these come first and what happens if they are obtained in the wrong order. }}',
    'items' => [
      ['item' => '{{ record 1 — name it as Migraciones names it, with the English equivalent in brackets }}',
       'note' => '{{ 25-45 words: where it is issued, what it must show, the most common reason this one is rejected }}',
       'who' => 'You', 'validity' => '{{ validity window, or "no stated limit" }}'],
      ['item' => '{{ record 2 }}', 'note' => '{{ 25-45 words: as above }}', 'who' => 'You', 'validity' => '{{ validity window }}'],
      ['item' => '{{ record 3 }}', 'note' => '{{ 25-45 words: as above }}', 'who' => 'You', 'validity' => '{{ validity window }}'],
      ['item' => '{{ record 4 — include only if genuinely required; delete this row rather than pad the list }}',
       'note' => '{{ 25-45 words: as above }}', 'who' => 'You', 'validity' => '{{ validity window }}'],
    ]],
   ['title' => 'Authentication of those records',
    'note'  => '{{ 25-40 words: the apostille-versus-consular-legalisation fork, stated once, plainly. }}',
    'items' => [
      ['item' => '{{ authentication step for Hague Convention countries }}',
       'note' => '{{ 25-45 words: which national authority does this, and what the reader physically ends up holding }}', 'who' => 'You'],
      ['item' => '{{ authentication route for non-Hague countries }}',
       'note' => '{{ 25-45 words: the consular chain, described honestly as slower }}', 'who' => 'You'],
      ['item' => '{{ sworn translation requirement }}',
       'note' => '{{ 25-45 words: who is permitted to produce it and whether it happens before or after arrival }}', 'who' => 'Us'],
    ]],
   ['title' => 'Obtained inside Paraguay',
    'note'  => '{{ 25-40 words: why these cannot be started from abroad. }}',
    'items' => [
      ['item' => '{{ Paraguayan record 1 }}', 'note' => '{{ 25-45 words }}', 'who' => 'Us'],
      ['item' => '{{ Paraguayan record 2 }}', 'note' => '{{ 25-45 words }}', 'who' => 'Us'],
      ['item' => '{{ Paraguayan record 3 }}', 'note' => '{{ 25-45 words }}', 'who' => 'Us'],
    ]],
 ],
 'footnote' => '{{ 30-50 words: state that this checklist is dated, that requirements change, and how to report an error. Do not promise completeness for every nationality. }}',
],

['type' => 'steps',
 'eyebrow' => 'Sequence',
 'heading' => 'The order to obtain them in',
 'intro' => ['{{ 40-60 words: the argument for sequence — the goal is that no record expires while another is still being produced. }}'],
 'items' => [
   ['title' => '{{ stage 1 title — the longest-lead record }}',
    'body' => ['{{ 50-80 words: what to request, from whom, and what to check on it the day it arrives }}'],
    'who' => 'You',
    'blocker' => '{{ 20-35 words: the specific thing that most often goes wrong at this stage }}'],
   ['title' => '{{ stage 2 title }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'You',
    'blocker' => '{{ 20-35 words }}'],
   ['title' => '{{ stage 3 title — authentication }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'You'],
   ['title' => '{{ stage 4 title — translation and Paraguayan-side preparation }}',
    'body' => ['{{ 50-80 words }}'], 'who' => 'Us'],
   ['title' => '{{ stage 5 title — assembly and filing }}', 'body' => ['{{ 50-80 words }}'], 'who' => 'Us'],
 ],
 'footnote' => '{{ 25-40 words: no total duration is given here, and say why — the stages we do not control are not ours to estimate. }}',
],

['type' => 'callout',
 'label' => 'The mistake that costs a second trip',
 'body' => [
   '{{ 70-110 words: the single most expensive document error, described concretely enough that a reader recognises it in their own situation. This is the passage people will quote. It must be true, specific, and free of any figure we cannot source. }}',
 ],
],

['type' => 'prose',
 'eyebrow' => 'Edge cases',
 'heading' => 'When the standard list does not fit you',
 'body' => [
   '{{ 40-60 words: intro to the exceptions. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'Married applicants and dependants', 'def' => '{{ 40-70 words: additional records, and the one that is most often forgotten }}'],
     ['term' => 'Applicants with a name that has changed', 'def' => '{{ 40-70 words: how the chain of records has to line up }}'],
     ['term' => 'Records from a country not party to the Hague Convention', 'def' => '{{ 40-70 words: the consular route }}'],
     ['term' => 'Applicants with a criminal record or a prior refusal', 'def' => '{{ 40-70 words: state plainly that concealment is the real risk, and point at the integrity page }}'],
   ]],
 ],
],

['type' => 'faq', 'eyebrow' => 'Document questions', 'heading' => 'The four we are asked most.'],

['type' => 'sources',
 'intro' => ['{{ 25-40 words: one sentence on which of these was primary for this page. }}'],
 'items' => [
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Paraguayan immigration authority',
    'url' => '{{ record the exact page URL used, or leave this brief in place and the citation renders as text }}',
    'note' => '{{ 15-30 words: what specifically was taken from it }}'],
   ['name' => 'Ministerio de Relaciones Exteriores', 'authority' => 'Apostille and legalisation',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => 'Hague Conference on Private International Law', 'authority' => 'Apostille Convention status table',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => '{{ any further primary source relied on — delete this row if there is none }}',
    'authority' => '{{ issuing body }}', 'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
 ],
],

['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],

['type' => 'related',
 'items' => [
   ['page' => 'guides.residency.requirements'],
   ['page' => 'guides.residency.timeline'],
   ['page' => 'guides.residency.costs'],
 ],
],

['type' => 'next-step',
 'heading' => 'Assembling this without help is possible',
 'body' => ['{{ 40-60 words: what a consultation adds over this page — a checklist for the reader\'s own nationality and situation, and the sequence applied to their dates. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.residency', 'label' => 'What our residency support covers'],
 'diy' => '{{ 30-50 words: the honest note — the kind of applicant who does not need us, stated without hedging. This appears on several guides and must never read as false modesty. }}',
],

],
];
