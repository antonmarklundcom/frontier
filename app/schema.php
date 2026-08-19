<?php
declare(strict_types=1);

/**
 * JSON-LD assembly.
 *
 * Rules enforced here rather than left to the author:
 *  - Organization sameAs is emitted only when real profiles are configured.
 *  - Person / author is emitted only when a real name exists in config.
 *  - Service schema only for pages typed 'service'.
 *  - FAQPage only when the page actually renders visible FAQs.
 *  - No AggregateRating, no Review, no LocalBusiness address until verified.
 */
function schema_graph(array $page, array $crumbs): array
{
    $siteUrl = rtrim((string) site('base_url'), '/');
    $graph = [];

    $org = [
        '@type' => 'Organization',
        '@id'   => $siteUrl . '/#organization',
        'name'  => site('name'),
        'url'   => $siteUrl . '/',
        'description' => t('org_description'),
    ];
    $profiles = site('profiles', []);
    if (is_array($profiles) && $profiles !== []) {
        $org['sameAs'] = array_values($profiles);
    }
    if ($email = real('email')) {
        $org['email'] = $email;
    }
    $graph[] = $org;

    $graph[] = [
        '@type'     => 'WebSite',
        '@id'       => $siteUrl . '/#website',
        'url'       => $siteUrl . '/',
        'name'      => site('name'),
        'inLanguage'=> locale_lang(locale()),
        'publisher' => ['@id' => $siteUrl . '/#organization'],
    ];

    $graph[] = [
        '@type'      => 'WebPage',
        '@id'        => url($page['url']) . '#webpage',
        'url'        => url($page['url']),
        'name'       => $page['title'],
        'description'=> $page['description'],
        'isPartOf'   => ['@id' => $siteUrl . '/#website'],
        'inLanguage' => locale_lang(locale()),
    ];

    if (count($crumbs) > 1) {
        $items = [];
        foreach ($crumbs as $i => $c) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $c['label'], 'item' => url($c['url'])];
        }
        $graph[] = ['@type' => 'BreadcrumbList', '@id' => url($page['url']) . '#breadcrumbs', 'itemListElement' => $items];
    }

    if (($page['type'] ?? '') === 'service') {
        $graph[] = [
            '@type'       => 'Service',
            '@id'         => url($page['url']) . '#service',
            'name'        => $page['h1'],
            'description' => $page['description'],
            'provider'    => ['@id' => $siteUrl . '/#organization'],
            'areaServed'  => ['@type' => 'Country', 'name' => 'Paraguay'],
        ];
    }

    if (($page['type'] ?? '') === 'article' && !empty($page['last_reviewed'])) {
        $article = [
            '@type'           => 'Article',
            '@id'             => url($page['url']) . '#article',
            'headline'        => $page['h1'],
            'description'     => $page['description'],
            'dateModified'    => $page['last_reviewed'],
            'datePublished'   => $page['published'] ?? $page['last_reviewed'],
            'publisher'       => ['@id' => $siteUrl . '/#organization'],
            'mainEntityOfPage'=> ['@id' => url($page['url']) . '#webpage'],
            'inLanguage'      => locale_lang(locale()),
        ];
        if ($author = real('founder')) {
            $article['author'] = ['@type' => 'Person', 'name' => $author];
        } else {
            $article['author'] = ['@id' => $siteUrl . '/#organization'];
        }
        $graph[] = $article;
    }

    // FAQPage is emitted only when the page actually renders a visible FAQ
    // block, so the markup and the structured data can never disagree.
    $faqs = $page['faqs'] ?? [];
    $rendersFaq = false;
    foreach ($page['blocks'] ?? [] as $block) {
        if (($block['type'] ?? '') === 'faq') {
            $rendersFaq = true;
            break;
        }
    }
    if ($faqs !== [] && $rendersFaq) {
        $entities = [];
        foreach ($faqs as $faq) {
            // An answer may be a string or a list of paragraphs.
            // 'a_html' carries trusted markup, like every _html key. Schema.org
            // wants plain text, so it is stripped here rather than escaped —
            // structured data with <em> in it is data a parser has to clean.
            $answer = is_array($faq['a_html']) ? implode(' ', $faq['a_html']) : (string) $faq['a_html'];
            $entities[] = [
                '@type' => 'Question',
                'name'  => $faq['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($answer)],
            ];
        }
        $graph[] = ['@type' => 'FAQPage', '@id' => url($page['url']) . '#faq', 'mainEntity' => $entities];
    }

    return ['@context' => 'https://schema.org', '@graph' => $graph];
}
