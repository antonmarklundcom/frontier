<?php
/**
 * Navigation and footer structure. Referenced by page id so a URL change in the
 * registry propagates everywhere without touching markup.
 */
declare(strict_types=1);

return [
    // Primary navigation. 'children' renders a restrained two-column panel.
    'primary' => [
        ['label' => 'Residency', 'page' => 'guides.residency', 'children' => [
            ['label' => 'Residency guide',        'page' => 'guides.residency',            'note' => 'Start here'],
            ['label' => 'Requirements',           'page' => 'guides.residency.requirements'],
            ['label' => 'Documents & apostilles', 'page' => 'guides.residency.documents'],
            ['label' => 'Costs',                  'page' => 'guides.residency.costs'],
            ['label' => 'Timeline',               'page' => 'guides.residency.timeline'],
            ['label' => 'Temporary vs permanent', 'page' => 'guides.residency.temporary-vs-permanent'],
            ['label' => 'Maintaining residency',  'page' => 'guides.residency.maintaining'],
        ]],
        ['label' => 'Services', 'page' => 'services', 'children' => [
            ['label' => 'Residency support',        'page' => 'services.residency'],
            ['label' => 'Permanent residency',      'page' => 'services.permanent-residency'],
            ['label' => 'RUC & tax registration',   'page' => 'services.ruc'],
            ['label' => 'Banking preparation',      'page' => 'services.banking'],
            ['label' => 'Packages',                 'page' => 'packages'],
            ['label' => 'How it works',             'page' => 'process'],
        ]],
        ['label' => 'Tax & RUC', 'page' => 'guides.tax', 'children' => [
            ['label' => 'Tax guide',                'page' => 'guides.tax'],
            ['label' => 'Territorial tax',          'page' => 'guides.tax.territorial'],
            ['label' => 'Tax vs legal residency',   'page' => 'guides.tax.vs-legal'],
            ['label' => 'The RUC explained',        'page' => 'guides.tax.ruc'],
        ]],
        ['label' => 'Banking',  'page' => 'guides.banking'],
        ['label' => 'Living',   'page' => 'guides.living'],
        ['label' => 'About',    'page' => 'about'],
    ],

    // Footer columns. The heading is a labelled value rather than an array key:
    // a key cannot be translated without changing the structure, and a
    // structure that differs per locale is a structure every template has to
    // special-case. 'pages' lists registry ids, so a URL change propagates.
    'footer' => [
        ['heading' => 'Services',         'pages' => ['services.residency', 'services.permanent-residency', 'services.ruc', 'services.banking', 'packages', 'process']],
        ['heading' => 'Residency guides', 'pages' => ['guides.residency', 'guides.residency.requirements', 'guides.residency.documents', 'guides.residency.costs', 'guides.residency.timeline', 'guides.residency.temporary-vs-permanent', 'guides.residency.maintaining']],
        ['heading' => 'Tax & banking',    'pages' => ['guides.tax', 'guides.tax.territorial', 'guides.tax.vs-legal', 'guides.tax.ruc', 'guides.banking']],
        ['heading' => 'Paraguay',         'pages' => ['guides.living', 'guides.citizenship']],
        ['heading' => 'Company',          'pages' => ['about', 'integrity', 'editorial-standards', 'faq', 'book']],
        ['heading' => 'Legal',            'pages' => ['privacy', 'terms']],
    ],
];
