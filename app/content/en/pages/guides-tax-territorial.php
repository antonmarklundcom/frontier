<?php
/**
 * Paraguay territorial taxation. Structure complete, copy unwritten.
 * Highest-risk page on the tax cluster: territoriality is the claim the whole
 * category over-sells. Write what the rule says, then write the cases where
 * source is genuinely arguable, and never imply a planning outcome.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Is foreign income really untaxed in Paraguay?', 'a' => ['{{ 60-90 words: the rule, the exceptions, and the sentence that stops a reader over-reading it. }}']],
  ['q' => 'How is the source of income decided?',          'a' => ['{{ 60-90 words: the test, cited, with an example of an easy case and a hard one. }}']],
  ['q' => 'What about remote work for a foreign employer?', 'a' => ['{{ 60-90 words: the genuinely contested case. Say where the uncertainty is rather than resolving it confidently. }}']],
  ['q' => 'Does this protect me from tax at home?',        'a' => ['{{ 60-90 words: no. Cross-link tax vs legal residency. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Tax · Territoriality',
 'intro' => '{{ 45-70 words: lede. What a territorial system taxes, and why "tax-free" is the wrong summary. }}'],
['type' => 'quick-answer',
 'question' => 'What does Paraguay actually tax?',
 'answer' => ['{{ 60-90 words: the direct answer, in the law\'s own terms. }}', '{{ 40-60 words: the practical reading for a foreign resident. }}'],
 'points' => ['{{ what is taxed }}', '{{ what is not }}', '{{ the test that separates them }}', '{{ the case where the test is unclear }}'],
 'caveat' => '{{ 30-50 words: nothing here says anything about the reader\'s home country. }}'],
['type' => 'definition', 'eyebrow' => 'The principle', 'term' => 'Territorial taxation',
 'spanish' => 'fuente paraguaya',
 'body' => ['{{ 70-110 words: the definition, and how source is determined in the Paraguayan rules. }}'],
 'not' => ['{{ misconception 1 — it is not a zero-tax regime }}', '{{ misconception 2 — it is not a shield from home-country rules }}', '{{ misconception 3 — it is not automatic on getting a cédula }}']],
['type' => 'prose', 'eyebrow' => 'Applied', 'heading' => 'Where the answer is genuinely not obvious',
 'body' => ['{{ 50-80 words: intro — these are the cases worth paying an accountant for. }}',
   ['type' => 'defs', 'items' => [
     ['term' => '{{ case 1, e.g. services performed in Paraguay for a foreign client }}', 'def' => '{{ 50-80 words }}'],
     ['term' => '{{ case 2, e.g. foreign investment income remitted here }}',             'def' => '{{ 50-80 words }}'],
     ['term' => '{{ case 3, e.g. a Paraguayan company with foreign operations }}',        'def' => '{{ 50-80 words }}'],
     ['term' => '{{ case 4, e.g. digital or crypto income }}',                            'def' => '{{ 50-80 words }}'],
   ]]]],
['type' => 'callout', 'label' => 'What this page will not tell you',
 'body' => ['{{ 60-90 words: no planning advice, no structure recommendations, no numbers — and why a page that offered them would be a liability to the reader. }}']],
['type' => 'faq', 'eyebrow' => 'Territoriality questions', 'heading' => 'The four that matter.'],
['type' => 'sources', 'intro' => ['{{ 25-40 words }}'], 'items' => [
   ['name' => '{{ the tax law, by number and article }}', 'authority' => 'Paraguayan law', 'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => 'Dirección Nacional de Ingresos Tributarios (DNIT)', 'authority' => 'Administration and resolutions', 'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
 ]],
['type' => 'reviewer', 'reviewer_key' => 'tax_reviewer'],
['type' => 'related', 'items' => [['page' => 'guides.tax.vs-legal'], ['page' => 'guides.tax.ruc'], ['page' => 'guides.banking']]],
['type' => 'next-step', 'heading' => 'This is where an accountant earns their fee',
 'body' => ['{{ 40-60 words: what we do and where we hand over to a Paraguayan accountant. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.ruc', 'label' => 'RUC and tax registration support'],
 'diy' => '{{ 30-50 words: who does not need us. }}'],
],
];
