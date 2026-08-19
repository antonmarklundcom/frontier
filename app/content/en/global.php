<?php
/**
 * Locale-wide strings. Everything a second locale would need to translate
 * lives here or in a page content file — never hard-coded in a template.
 *
 * A locale's copy of this file is complete when every key below has a value in
 * that language. Missing keys render as the key itself, which is ugly on
 * purpose: an untranslated string should be impossible to miss, not a silent
 * fall back to English that nobody notices for a year.
 */
declare(strict_types=1);

return [
    'brand_line'      => 'Field intelligence for Paraguay',
    'skip_to_content' => 'Skip to content',
    'menu_open'       => 'Open menu',
    'menu_close'      => 'Close menu',
    'breadcrumb_home' => 'Home',
    'nav_book'        => 'Book a consultation',
    'nav_book_short'  => 'Book',
    'last_reviewed'   => 'Last reviewed',
    'sources_heading' => 'Sources',
    'related_heading' => 'Related guides',
    'in_preparation'  => 'This page is in preparation',
    'in_preparation_body' => 'We publish a page when it has been researched against primary Paraguayan sources and reviewed — not before. This one is not finished yet, so it is excluded from search engines and from our sitemap. The pages linked below are the closest thing we have ready.',
    // Navigation and chrome.
    'wordmark_home_aria'      => 'Paraguay Frontier — home',
    'nav_primary_label'       => 'Primary',
    'nav_mobile_label'        => 'Mobile',
    'breadcrumb_label'        => 'Breadcrumb',
    'rail_label'              => 'Page sections',
    'nav_state_in_preparation'=> 'In preparation',

    // The language switcher, dormant while one locale is configured.
    // 'language_name' is read from EACH locale's own file, so every language
    // is named in itself ('English', 'Espanol', 'Deutsch') — never translated
    // into the language the visitor is trying to leave.
    'language_name'           => 'English',
    'language_switcher_label' => 'Language',

    // Footer.
    'footer_pitch'    => 'Residency, tax registration and banking preparation in Paraguay — explained accurately and executed locally.',
    'disclaimer_label'=> 'General information disclaimer.',

    // The document metadata strip that editorial standards promises on every page.
    'stamp_written_by'  => 'Written by',
    'stamp_reviewed_by' => 'Reviewed by',

    // The in-preparation notice's escape routes.
    'prep_link_home'      => 'Home',
    'prep_link_residency' => 'Paraguay residency guide',
    'prep_link_editorial' => 'How we research and review',

    // The WhatsApp greeting, prefilled into the visitor's chat app. A whole
    // sentence with a placeholder, never fragments concatenated in a helper:
    // word order differs between languages and only the whole sentence is
    // translatable. %s is the page or component the visitor clicked from.
    'whatsapp_greeting'         => 'Hello — I found paraguayfrontier.com and I have a question about Paraguay residency.',
    'whatsapp_greeting_context' => 'Hello — I found paraguayfrontier.com (%s) and I have a question about Paraguay residency.',

    // Structured data. Shown to search engines rather than to visitors, which
    // makes it easier to forget and no less important to localise.
    'org_description' => 'Guidance and local execution for Paraguay residency, tax registration and banking preparation.',

    'disclaimer'      => 'General information about Paraguayan residency, tax and banking procedures. It is not legal, tax, immigration or financial advice, and it is not a substitute for a qualified professional reviewing your own situation.',
];
