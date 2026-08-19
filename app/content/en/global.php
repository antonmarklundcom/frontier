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

    // WhatsApp is a product name and is not translated; it lives here so the
    // link label is not written out twice in two templates.
    'whatsapp_label' => 'WhatsApp',

    // The review stamp at the foot of a guide. %s placeholders keep each of
    // these one translatable sentence rather than fragments a template glues
    // together in English word order.
    'reviewer_label_reviewed' => 'Professional review',
    'reviewer_label_pending'  => 'Not yet reviewed',
    'reviewer_kind_lawyer'    => 'Paraguayan lawyer',
    'reviewer_kind_accountant'=> 'Paraguayan accountant',
    // %1$s reviewer name (already marked up), %2$s the date clause or empty,
    // %3$s the professional kind.
    'reviewer_body_html'      => 'This page was reviewed by %1$s%2$s. Review covers whether the procedure described matches current Paraguayan practice. It is not advice on your own situation, and it does not make this page a substitute for engaging a %3$s on facts specific to you.',
    // %s the professional kind.
    'reviewer_body_pending'   => 'A %s has not yet reviewed this page, so it is not published: it is excluded from our sitemap and closed to search engines until that review happens. You are most likely reading it because you were sent a preview link. Treat every factual claim on it as unverified.',
    'reviewer_report'         => 'Found something wrong? Send us the URL and the sentence — corrections are made in the page with the review date changed, never quietly.',

    // The sources block's standing policy, shown under every citation list.
    'sources_policy' => 'Where practice and published text differ, we say which one we followed. Secondary commentary — relocation blogs, forums, competitor pages — is never cited as authority here.',

    // %s is the Spanish term, marked up so it carries lang="es".
    'definition_native_html' => 'In Paraguayan documents and offices this appears as %s.',

    // The enquiry form. Every label, hint and state message.
    'form_disabled_label' => 'This form is not live yet',
    'form_disabled_body'  => 'Message delivery has not been configured and verified on this server, so the form is switched off rather than silently discarding what you write. Use the contact details in the footer instead — they are checked.',
    'form_error_label'    => 'Not sent',
    'form_hp_label'       => 'Company website',
    'form_required'       => 'required',
    'form_label_name'     => 'Your name',
    'form_label_email'    => 'Email',
    'form_label_country'  => 'Your nationality',
    'form_hint_country'   => 'Nationality changes which records you need and how they are authenticated.',
    'form_label_stage'    => 'Where you are',
    'form_label_message'  => 'Your situation',
    'form_hint_message'   => 'Nationality, family situation, rough timing, and anything you think might be a complication. Awkward facts are the useful ones — prior refusals, records, unfinished divorces.',
    'form_submit'         => 'Send this to us',
    'form_privacy'        => 'We use what you send here to answer you and nothing else. It is not added to a marketing list and not passed to anyone outside the work you ask us to do —',
    'form_privacy_link'   => 'how we handle your data',
    'form_stage_none'         => 'Select one',
    'form_stage_researching'  => 'Researching — no decision made',
    'form_stage_decided'      => 'Decided to move, planning the trip',
    'form_stage_in_country'   => 'Already in Paraguay',
    'form_stage_has_residency'=> 'Already have residency, need tax or banking help',
    'form_stage_other'        => 'Something else',

    'disclaimer'      => 'General information about Paraguayan residency, tax and banking procedures. It is not legal, tax, immigration or financial advice, and it is not a substitute for a qualified professional reviewing your own situation.',
];
