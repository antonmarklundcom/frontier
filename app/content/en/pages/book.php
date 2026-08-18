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
  ['q' => 'What happens in the session?',            'a' => ['We start with where you actually are and what you are trying to achieve, because those change the answer more than anything else does. Then: which route fits, what it would require of you, which records you would have to obtain and in what order, and which stages are decided by somebody other than us. We finish with what we would do next in your position. You receive that in writing afterwards, including the parts where the answer was that we do not know.']],
  ['q' => 'What if you tell me not to proceed?',     'a' => ['{{ 60-90 words: that this is a real outcome and what happens to the fee. }}']],
  ['q' => 'Can we speak in Spanish?',                'a' => ['{{ 40-60 words: languages actually offered. }}']],
],
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Book',
 'intro' => 'This is a paid working session, not a sales call. You describe your situation; we tell you which route fits it, which records it would need, and where the parts nobody controls sit. You leave with that in writing. If the honest answer is that Paraguay does not suit your plans, or that you can do this without us, that is the answer you will get.'],
['type' => 'quick-answer', 'eyebrow' => 'What you get',
 'question' => 'What is this consultation, exactly?',
 'answer' => ['A scheduled call with the person who would run your file, rather than an account manager who hands you on afterwards. You describe the situation; we ask about nationality, family, timing and anything you suspect might complicate it. Then we work through the route that fits, the records it would need, and the order to obtain them in. Afterwards you get a written summary of what was discussed and what we recommend, so you can read it again and show it to your spouse or your accountant.'],
 'points' => [
   'In writing afterwards: your situation as we understood it, the route we think fits, and the records that route needs.',
   'Assessed on the call: nationality, family, timing, the records you already hold, and anything that has gone wrong before.',
   '{{ what it costs — the real figure, once agreed }}',
   'If the answer is that you should not proceed, or should not proceed yet, you are told so on the call and again in writing.',
 ],
 'caveat' => 'This is preparation, not advice. An opinion on your own country\'s tax position needs an adviser there. A contract, a court matter or a formal legal opinion in Paraguay needs a Paraguayan lawyer, and filing returns needs an accountant.'],
['type' => 'prose', 'eyebrow' => 'Preparation', 'heading' => 'Bring these and the session is worth twice as much',
 'body' => ['You do not need to prepare anything in order to book. But the session turns from general to specific the moment there are real dates and real documents in front of us, so bring what you already hold rather than a tidied summary of it.',
   ['type' => 'list', 'items' => [
     'Your passport, and the passports of anyone moving with you — the details page itself, not a note of the numbers.',
     'Marriage, divorce and birth certificates you already hold, however old, and any document on which your name is spelled differently.',
     'A rough calendar: when you could travel, how long you could stay, and any date you are working towards.',
     'How your income arises and where it is taxed today — the shape of it, not the figures.',
   ]],
   'Then raise the awkward things first. A refused visa, a criminal record, an unfinished divorce, a name that has never matched across two countries, a tax question you have been avoiding — these are what decide whether a route works at all. Finding one out late is what turns a plan into a second trip.']],
['type' => 'form', 'eyebrow' => 'Enquiry', 'heading' => 'Tell us where you are',
 'intro' => ['This goes to the person who would handle your file. It is read rather than scored, and it starts no email sequence: the reply is written by someone who has read what you wrote. Tell us the complications rather than the summary. They are what determines whether we can help you at all, and we will say so if we cannot.']],
['type' => 'callout', 'label' => 'Who this session is not for',
 'body' => ['Do not book if you want a guarantee. Nobody can promise you residency, a bank account or a tax outcome, and this session will not produce one. Do not book looking for a scheme: residency is not a way to make income disappear, and we will not help anyone present it as one. And do not book hoping the decision gets made for you. We can tell you what a route involves. Whether to move your family is yours.']],
['type' => 'faq', 'eyebrow' => 'Before booking', 'heading' => 'Fair questions about a paid session.'],
['type' => 'related', 'items' => [['page' => 'process'], ['page' => 'integrity'], ['page' => 'packages']]],

],
];
