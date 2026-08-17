<?php
/**
 * Tax residency vs legal residency — Tier 1.
 * Structure complete, copy unwritten. See guides-residency-documents.php for
 * the house rules that apply to every {{ brief }} on this page.
 *
 * This page carries more risk than any other on the site: it is where a reader
 * could take a sentence, apply it to their own country's rules, and be wrong.
 * Write it so that every claim about Paraguay is stated as Paraguayan law, and
 * every claim about the reader's home country is stated as "ask there".
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Does Paraguayan residency make me a Paraguayan tax resident?',
   'a' => ['{{ 60-90 words: answer plainly. Separate immigration status, RUC registration and tax residency, and say which of the three the reader has actually acquired by getting a cédula. }}']],
  ['q' => 'Does getting a RUC end my tax obligations at home?',
   'a' => ['{{ 60-90 words: no, and why — the home country decides its own rules, and most use tests the reader has not stopped meeting. Refer them to an adviser in their own jurisdiction. }}']],
  ['q' => 'Do I have to spend a certain amount of time in Paraguay?',
   'a' => ['{{ 60-90 words: distinguish the immigration-side expectation from the tax-side test. Do not merge them into one number. }}']],
  ['q' => 'Can you advise me on my home country\'s tax rules?',
   'a' => ['{{ 40-60 words: no, and say what we can do instead — describe the Paraguayan side accurately so the reader\'s own adviser has something correct to work from. }}']],
],

'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Tax · Status',
 'intro' => '{{ 45-70 words: the lede. State the thesis — three statuses are routinely sold as one — and who pays for the confusion. }}',
],

['type' => 'quick-answer',
 'question' => 'Is tax residency the same as legal residency in Paraguay?',
 'answer' => [
   '{{ 50-80 words: the direct answer — no — followed by the one-sentence definition of each status. }}',
   '{{ 40-60 words: the practical consequence for someone who has just received a cédula. }}',
 ],
 'points' => [
   '{{ one line: what legal residency gives you }}',
   '{{ one line: what a RUC is and is not }}',
   '{{ one line: what determines Paraguayan tax residency }}',
   '{{ one line: what determines whether your home country still has a claim }}',
 ],
 'caveat' => '{{ 30-50 words: this page describes the Paraguayan side only; nothing here can tell a reader whether they have ceased to be tax resident at home. }}',
],

['type' => 'comparison',
 'eyebrow' => 'Three statuses',
 'heading' => 'What each status actually is',
 'caption' => 'Legal residency, tax registration and tax residency compared across what grants them, what they oblige and what they do not do.',
 'row_header' => '',
 'columns' => ['Legal residency', 'Tax registration (RUC)', 'Tax residency'],
 'rows' => [
   ['label' => 'Who grants it',        'cells' => ['{{ authority }}', '{{ authority }}', '{{ how it arises }}']],
   ['label' => 'What proves it',       'cells' => ['{{ document }}', '{{ document }}', '{{ what evidences it }}']],
   ['label' => 'What it obliges you to do', 'cells' => ['{{ 12-25 words }}', '{{ 12-25 words }}', '{{ 12-25 words }}']],
   ['label' => 'What it does not do',  'cells' => ['{{ 12-25 words }}', '{{ 12-25 words }}', '{{ 12-25 words }}']],
   ['label' => 'How it ends',          'cells' => ['{{ 12-25 words }}', '{{ 12-25 words }}', '{{ 12-25 words }}']],
 ],
 'footnote' => '{{ 30-50 words: the sentence a reader should take away from this table. }}',
],

['type' => 'prose',
 'eyebrow' => 'The Paraguayan side',
 'heading' => 'What makes someone tax resident in Paraguay',
 'body' => [
   '{{ 80-120 words: the Paraguayan test, cited to the source. Say what the rule text is before saying how it is applied. }}',
   '{{ 60-90 words: how registration and residency interact in practice. }}',
   ['type' => 'list', 'items' => [
     '{{ load-bearing fact 1 }}',
     '{{ load-bearing fact 2 }}',
     '{{ load-bearing fact 3 }}',
   ]],
 ],
],

['type' => 'prose',
 'eyebrow' => 'The other side',
 'heading' => 'Why your own country may still have a claim',
 'body' => [
   '{{ 80-120 words: the general shape of home-country tests — domicile, days present, centre of vital interests, citizenship-based taxation — described as categories, never as advice about any one country. }}',
   '{{ 50-80 words: what a treaty does and does not do, if Paraguay has one with the reader\'s country. }}',
   '{{ 40-60 words: the recommendation to take this to an adviser in their own jurisdiction before relying on anything. }}',
 ],
],

['type' => 'callout',
 'label' => 'The claim you will see elsewhere, and why it is wrong',
 'body' => [
   '{{ 70-110 words: quote the category\'s standard pitch — residency as an automatic tax exit — and dismantle it factually. Attack the claim, not named competitors. }}',
 ],
],

['type' => 'faq', 'eyebrow' => 'Status questions', 'heading' => 'What people actually ask us.'],

['type' => 'sources',
 'intro' => ['{{ 25-40 words: which source governs the Paraguayan test. }}'],
 'items' => [
   ['name' => 'Dirección Nacional de Ingresos Tributarios (DNIT)', 'authority' => 'Paraguayan tax authority',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => '{{ the law or resolution that defines tax residency, by number }}', 'authority' => 'Paraguayan law',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
   ['name' => 'Dirección Nacional de Migraciones', 'authority' => 'Immigration status',
    'url' => '{{ exact URL used }}', 'note' => '{{ 15-30 words }}'],
 ],
],

['type' => 'reviewer', 'reviewer_key' => 'tax_reviewer'],

['type' => 'related',
 'items' => [
   ['page' => 'guides.tax.territorial'],
   ['page' => 'guides.tax.ruc'],
   ['page' => 'guides.residency'],
 ],
],

['type' => 'next-step',
 'heading' => 'Where this stops being a reading problem',
 'body' => ['{{ 40-60 words: when a reader needs a Paraguayan accountant and their own adviser in the same conversation, and what we do in that setup. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'services.ruc', 'label' => 'RUC and tax registration support'],
 'diy' => '{{ 30-50 words: who does not need us here. }}',
],

],
];
