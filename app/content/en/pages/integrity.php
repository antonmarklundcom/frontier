<?php
/**
 * Integrity page.
 *
 * The remedy policy is deliberately NOT stated as a promise. [REFUND_POLICY] has
 * not been drafted or reviewed, and publishing a remedy before a lawyer has
 * written it would be exactly the behaviour this page criticises. The copy says
 * so plainly rather than rendering a placeholder or inventing a guarantee.
 */
declare(strict_types=1);

return [
'faqs' => [
  ['q' => 'Do you guarantee that my residency will be approved?',
   'a' => ['No, and nobody can. Approval is a decision of the Dirección Nacional de Migraciones, applying its own criteria and discretion to your file. What we can do is tell you before you engage us whether your situation appears to meet the published requirements, and where we think a reviewing officer is most likely to raise a question.']],
  ['q' => 'Can you tell me how long it will take?',
   'a' => ['We will give you a realistic sequence and tell you which stages we control. We will not give you a total, because the government review stage is not ours to predict and any figure we published would be a guess presented as a commitment.']],
  ['q' => 'Will I definitely be able to open a Paraguayan bank account?',
   'a' => ['No. Paraguayan banks apply their own compliance judgement to every foreign applicant and decline applications regularly, including well-prepared ones. We prepare the file and make the introduction. The decision is the bank\'s.']],
  ['q' => 'What happens if something goes wrong?',
   'a' => ['It depends on what went wrong and who caused it. If an error in work performed directly by Paraguay Frontier causes a problem, the remedy stated in your signed service agreement applies. Incomplete or inaccurate information from you, changes in law, government discretion and third-party fees are not covered by that, and we will say so at the time rather than after.']],
],

'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'How we work',
 'intro' => 'This page exists so you can judge us before you speak to us. It sets out what we control, what we do not, how we present estimates, and what happens when something goes wrong. If any of it reads as less confident than a competitor\'s page, that is the point.',
],

['type' => 'prose',
 'heading' => 'What we control',
 'body' => [
   'Our responsibility is the quality and completeness of the work we do with you. Specifically:',
   ['type' => 'list', 'items' => [
     'Assessing whether your situation appears to meet the current published requirements, and telling you when it does not.',
     'Building the document checklist for your nationality and profile, in the order the records have to be obtained so that nothing expires before it is used.',
     'Coordinating sworn translation and Paraguayan-side authentication.',
     'Assembling the application accurately and filing it with you.',
     'Telling you what stage your file is genuinely at, including when the honest answer is "no movement since last time".',
     'Giving you a written schedule for keeping the status valid after it is granted.',
   ]],
   'If we get one of those wrong, that is ours.',
 ],
],

['type' => 'prose',
 'heading' => 'What we do not control',
 'body' => [
   'Four things sit outside our control entirely, and no provider can contract around them.',
   ['type' => 'defs', 'items' => [
     ['term' => 'Government discretion', 'def' => 'Migraciones decides who is approved. A complete, accurate, well-presented file improves how your application is read. It does not bind the decision.'],
     ['term' => 'Processing time', 'def' => 'The review stage runs on the government\'s timetable, which varies with caseload, policy and circumstances none of us can see. We do not publish an estimate for it.'],
     ['term' => 'Changes in law and practice', 'def' => 'Requirements, fees and accepted document formats change. We track them and date our guidance, but a rule can change between your first consultation and your filing.'],
     ['term' => 'Third-party decisions', 'def' => 'Banks, translators, notaries and your own government\'s record offices set their own standards, timelines and fees. We can prepare for them; we cannot decide for them.'],
   ]],
 ],
],

['type' => 'prose',
 'heading' => 'How we present estimates',
 'body' => [
   'Every figure we give you is labelled with what kind of figure it is. There are only three kinds, and we do not blur them:',
   ['type' => 'list', 'items' => [
     '<strong>Fixed</strong> — our fee for a defined scope. This does not move unless the scope moves, and a scope change is agreed in writing before any extra work starts.',
     '<strong>Set by someone else</strong> — government fees, translation, notarisation, apostille costs. We tell you the current published amount and who you pay it to. If it changes, you pay the new amount, not a marked-up one.',
     '<strong>Genuinely uncertain</strong> — anything depending on your own records, your travel, or how the review stage runs. We give you a range and the reason it is a range, or we tell you we do not know.',
   ]],
   'You will not receive a single all-in number with the uncertainty quietly buried inside it.',
 ],
],

['type' => 'prose',
 'heading' => 'What we need from you',
 'body' => [
   'Most applications that go wrong go wrong because of something the applicant did not mention, usually because it seemed irrelevant or embarrassing. It is neither.',
   ['type' => 'list', 'items' => [
     'Tell us about prior visa refusals, deportations or immigration problems in any country.',
     'Tell us about criminal records, ongoing proceedings or charges, however old and however minor they seem.',
     'Tell us your real intentions about time spent in Paraguay. Advice that assumes you will be present when you will not is worthless advice.',
     'Tell us about dependents, custody arrangements and marital status changes, including ones not yet finalised.',
     'Give us documents as they are, not as you would like them to read.',
   ]],
   'We would far rather hear an inconvenient fact at the consultation than discover it after the file is submitted. Nothing in that list automatically ends an application — but concealing it can.',
 ],
],

['type' => 'callout',
 'label' => 'Our remedy policy is not published yet',
 'body' => [
   'If an error in work performed directly by Paraguay Frontier causes a refusal or a material problem, the remedy that applies is the one stated in your signed service agreement.',
   'We have not published a standard remedy policy on this page yet, because it has not been drafted and reviewed by a lawyer. Publishing a refund or free-reapplication promise before it exists in reviewable form would be precisely the behaviour the rest of this page argues against. When it is drafted and reviewed, it will appear here with a review date, and you will be able to compare it to what your agreement says.',
 ],
],

['type' => 'prose',
 'heading' => 'Conflicts of interest',
 'body' => [
   'We disclose these rather than wait to be asked.',
   ['type' => 'list', 'items' => [
     'We are paid for the services described on this site. That is an obvious incentive to recommend them, which is why the scope section of every service page also says when you do not need us.',
     'We refer clients to translators, notaries and other professionals. Where any referral arrangement involves a commission or reciprocal benefit, we will tell you at the point of referral.',
     'We are not a law firm and we are not accountants. Where your question needs a lawyer or an accountant, our interest is in saying so, not in stretching our own scope to cover it.',
     'We do not accept payment for editorial placement, links or favourable mentions in our guides.',
   ]],
 ],
],

['type' => 'prose',
 'heading' => 'Corrections',
 'body' => [
   'If you find something on this site that is wrong, out of date, or misleading, tell us and we will fix it. Corrections are made in the page itself with the last-reviewed date changed, so you can see that it moved. We do not quietly edit a page and leave the old date on it.',
   'The full process — how we research, who reviews what, and how to report an error — is on the editorial standards page.',
 ],
],

['type' => 'faq',
 'eyebrow' => 'The awkward questions',
 'heading' => 'Asked directly, answered directly.',
],

['type' => 'related',
 'items' => [
   ['page' => 'editorial-standards', 'note' => 'How our guides are researched, reviewed, dated and corrected.'],
   ['page' => 'process',             'note' => 'What actually happens, stage by stage, once you engage us.'],
   ['page' => 'book',                'note' => 'A paid working session that ends with a written route — or with a recommendation not to proceed.'],
 ],
],

],
];
