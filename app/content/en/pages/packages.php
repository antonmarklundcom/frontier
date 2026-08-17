<?php
/**
 * Packages. Structure complete, copy AND prices unwritten.
 *
 * BLOCKED: this page cannot be finished until real prices, inclusions and
 * exclusions exist (docs/PRODUCTION-DATA-REQUIRED.md). Do not fill the price
 * cells with an example, a "from" figure or a placeholder number to make the
 * table look complete — a fabricated price on this page would undo the whole
 * positioning. If prices are not agreed, this page stays a draft, which means
 * it stays unpublished. That is the correct outcome, not a problem to work
 * around.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Why is the price not on this page yet?',   'a' => ['{{ 60-90 words: answer honestly while it is true; delete this question once prices are published. }}']],
  ['q' => 'What is not included in any package?',     'a' => ['{{ 60-90 words: third-party fees, named. }}']],
  ['q' => 'Do you mark up government or translation fees?', 'a' => ['{{ 60-90 words }}']],
  ['q' => 'What happens if the scope changes mid-engagement?', 'a' => ['{{ 60-90 words: written agreement before extra work, no surprise invoices. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Packages',
 'intro' => '{{ 50-80 words: lede. What a package is, what it is not, and that third-party costs are always separate. }}'],
['type' => 'comparison', 'eyebrow' => 'Scope', 'heading' => 'What each engagement covers',
 'caption' => 'Each package compared by what it includes, what it excludes and which third-party costs are paid directly to others.',
 'row_header' => '', 'columns' => ['{{ package 1 name }}', '{{ package 2 name }}', '{{ package 3 name }}'],
 'rows' => [
   ['label' => 'Who it is for',        'cells' => ['{{ 10-20 words }}', '{{ 10-20 words }}', '{{ 10-20 words }}']],
   ['label' => 'Included work',        'cells' => ['{{ 12-25 words }}', '{{ 12-25 words }}', '{{ 12-25 words }}']],
   ['label' => 'Not included',         'cells' => ['{{ 12-25 words }}', '{{ 12-25 words }}', '{{ 12-25 words }}']],
   ['label' => 'Paid directly to others', 'cells' => ['{{ 12-25 words }}', '{{ 12-25 words }}', '{{ 12-25 words }}']],
   ['label' => 'Our fee',              'cells' => ['{{ agreed price — never an invented or example figure }}', '{{ agreed price }}', '{{ agreed price }}']],
 ],
 'footnote' => '{{ 30-50 words: the date the fees were set, the currency, and what triggers a change. }}'],
['type' => 'callout', 'label' => 'What a package cannot include',
 'body' => ['{{ 60-90 words: approval, a processing time, a bank account, or a tax outcome. Say it here, on the page where money is discussed. }}']],
['type' => 'faq', 'eyebrow' => 'Pricing questions', 'heading' => 'Asked before every engagement.'],
['type' => 'related', 'items' => [['page' => 'guides.residency.costs'], ['page' => 'process'], ['page' => 'integrity']]],
['type' => 'next-step', 'heading' => 'A quote for your situation',
 'body' => ['{{ 40-60 words: the consultation is where a package becomes a number for this reader. }}'],
 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
 'secondary' => ['page' => 'guides.residency.costs', 'label' => 'What residency costs, by category'],
],

],
];
