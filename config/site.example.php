<?php
/**
 * Paraguay Frontier — site configuration.
 *
 * Copy to config/site.php and fill in. config/site.php is git-ignored and must
 * never contain secrets that the browser could reach — it is server-side only,
 * but SMTP/CRM credentials belong in environment variables (see config/env.example.php).
 *
 * Every value left as a [PLACEHOLDER] string is reported by tools/qa.php and
 * listed in docs/PRODUCTION-DATA-REQUIRED.md. The site stays noindex until the
 * placeholders that gate launch are resolved.
 */
return [
    'name'          => 'Paraguay Frontier',
    'base_url'      => 'https://paraguayfrontier.com',
    'locale'        => 'en',
    'locales'       => ['en'],            // add 'es' only when /es/ pages exist
    'launched'      => false,             // false => noindex,nofollow site-wide

    // Render draft outlines (structure written, copy not yet) instead of the
    // "in preparation" notice, so an author can read a page in its real layout
    // with every unwritten passage marked. Off here on purpose: this example
    // file is the fallback config a server with no config/site.php would load,
    // and a visitor must never reach a page full of editorial briefs. Turn it
    // on for one local session instead:  PF_PREVIEW=1 php -S 127.0.0.1:8080 -t .
    // It is forced off whenever 'launched' is true, whatever this says.
    'preview_drafts' => false,

    // --- Contact. Displayed only when the value is not a [PLACEHOLDER]. -------
    'email'         => '[BUSINESS_EMAIL]',
    'whatsapp'      => '[WHATSAPP_NUMBER]',   // E.164 digits only, e.g. 595991234567
    'calendar_url'  => '[CALENDAR_URL]',
    'address'       => '[PARAGUAY_ADDRESS]',
    'company_reg'   => '[COMPANY_REGISTRATION_DETAILS]',

    // --- People. Person schema is emitted only for real, named people. -------
    'founder'       => '[FOUNDER_NAME]',
    'legal_reviewer'=> '[LEGAL_REVIEWER]',
    'tax_reviewer'  => '[TAX_REVIEWER]',

    // --- Social profiles. Empty array => no sameAs in Organization schema. ---
    'profiles'      => [],

    'og_default'    => '/assets/images/og-default.png',
];
