<?php
/**
 * Renders one page exercising every block template, with synthetic content.
 *
 *   php tools/block-preview.php > /tmp/blocks.html
 *
 * Why this exists: most block templates are not on any written page yet, so
 * the byte-identity check that guards template refactors says nothing about
 * them — a block can be broken for weeks and no rendered route will notice.
 * This is the smallest thing that exercises all of them at once.
 *
 * The synthetic copy is obvious nonsense on purpose. It is not content, it
 * never reaches a route, and nothing here may be mistaken for a real claim
 * about Paraguay: no dates, no prices, no durations, no statistics.
 */

declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';

/**
 * The synthetic page. Returned rather than rendered so tools/qa.php can render
 * it too — a block that only this tool exercises is a block nobody runs.
 */
function block_preview_page(): array
{
    $lorem = 'Sample sentence for layout inspection only, carrying no claim of any kind.';

    return [
    'id' => 'block-preview', 'url' => '/block-preview/', 'type' => 'article',
    'status' => 'live', 'index' => false, 'cluster' => 'utility',
    'title' => 'Block preview', 'description' => $lorem, 'h1' => 'Every block, on one page',
    'intent' => 'internal', 'last_reviewed' => null,
    'faqs' => [
        ['q' => 'A question, rendered by the faq block?', 'a_html' => [$lorem]],
        ['q' => 'A second question, so the collapsed state is visible?', 'a_html' => [$lorem]],
    ],
    'blocks' => [
        ['type' => 'page-header', 'eyebrow' => 'Preview', 'intro' => $lorem],
        ['type' => 'quick-answer', 'question' => 'Does every block render?',
         'answer_html' => [$lorem, $lorem], 'points_html' => ['First load-bearing point', 'Second point'],
         'caveat_html' => 'The condition under which the answer above stops holding.'],
        ['type' => 'definition', 'term' => 'A term being defined', 'body_html' => [$lorem],
         'not_html' => ['Something it is commonly confused with'], 'spanish' => 'término de ejemplo'],
        ['type' => 'statement', 'eyebrow' => 'Statement', 'statement_html' => 'An oversized statement, <em>emphasised</em>.',
         'body' => $lorem, 'cta' => ['page' => 'integrity', 'label' => 'Read the integrity promise']],
        ['type' => 'prose', 'id' => 'prose', 'eyebrow' => 'Prose', 'heading' => 'A prose section',
         'body_html' => [
            $lorem,
            ['type' => 'h3', 'text' => 'A subheading inside prose'],
            ['type' => 'list', 'items_html' => ['A list item', 'Another list item']],
            ['type' => 'defs', 'items' => [['term' => 'A defined term', 'def_html' => $lorem]]],
         ]],
        ['type' => 'checklist', 'eyebrow' => 'Checklist', 'heading' => 'A checklist',
         'intro_html' => [$lorem], 'footnote_html' => 'A closing note under the checklist.',
         'groups' => [['title' => 'A group', 'note_html' => 'A note about this group.',
            'items' => [
              ['item_html' => 'An item to tick off', 'note_html' => 'A note on the item',
               'who' => 'You', 'validity' => 'Check validity before travelling'],
              ['item_html' => 'A second item'],
            ]]]],
        ['type' => 'steps', 'eyebrow' => 'Sequence', 'heading' => 'An ordered sequence',
         'intro_html' => [$lorem], 'footnote_html' => 'A closing note under the steps.',
         'items' => [
            ['title' => 'The first stage', 'body_html' => [$lorem], 'who' => 'You',
             'blocker_html' => 'The thing that most often holds this stage up.'],
            ['title' => 'The second stage', 'body_html' => [$lorem], 'who' => 'Government'],
         ]],
        ['type' => 'comparison', 'eyebrow' => 'Side by side', 'heading' => 'A decision table',
         'caption' => 'A comparison of two options across two dimensions.',
         'intro_html' => [$lorem], 'footnote_html' => 'A closing note under the table.',
         'row_header' => 'Dimension', 'columns' => ['First option', 'Second option'],
         'rows' => [
            ['label' => 'A dimension', 'cells_html' => ['A cell', 'Another cell']],
            ['label' => 'Another dimension', 'cells_html' => ['A cell with <em>emphasis</em>', 'A cell']],
         ]],
        ['type' => 'callout', 'label' => 'A caution', 'body_html' => [$lorem]],
        ['type' => 'sources', 'eyebrow' => 'Sources', 'heading' => 'What this page rests on',
         'intro_html' => [$lorem],
         'items' => [
            ['name' => 'A named primary source', 'authority' => 'The issuing authority',
             'note_html' => 'What this source establishes.', 'url' => 'https://example.org/'],
            ['name' => 'A source whose URL has not been recorded', 'authority' => 'Another authority'],
         ]],
        ['type' => 'reviewer', 'reviewer_key' => 'legal_reviewer'],
        ['type' => 'faq'],
        ['type' => 'next-step', 'eyebrow' => 'Next step', 'heading' => 'A quiet call to action',
         'body_html' => [$lorem], 'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
         'secondary' => ['page' => 'process', 'label' => 'See how it works'],
         'diy_html' => 'The honest note that a reader may not need us at all.'],
        ['type' => 'related', 'items' => [
            ['page' => 'guides.residency'], ['page' => 'guides.tax'], ['page' => 'integrity'],
         ]],
        // The enquiry form renders on no written page yet (/book-consultation/
        // is still a draft), so without this it would be edited blind.
        ['type' => 'form', 'id' => 'enquiry', 'eyebrow' => 'Enquiry',
         'heading' => 'The enquiry form', 'intro_html' => [$lorem]],
        ['type' => 'consultation-cta', 'eyebrow' => 'Consultation', 'heading' => 'A consultation call',
         'body' => $lorem, 'list_heading' => 'Who this is for',
         'cta' => ['page' => 'book', 'label' => 'Book a consultation'],
         'covered' => [
            ['tag' => 'Suits', 'text' => 'Someone this call is for.'],
            ['tag' => 'Does not suit', 'text' => 'Someone it is not for.'],
         ],
         'note' => ['label' => 'A note beside the list', 'text' => $lorem]],
    ],
    ];
}

/**
 * The string each block leaves in the HTML when it renders.
 *
 * Explicit rather than derived from the type name, because the class prefixes
 * are deliberately short and do not match ('page-header' emits 'phead',
 * 'quick-answer' emits 'qanswer'). A derived marker would have silently
 * "passed" for every block whose prefix it guessed wrong, which is the
 * failure mode a coverage check exists to prevent.
 *
 * @return array<string,string> block type => marker that must appear
 */
function block_preview_markers(): array
{
    return [
        'page-header'      => 'class="phead"',
        'quick-answer'     => 'class="qanswer"',
        'definition'       => 'class="def-sec"',
        'statement'        => 'class="statement-sec"',
        'prose'            => 'class="prose-sec"',
        'checklist'        => 'class="check-sec"',
        'steps'            => 'class="steps-sec"',
        'comparison'       => 'class="cmp-sec"',
        'callout'          => 'class="callout-sec"',
        'sources'          => 'class="src-sec"',
        'reviewer'         => 'class="rev-sec"',
        'faq'              => 'class="faq-sec"',
        'next-step'        => 'class="next-sec"',
        'related'          => 'class="related-sec"',
        'consultation-cta' => 'cta__card',
        'form'             => 'class="formwrap"',
    ];
}

/** Crumbs for the preview, so the layout renders exactly as a real page does. */
function block_preview_crumbs(): array
{
    return [
        ['label' => t('breadcrumb_home'), 'url' => '/'],
        ['label' => 'Block preview', 'url' => '/block-preview/'],
    ];
}

// Rendered only when this file is the program, not when qa.php requires it.
if (isset($argv[0]) && realpath($argv[0]) === __FILE__) {
    set_locale(default_locale());
    partial('layout', ['page' => block_preview_page(), 'crumbs' => block_preview_crumbs()]);
}
