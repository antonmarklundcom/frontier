<?php
/**
 * Book a consultation. Structure complete, copy unwritten.
 *
 * This is the page the home page's CTAs point at, so it is the highest-value
 * unwritten page on the site. It carries the enquiry form, which stays disabled
 * until SMTP delivery is configured and a real message has been received
 * (docs/PRODUCTION-DATA-REQUIRED.md item 8).
 *
 * The consultation is paid. The amount must be stated on this page in plain
 * words once it is agreed — a paid session presented ambiguously is the kind of
 * small dishonesty the rest of the site is built to avoid.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'What does the consultation cost?',        'a' => ['{{ 40-70 words: state the fee plainly, what it buys, and whether it is credited against an engagement. Do not publish this page until the amount is real. }}']],
  ['q' => 'What happens in the session?',            'a' => ['{{ 60-90 words: the agenda, and what you receive in writing afterwards. }}']],
  ['q' => 'What if you tell me not to proceed?',     'a' => ['{{ 60-90 words: that this is a real outcome and what happens to the fee. }}']],
  ['q' => 'Can we speak in Spanish?',                'a' => ['{{ 40-60 words: languages actually offered. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Book',
 'intro' => '{{ 50-80 words: lede. A paid working session, what it produces, and who it is not for. }}'],
['type' => 'quick-answer', 'eyebrow' => 'What you get',
 'question' => 'What is this consultation, exactly?',
 'answer' => ['{{ 60-90 words: the session described concretely — length, format, who is on the call, what you leave with. }}'],
 'points' => [
   '{{ what you receive in writing afterwards }}',
   '{{ what is assessed during the session }}',
   '{{ what it costs — the real figure, once agreed }}',
   '{{ what happens if the answer is "do not proceed" }}',
 ],
 'caveat' => '{{ 30-50 words: it is not legal or tax advice, and what would need a lawyer or accountant instead. }}'],
['type' => 'prose', 'eyebrow' => 'Preparation', 'heading' => 'Bring these and the session is worth twice as much',
 'body' => ['{{ 40-60 words: intro. }}',
   ['type' => 'list', 'items' => [
     '{{ thing to have ready 1 }}', '{{ thing to have ready 2 }}',
     '{{ thing to have ready 3 }}', '{{ thing to have ready 4 }}',
   ]],
   '{{ 40-60 words: the reminder that awkward facts — refusals, records, unfinished divorces — are the ones worth raising first. }}']],
['type' => 'form', 'eyebrow' => 'Enquiry', 'heading' => 'Tell us where you are',
 'intro' => ['{{ 40-70 words: what happens after you send this — who reads it, roughly when you hear back, and that it goes to a person rather than a sequence. }}']],
['type' => 'callout', 'label' => 'Who this session is not for',
 'body' => ['{{ 60-90 words: the readers who should not book — those wanting a guaranteed outcome, a tax scheme, or a decision made for them. Turning people away here is cheaper for everyone. }}']],
['type' => 'faq', 'eyebrow' => 'Before booking', 'heading' => 'Fair questions about a paid session.'],
['type' => 'related', 'items' => [['page' => 'process'], ['page' => 'integrity'], ['page' => 'packages']]],

],
];
