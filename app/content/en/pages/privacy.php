<?php
/**
 * Privacy policy. Structure complete, copy unwritten.
 *
 * BLOCKED on a lawyer. Do not write this from a template found online, and do
 * not describe data handling that has not been verified against what the site
 * and the business actually do. What this site does today, factually:
 *   - No analytics product, no third-party scripts, no advertising pixels.
 *   - One functional cookie on /book-consultation/ only (PHP session, used for
 *     the CSRF token and to redisplay a failed submission). See app/form.php.
 *   - Enquiry data is emailed to the business and, when enabled, sent to
 *     VenderCRM. Nothing else leaves the server.
 *   - Server access logs are the host's, not ours to define here.
 * Whoever writes this page should verify each of those before restating it.
 */
declare(strict_types=1);

return [
'blocks' => [
['type' => 'page-header', 'eyebrow' => 'Legal',
 'intro' => '{{ 40-60 words: plain-language summary of what this page says, before the detail. }}'],
['type' => 'prose', 'eyebrow' => 'Summary', 'heading' => 'The short version',
 'body' => ['{{ 60-90 words: what is collected, why, how long it is kept, who else sees it. Written to be understood, not to be defensible. }}']],
['type' => 'prose', 'eyebrow' => 'Detail', 'heading' => 'What is collected and why',
 'body' => ['{{ 40-60 words: intro. }}',
   ['type' => 'defs', 'items' => [
     ['term' => 'What you send us through the form', 'def' => '{{ 50-80 words: fields, purpose, retention }}'],
     ['term' => 'Cookies',                          'def' => '{{ 50-80 words: the single functional session cookie and where it is set }}'],
     ['term' => 'Server logs',                      'def' => '{{ 50-80 words: what the host records }}'],
     ['term' => 'Third parties',                    'def' => '{{ 50-80 words: the CRM and the mail provider, named }}'],
     ['term' => 'What we do not do',                'def' => '{{ 50-80 words: no analytics, no advertising, no data sale, no profiling }}'],
   ]]]],
['type' => 'prose', 'eyebrow' => 'Your rights', 'heading' => 'Correcting or deleting your data',
 'body' => ['{{ 60-90 words: how to ask, what happens, and how long it takes. }}',
            '{{ 40-60 words: the applicable law and the supervisory authority, once the lawyer has settled which regimes apply. }}']],
['type' => 'callout', 'label' => 'Reviewed by a lawyer',
 'body' => ['{{ 30-50 words: who drafted or reviewed this and when. Delete this block only if the page is genuinely reviewed and the stamp moves to the page header. }}']],
['type' => 'related', 'items' => [['page' => 'terms'], ['page' => 'editorial-standards'], ['page' => 'integrity']]],

],
];
