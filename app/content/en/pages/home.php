<?php
/**
 * Home page content.
 *
 * TRUTH RULES APPLIED HERE: no client counts, no approval rates, no processing
 * times presented as our statistics, no prices, no testimonials, no team names,
 * no guarantees. Where a number would normally go, this page states a policy
 * instead — which is both honest and, against competitors who lead with
 * invented statistics, the stronger differentiator.
 */
declare(strict_types=1);

return [

'hero_theme' => 'ink',

// Frontier Route rail — every stop is a real section id on this page.
'rail' => [
    ['label' => 'Start',        'target' => 'top'],
    ['label' => 'Your stage',   'target' => 'start'],
    ['label' => 'Services',     'target' => 'services'],
    ['label' => 'Our scope',    'target' => 'scope'],
    ['label' => 'The route',    'target' => 'journey'],
    ['label' => 'Guides',       'target' => 'knowledge'],
    ['label' => 'Integrity',    'target' => 'integrity'],
    ['label' => 'Consultation', 'target' => 'consultation'],
],

'blocks' => [

// ---------------------------------------------------------- 01 hero / P1 ---
[
  'type' => 'hero',
  'id'   => 'top',
  'eyebrow' => 'Asunción · residency, tax and banking',
  'h1_html' => 'Paraguay residency is built on <em>paperwork</em>, not promises.',
  'lede' => 'We prepare and run residency, RUC and bank-account applications in Paraguay — and we publish what we know about each one, so you can judge the route before you pay anybody, including us.',
  'note' => 'We do not publish approval rates, client totals or processing-time guarantees. Migraciones decides; we prepare the file and tell you honestly where the uncertainty sits.',
  'cta_primary'   => ['page' => 'services.residency', 'label' => 'Explore residency support'],
  'cta_secondary' => ['page' => 'book',               'label' => 'Book a consultation'],
  'route' => [
    'title' => 'Residency route',
    'stamp' => 'Rev. 2026-08',
    'stages' => [
      ['name' => 'Records and apostilles',         'who' => 'You — against our checklist'],
      ['name' => 'Sworn translation into Spanish', 'who' => 'Paraguayan sworn translator'],
      ['name' => 'Application filed in Asunción',  'who' => 'Us, with you present'],
      ['name' => 'Government review',              'who' => 'Migraciones — outside our control'],
      ['name' => 'Cédula issued',                  'who' => 'Identificaciones'],
      ['name' => 'Keeping the status valid',       'who' => 'You — on a schedule we give you'],
    ],
    'foot' => 'Stages 1–3 and 6 are work we can do with you. Stage 4 is a government decision nobody can promise. We tell you which is which before you pay.',
  ],
],

// ------------------------------------------------------- 02 router / P10 ---
[
  'type' => 'router',
  'id'   => 'start',
  'eyebrow' => 'Start where you actually are',
  'heading' => 'Where are you in the process?',
  'lede' => 'Most Paraguay sites answer one question very loudly. The useful answer depends entirely on which stage you are at — so pick yours.',
  'options' => [
    [
      'slug' => 'researching', 'label' => 'Still researching Paraguay',
      'heading' => 'You are deciding whether Paraguay is even the right country.',
      'body' => 'Before anything else, separate three things that are constantly confused online: immigration status, tax registration, and tax residency. Getting these straight early is what stops people from buying a service that does not do what they thought it did.',
      'links' => ['guides.residency', 'guides.tax.vs-legal', 'guides.living'],
    ],
    [
      'slug' => 'preparing', 'label' => 'Preparing a residency application',
      'heading' => 'You have decided, and now it is a documents problem.',
      'body' => 'Almost every delay we see traces back to a record that was obtained in the wrong order, apostilled by the wrong authority, or issued so long ago that it expired mid-process. The sequence matters as much as the list.',
      'links' => ['guides.residency.requirements', 'guides.residency.documents', 'guides.residency.timeline'],
    ],
    [
      'slug' => 'permanent', 'label' => 'Converting to permanent status',
      'heading' => 'You hold temporary residency and want to know what comes next.',
      'body' => 'Conversion is not automatic and it is not purely a matter of time served. What you did during the temporary period — including your absences and your record-keeping — is part of the picture.',
      'links' => ['guides.residency.temporary-vs-permanent', 'guides.residency.maintaining', 'services.permanent-residency'],
    ],
    [
      'slug' => 'ruc', 'label' => 'Setting up RUC and tax administration',
      'heading' => 'You need a RUC, or you have been told you do.',
      'body' => 'A RUC is a registration, not a tax strategy. Registering starts obligations that continue whether or not you invoice anything, so it is worth understanding what you are signing up for before you apply.',
      'links' => ['guides.tax.ruc', 'guides.tax.territorial', 'services.ruc'],
    ],
    [
      'slug' => 'banking', 'label' => 'Preparing to open a bank account',
      'heading' => 'You want a Paraguayan account and a realistic view of your odds.',
      'body' => 'Paraguayan banks apply their own compliance judgement to every foreign applicant. Nobody can promise you an account. What can be done is preparing a source-of-funds file that gives your application a fair hearing.',
      'links' => ['guides.banking', 'services.banking'],
    ],
    [
      'slug' => 'moving', 'label' => 'Actually moving or investing',
      'heading' => 'You are past the paperwork and thinking about life on the ground.',
      'body' => 'Housing, healthcare, schooling and connectivity decide whether a residency turns into a life or into an unused document. This is the part most residency sites skip entirely.',
      'links' => ['guides.living', 'guides.citizenship'],
    ],
  ],
],

// ----------------------------------------------------- 03 pathways / P3 ----
[
  'type' => 'pathways',
  'id'   => 'services',
  'eyebrow' => 'What we are hired to do',
  'heading' => 'Four pieces of work, scoped separately.',
  'lede' => 'You are not required to buy them together, and we will tell you when you do not need one of them.',
  'items' => [
    [
      'page' => 'services.residency', 'variant' => 'card--ink', 'kicker' => 'Service 01',
      'title' => 'Residency application support',
      'body' => 'We build your document set against current requirements, coordinate sworn translation, assemble the application, and go with you to file it in Asunción. You will know before you start which records you must obtain personally in your own country — nobody can do those for you.',
      'more' => 'Residency support',
    ],
    [
      'page' => 'services.permanent-residency', 'variant' => 'card--accent', 'kicker' => 'Service 02',
      'title' => 'Permanent residency conversion',
      'body' => 'Preparing and filing the conversion from temporary to permanent status, including an honest review of whether your record supports the application yet.',
      'more' => 'Permanent residency',
    ],
    [
      'page' => 'services.ruc', 'variant' => 'card--hair', 'kicker' => 'Service 03',
      'title' => 'RUC and tax registration',
      'body' => 'Registration with DNIT, plus a plain explanation of the filing rhythm that begins the day your number is issued.',
      'more' => 'RUC registration',
    ],
    [
      'page' => 'services.banking', 'variant' => 'card--hair', 'kicker' => 'Service 04',
      'title' => 'Banking preparation',
      'body' => 'Assembling a source-of-funds and identity file to the standard Paraguayan banks expect, and making the introduction. The bank makes its own decision, and sometimes that decision is no.',
      'more' => 'Banking preparation',
    ],
  ],
],

// -------------------------------------------------------- 04 scope / P4 ----
[
  'type' => 'scope',
  'id'   => 'scope',
  'eyebrow' => 'Scope, stated before you pay',
  'heading' => 'What we do, and what we will not claim.',
  'lede' => 'Most of the frustration in this industry comes from a scope that was never written down. Ours is written down, on this page, before you have spoken to us.',
  'yes_heading' => 'Paraguay Frontier does this',
  'yes' => [
    'Tells you which route fits your situation, including when the answer is "none of them yet".',
    'Builds the document checklist for your nationality and profile, in the order the records must be obtained.',
    'Coordinates sworn translation and Paraguayan-side authentication.',
    'Assembles and files the application with you in Asunción.',
    'Tracks the file and tells you what stage it is genuinely at.',
    'Gives you a written schedule for keeping the status valid afterwards.',
  ],
  'no_heading' => 'Paraguay Frontier does not do this',
  'no' => [
    'Promise an approval, a processing time, or a bank account.',
    'Give legal, tax or investment advice — that requires a qualified professional engaged for your situation.',
    'Obtain your home-country police, birth or marriage records for you.',
    'Advise on your home country\'s continuing tax claim on you.',
    'Represent that residency, a RUC or a cédula changes your tax residency by itself.',
    'Offer any route that depends on a document being inaccurate.',
  ],
  'callout' => [
    'label' => 'Read this before you compare providers',
    'text' => 'If a provider quotes you a guaranteed approval or a fixed government processing time, ask them to put it in the service agreement in writing. Government discretion cannot be contracted away, and a promise that cannot survive the contract should not survive the sales call.',
  ],
],

// ------------------------------------------------------ 05 journey / P5 ----
[
  'type' => 'journey',
  'id'   => 'journey',
  'eyebrow' => 'The route in full',
  'heading' => 'Six stages, and only four of them are ours.',
  'lede' => 'The same route as the card at the top of the page, with what each stage actually involves.',
  'steps' => [
    ['who' => 'Stage · you', 'title' => 'Records and apostilles',
     'note' => 'Police certificate, birth record and any marriage record, obtained from the issuing country and apostilled by that country\'s competent authority. Validity windows are short, so the order matters.'],
    ['who' => 'Stage · Paraguay', 'title' => 'Sworn translation',
     'note' => 'Foreign documents are translated into Spanish by a Paraguayan sworn translator. A translation done abroad is usually not accepted.'],
    ['who' => 'Stage · together', 'title' => 'Filing in Asunción',
     'note' => 'The application is assembled and submitted in person. You need to be in Paraguay for parts of this, and we tell you which parts before you book flights.'],
    ['who' => 'Stage · government', 'title' => 'Review and decision',
     'note' => 'Migraciones reviews the file on its own timetable. We do not publish an estimate for this stage, because any number we published would be a guess dressed up as a commitment.'],
    ['who' => 'Stage · government', 'title' => 'Cédula',
     'note' => 'Identity registration and issue of the cédula, which is the document you will actually use day to day in Paraguay.'],
    ['who' => 'Stage · you', 'title' => 'Keeping it valid',
     'note' => 'Residency is a status you maintain, not a certificate you file away. Absence, renewals and record-keeping all matter, and neglecting them is how people quietly lose what they paid for.'],
  ],
],

// ---------------------------------------------------- 06 knowledge / P7 ----
[
  'type' => 'knowledge',
  'id'   => 'knowledge',
  'eyebrow' => 'Knowledge centre',
  'heading' => 'Read first. Hire later, if at all.',
  'lede' => 'Our guides are researched against Paraguayan primary sources, dated, and corrected when the rules move. Several of them will tell you that you do not need us.',
  'cta' => ['page' => 'editorial-standards', 'label' => 'How we research and review'],
  'items' => [
    ['page' => 'guides.residency', 'title' => 'Residency',
     'body' => 'The routes, the sequence, what the government actually decides, and the mistakes that cost people the most time.'],
    ['page' => 'guides.tax', 'title' => 'Tax and the RUC',
     'body' => 'What territorial taxation does and does not mean, and why your home country may still have a claim on your income.'],
    ['page' => 'guides.banking', 'title' => 'Banking',
     'body' => 'How Paraguayan banks assess foreign applicants, and what a source-of-funds file has to contain to get a fair reading.'],
    ['page' => 'guides.citizenship', 'title' => 'Citizenship',
     'body' => 'A discretionary judicial process on a long horizon — not an automatic reward for holding residency for a set number of years.'],
    ['page' => 'guides.living', 'title' => 'Living in Paraguay',
     'body' => 'Housing, healthcare, schooling, connectivity and cost of living, written for people deciding whether to actually move.'],
  ],
],

// ------------------------------------------------------- 07 ribbon / P8 ----
[
  'type' => 'ribbon',
  'id'   => 'standards',
  'items' => [
    ['label' => 'Sources',    'text' => 'Guides cite Paraguayan primary sources — Migraciones, DNIT, the Banco Central and published law — in preference to secondary commentary.'],
    ['label' => 'Dating',     'text' => 'Every guide carries a visible last-reviewed date. If it is stale, you can see that it is stale.'],
    ['label' => 'Review',     'text' => 'Legal and tax pages are held for qualified review before publication. Unreviewed pages stay unpublished.'],
    ['label' => 'Corrections','text' => 'Errors are corrected in place with the date changed, and we tell you how to report one.'],
  ],
],

// ---------------------------------------------------- 08 statement / P9 ----
[
  'type' => 'statement',
  'id'   => 'integrity',
  'eyebrow' => 'Integrity promise',
  'statement_html' => 'We will tell you when the honest answer is <em>don\'t do it yet</em>.',
  'body' => 'Government decisions and processing times sit outside our control, and we would rather lose the engagement than sell you a route your situation does not support. Before you engage us you get the known eligibility risks, the realistic sequence, what is included, and which costs you will pay to somebody other than us.',
  'cta' => ['page' => 'integrity', 'label' => 'Read the full integrity promise'],
],

// ------------------------------------------------------- 09 guides / P6 ----
[
  'type' => 'guides',
  'id'   => 'cornerstone',
  'eyebrow' => 'Start with these three',
  'heading' => 'The pages that answer the most expensive questions.',
  'items' => [
    ['page' => 'guides.residency.documents',
     'summary' => 'Which records need an apostille, which need a sworn translation, and the order to obtain them in so nothing expires mid-application.'],
    ['page' => 'guides.tax.vs-legal',
     'summary' => 'Immigration status, tax registration and tax residency are three separate things. Confusing them is the most expensive mistake we see.'],
    ['page' => 'guides.residency.costs',
     'summary' => 'Government fees, professional fees, translation, travel and ongoing costs — separated, so you can see what is fixed and what is not.'],
  ],
],

// ---------------------------------------------------------- 10 CTA / P1 ----
[
  'type' => 'consultation-cta',
  'id'   => 'consultation',
  'eyebrow' => 'Next step',
  'heading' => 'Book a consultation',
  'body' => 'A paid working session that reviews your actual situation and ends with a written route — or with a clear recommendation not to proceed yet. It is not a sales call with a discovery form attached.',
  'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
  'list_heading' => 'What the session covers',
  'covered' => [
    ['tag' => 'Eligibility', 'text' => 'Which route your nationality, family situation and plans actually support, and what would rule you out.'],
    ['tag' => 'Documents',   'text' => 'The specific records you need to obtain, from which authority, and in what order.'],
    ['tag' => 'Sequencing',  'text' => 'When you need to be physically in Paraguay, and for roughly how long each time.'],
    ['tag' => 'Costs',       'text' => 'What you pay us, what you pay the government, and what you pay third parties directly.'],
    ['tag' => 'Tax',         'text' => 'Where the immigration question ends and where a qualified tax professional needs to take over.'],
    ['tag' => 'Risks',       'text' => 'The parts of your case that a reviewing officer is most likely to question.'],
  ],
  'note' => [
    'label' => 'Who this is not for',
    'text' => 'If you are looking for a guaranteed approval, a same-week cédula, or a structure that depends on a document not being accurate, we are the wrong firm and the consultation will waste your money.',
  ],
],

],
];
