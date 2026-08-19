<?php
/**
 * 500. Written, not a draft. Kept deliberately plain: it may render while
 * something on the server is broken, so it depends on as little as possible.
 */
declare(strict_types=1);

return [
'blocks' => [

['type' => 'page-header',
 'eyebrow' => 'Error 500',
 'intro' => 'Something failed on our side, not yours. Nothing you did caused this, and if you were sending us a message, assume it did not arrive.',
],

['type' => 'prose',
 'heading' => 'What to do',
 'body_html' => [
   'Reload the page in a minute. If it fails again, use the contact details in the footer — those do not depend on whatever is broken here.',
   'If you were part-way through sending an enquiry, please send it again. We would rather receive it twice than not at all.',
 ],
],

['type' => 'related',
 'items' => [
   ['page' => 'guides.residency', 'note' => 'The residency guide.'],
   ['page' => 'book',             'note' => 'Book a consultation.'],
   ['page' => 'integrity',        'note' => 'What we control, and what we do not.'],
 ],
],

],
];
