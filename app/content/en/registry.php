<?php
/**
 * Page registry — the single source of truth for every URL on the site.
 *
 * 'status' => 'live'    : a content file exists in content/en/pages/<id>.php
 * 'status' => 'planned' : the route resolves, renders an honest "in preparation"
 *                         notice, and is excluded from the sitemap and from
 *                         indexing. No dead internal links, no thin pages
 *                         pretending to be finished.
 *
 * 'type' drives schema selection: 'page' | 'service' | 'article'.
 */
declare(strict_types=1);

return [

// ---------------------------------------------------------------- core -----
'home' => [
    'url' => '/', 'type' => 'page', 'status' => 'live', 'cluster' => 'core',
    'title' => 'Paraguay Residency Support | Paraguay Frontier',
    'description' => 'Independent guidance and local execution for Paraguay residency, RUC registration and banking preparation — with the limits stated up front.',
    'h1' => 'Paraguay residency is built on paperwork, not promises.',
    'breadcrumb' => 'Home',
    'intent' => 'Brand entry point; orient the visitor and route them to the right service or guide.',
    'last_reviewed' => '2026-08-17',
],
'services' => [
    'url' => '/services/', 'type' => 'service', 'status' => 'planned', 'cluster' => 'core',
    'title' => 'Paraguay Residency & Tax Services | Paraguay Frontier',
    'description' => 'What Paraguay Frontier handles for you, what stays with the government, and what you should take to a lawyer or accountant instead.',
    'h1' => 'Services', 'nav_label' => 'All services',
    'intent' => 'Service overview and scope boundaries.',
],
'services.residency' => [
    'url' => '/services/residency/', 'type' => 'service', 'status' => 'planned', 'cluster' => 'services',
    'title' => 'Paraguay Residency Application Support',
    'description' => 'Document preparation, application assembly and in-country coordination for a Paraguay temporary residency application.',
    'h1' => 'Residency application support', 'nav_label' => 'Residency support',
    'intent' => 'Commercial: buy help with a residency application.',
],
'services.permanent-residency' => [
    'url' => '/services/permanent-residency/', 'type' => 'service', 'status' => 'planned', 'cluster' => 'services',
    'title' => 'Permanent Residency Conversion Support',
    'description' => 'Support for converting Paraguay temporary residency to permanent status, including the records and timing the conversion depends on.',
    'h1' => 'Permanent residency support', 'nav_label' => 'Permanent residency',
    'intent' => 'Commercial: buy help converting to permanent status.',
],
'services.ruc' => [
    'url' => '/services/ruc-tax-registration/', 'type' => 'service', 'status' => 'planned', 'cluster' => 'services',
    'title' => 'RUC & Tax Registration Support in Paraguay',
    'description' => 'Help obtaining a RUC with DNIT and understanding the filing obligations that begin the moment you are registered.',
    'h1' => 'RUC and tax registration support', 'nav_label' => 'RUC & tax registration',
    'intent' => 'Commercial: buy help registering for a RUC.',
],
'services.banking' => [
    'url' => '/services/banking-support/', 'type' => 'service', 'status' => 'planned', 'cluster' => 'services',
    'title' => 'Paraguay Banking Preparation Support',
    'description' => 'Preparation and introductions for opening a Paraguayan bank account. Banks decide; we prepare the file that gets a fair hearing.',
    'h1' => 'Banking preparation support', 'nav_label' => 'Banking preparation',
    'intent' => 'Commercial: buy help preparing a bank account application.',
],
'packages' => [
    'url' => '/packages/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'core',
    'title' => 'Packages & Pricing | Paraguay Frontier',
    'description' => 'What each Paraguay Frontier package includes, what it excludes, and which third-party costs you pay directly to others.',
    'h1' => 'Packages', 'nav_label' => 'Packages',
    'intent' => 'Commercial: compare scope and price before enquiring.',
],
'process' => [
    'url' => '/process/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'core',
    'title' => 'How Working With Us Works | Paraguay Frontier',
    'description' => 'The sequence from first consultation to cédula: what happens at each stage, what we need from you, and where the waiting actually occurs.',
    'h1' => 'How working with us works', 'nav_label' => 'How it works',
    'intent' => 'Reassurance: understand the engagement before booking.',
],
'book' => [
    'url' => '/book-consultation/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'core',
    'title' => 'Book a Paraguay Residency Consultation',
    'description' => 'Book a paid consultation to review your situation, eligibility questions, realistic timing and the route that actually fits your plans.',
    'h1' => 'Book a consultation', 'nav_label' => 'Book a consultation',
    'intent' => 'Primary conversion.',
],
'about' => [
    'url' => '/about/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'core',
    'title' => 'About Paraguay Frontier',
    'description' => 'Who runs Paraguay Frontier, how the work is done on the ground in Asuncion, and the standards the published guidance is held to.',
    'h1' => 'About Paraguay Frontier', 'nav_label' => 'About us',
    'intent' => 'Trust: who is behind this.',
],

// ----------------------------------------------------------- residency -----
'guides.residency' => [
    'url' => '/guides/residency/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Paraguay Residency: The Complete Guide',
    'description' => 'How Paraguay residency actually works — the routes, the sequence, what the government decides, and where applications most often go wrong.',
    'h1' => 'Paraguay residency', 'nav_label' => 'Residency guide',
    'intent' => 'Informational hub: understand the whole landscape.',
],
'guides.residency.requirements' => [
    'url' => '/guides/residency/requirements/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Paraguay Residency Requirements',
    'description' => 'Eligibility conditions and the records Paraguay asks for, by applicant profile — and the difference between meeting them and being approved.',
    'h1' => 'Paraguay residency requirements', 'nav_label' => 'Requirements',
    'intent' => 'Owns: eligibility and required records.',
],
'guides.residency.documents' => [
    'url' => '/guides/residency/documents/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Paraguay Residency Documents & Apostilles',
    'description' => 'Which documents need an apostille, which need a sworn translation, how long each stays valid, and the order to obtain them in.',
    'h1' => 'Documents and authentication', 'nav_label' => 'Documents & apostilles',
    'intent' => 'Owns: document preparation and authentication.',
],
'guides.residency.costs' => [
    'url' => '/guides/residency/costs/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Paraguay Residency Costs Explained',
    'description' => 'Government fees, professional fees, translation, travel and ongoing costs — separated, so you can see what is fixed and what varies.',
    'h1' => 'What Paraguay residency costs', 'nav_label' => 'Costs',
    'intent' => 'Owns: cost categories and who is paid.',
],
'guides.residency.timeline' => [
    'url' => '/guides/residency/timeline/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Paraguay Residency Timeline',
    'description' => 'A realistic sequence from first document to cédula, the stages you control, and the specific things that cause most of the delay.',
    'h1' => 'How long Paraguay residency takes', 'nav_label' => 'Timeline',
    'intent' => 'Owns: sequencing and sources of delay.',
],
'guides.residency.temporary-vs-permanent' => [
    'url' => '/guides/residency/temporary-vs-permanent/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Temporary vs Permanent Residency in Paraguay',
    'description' => 'How the two statuses differ in rights, obligations and renewal, and what the conversion from temporary to permanent depends on.',
    'h1' => 'Temporary versus permanent residency', 'nav_label' => 'Temporary vs permanent',
    'intent' => 'Owns: status comparison.',
],
'guides.residency.maintaining' => [
    'url' => '/guides/residency/maintaining-residency/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'residency',
    'title' => 'Maintaining Paraguay Residency',
    'description' => 'Absence, renewal and record-keeping: what keeps a Paraguayan residency in good standing once the cédula is in your hand.',
    'h1' => 'Keeping your residency in good standing', 'nav_label' => 'Maintaining residency',
    'intent' => 'Owns: post-approval compliance and absence.',
],

// ----------------------------------------------------------------- tax -----
'guides.tax' => [
    'url' => '/guides/tax/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'tax',
    'title' => 'Paraguay Tax Guide for Foreign Residents',
    'description' => 'How Paraguay taxes residents, what territoriality does and does not mean, and why your home country may still have a claim on you.',
    'h1' => 'Paraguay tax for foreign residents', 'nav_label' => 'Tax guide',
    'intent' => 'Informational hub: the tax landscape.',
],
'guides.tax.territorial' => [
    'url' => '/guides/tax/territorial-tax/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'tax',
    'title' => 'Paraguay Territorial Tax Explained',
    'description' => 'What a territorial system actually taxes, how income source is determined, and the cases where the answer is genuinely not obvious.',
    'h1' => 'Paraguay territorial taxation', 'nav_label' => 'Territorial tax',
    'intent' => 'Owns: income-source principles.',
],
'guides.tax.vs-legal' => [
    'url' => '/guides/tax/tax-vs-legal-residency/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'tax',
    'title' => 'Tax Residency vs Legal Residency',
    'description' => 'Immigration status, tax registration and tax residency are three different things. Confusing them is the most expensive mistake we see.',
    'h1' => 'Tax residency is not legal residency', 'nav_label' => 'Tax vs legal residency',
    'intent' => 'Owns: the distinction between the two statuses.',
],
'guides.tax.ruc' => [
    'url' => '/guides/tax/ruc/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'tax',
    'title' => 'What Is a RUC in Paraguay?',
    'description' => 'What a RUC is, who needs one, what registering commits you to, and the filing rhythm that starts the day the number is issued.',
    'h1' => 'The RUC explained', 'nav_label' => 'The RUC explained',
    'intent' => 'Owns: RUC registration and ongoing administration.',
],

// --------------------------------------------------------------- other -----
'guides.banking' => [
    'url' => '/guides/banking/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'banking',
    'title' => 'Banking in Paraguay as a Foreign Resident',
    'description' => 'How Paraguayan banks assess foreign applicants, what a source-of-funds file needs to contain, and why no account can be promised.',
    'h1' => 'Banking as a foreign resident', 'nav_label' => 'Banking guide',
    'intent' => 'Informational hub: banking reality and preparation.',
],
'guides.citizenship' => [
    'url' => '/guides/citizenship/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'citizenship',
    'title' => 'Paraguayan Citizenship: What to Know',
    'description' => 'Naturalisation in Paraguay is a discretionary judicial process, not an automatic reward for time served. Here is what that means in practice.',
    'h1' => 'Paraguayan citizenship', 'nav_label' => 'Citizenship',
    'intent' => 'Informational hub: long-horizon expectations.',
],
'guides.living' => [
    'url' => '/guides/living/', 'type' => 'article', 'status' => 'planned', 'cluster' => 'living',
    'title' => 'Living in Paraguay: A Practical Guide',
    'description' => 'Asuncion and beyond — housing, healthcare, schooling, connectivity and cost of living, written for people deciding whether to actually move.',
    'h1' => 'Living in Paraguay', 'nav_label' => 'Living in Paraguay',
    'intent' => 'Informational hub: practical relocation reality.',
],

// -------------------------------------------------------- trust & legal ----
'integrity' => [
    'url' => '/integrity/', 'type' => 'page', 'status' => 'live', 'cluster' => 'trust',
    'title' => 'Our Integrity Promise | Paraguay Frontier',
    'description' => 'What we control, what we cannot control, how we present estimates, and the remedy that applies if our own work causes a problem.',
    'h1' => 'Integrity promise', 'nav_label' => 'Integrity promise',
    'intent' => 'Trust: honest limits before you engage.',
    'last_reviewed' => '2026-08-17',
],
'editorial-standards' => [
    'url' => '/editorial-standards/', 'type' => 'page', 'status' => 'live', 'cluster' => 'trust',
    'title' => 'Editorial Standards | Paraguay Frontier',
    'description' => 'How our guides are researched, sourced, reviewed and corrected — including how to report an error and what we do when you do.',
    'h1' => 'Editorial standards', 'nav_label' => 'Editorial standards',
    'intent' => 'Trust: how the content is produced.',
    'last_reviewed' => '2026-08-17',
],
'faq' => [
    'url' => '/faq/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'trust',
    'title' => 'Paraguay Residency FAQ',
    'description' => 'Direct answers to the questions we are asked most often about Paraguay residency, tax registration, banking and moving to Asuncion.',
    'h1' => 'Frequently asked questions', 'nav_label' => 'FAQ',
    'intent' => 'Informational: quick answers, routed to depth.',
],
'privacy' => [
    'url' => '/privacy/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'legal',
    'title' => 'Privacy Policy | Paraguay Frontier',
    'description' => 'What personal data this site collects, why it is collected, how long it is kept, and how to ask for it to be corrected or deleted.',
    'h1' => 'Privacy policy', 'nav_label' => 'Privacy',
    'intent' => 'Legal.',
],
'terms' => [
    'url' => '/terms/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'legal',
    'title' => 'Terms of Use | Paraguay Frontier',
    'description' => 'The terms governing use of this website, including the general-information disclaimer that applies to every guide published here.',
    'h1' => 'Terms of use', 'nav_label' => 'Terms',
    'intent' => 'Legal.',
],

// ------------------------------------------------------------- utility -----
'thank-you' => [
    'url' => '/thank-you/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'utility', 'index' => false,
    'title' => 'Thank You | Paraguay Frontier',
    'description' => 'Your message has been received.',
    'h1' => 'Message received', 'intent' => 'Post-submission confirmation.',
],
'error-404' => [
    'url' => '/errors/404/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'utility', 'index' => false,
    'title' => 'Page Not Found | Paraguay Frontier',
    'description' => 'That page does not exist.',
    'h1' => 'That page does not exist', 'intent' => 'Error recovery.',
],
'error-500' => [
    'url' => '/errors/500/', 'type' => 'page', 'status' => 'planned', 'cluster' => 'utility', 'index' => false,
    'title' => 'Something Went Wrong | Paraguay Frontier',
    'description' => 'A server error occurred.',
    'h1' => 'Something went wrong', 'intent' => 'Error recovery.',
],

];
