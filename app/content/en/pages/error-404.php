<?php
/**
 * 404. Written, not a draft. Served from /errors/404/ by ErrorDocument, with a
 * 404 status set by the route entrypoint — see tools/make-routes.php.
 */
declare(strict_types=1);

return [
'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Error 404',
 'intro' => 'The address you followed does not exist on this site. Either it was mistyped, or a page moved and we failed to redirect it — if a link on this site brought you here, we would like to know.',
],

['type' => 'prose',
 'heading' => 'Where to go instead',
 'body' => [
   'Pages that exist but are not finished say so on the page itself; they do not return an error. So this is genuinely a wrong address rather than something still being written.',
   'The three routes below cover most of what people arrive looking for.',
 ],
],

['type' => 'related',
 'items' => [
   ['page' => 'guides.residency', 'note' => 'The residency guide — the most common destination.'],
   ['page' => 'services',         'note' => 'What we do, and what we deliberately do not claim.'],
   ['page' => 'faq',              'note' => 'Short answers to the questions we are asked most.'],
 ],
],

],
];
