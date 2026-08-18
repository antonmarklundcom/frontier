<?php
/**
 * Post-submission confirmation. Written, not a draft: nothing on this page is
 * an editorial claim, so it needs no research or professional review. It does
 * make one promise — that a person reads what was sent — so do not add a
 * response-time figure here until one can actually be kept.
 */
declare(strict_types=1);

return [
'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Received',
 'intro' => 'Your message has arrived. It goes to a person, not into a sequence, and the reply you get will be written by one.',
],

['type' => 'prose',
 'heading' => 'What happens now',
 'body' => [
   'We read what you sent and answer the question you actually asked. If your situation has a complication in it, we will say so in the reply rather than saving it for a call.',
   'If we think you do not need us, that is what the reply will say. It happens often enough to be worth putting in writing here.',
   'While you wait, the pages below are the ones most people find useful before a first conversation.',
 ],
],

['type' => 'related',
 'items' => [
   ['page' => 'guides.residency',  'note' => 'How Paraguayan residency works, and the decisions to make before spending anything.'],
   ['page' => 'integrity',         'note' => 'What we control, what we do not, and how we present estimates.'],
   ['page' => 'process',           'note' => 'What actually happens, stage by stage, once you engage us.'],
 ],
],

],
];
