<?php
declare(strict_types=1);

/**
 * Copy slots and draft pages.
 *
 * A page can exist in three states, and the code — not a person's memory —
 * decides which one it is in:
 *
 *   planned  no content file at all. Renders the "in preparation" notice.
 *   draft    a content file exists and carries the finished *structure*, but at
 *            least one piece of copy is still an unwritten slot. Renders the
 *            "in preparation" notice to visitors, the outline in preview mode,
 *            and is never indexed or listed in the sitemap.
 *   live     a content file exists and contains no unwritten slots.
 *
 * A copy slot is any string containing a {{ ... }} brief:
 *
 *     'body' => ['{{ 120-180 words: what an apostille actually certifies }}']
 *
 * The writing pass replaces the whole string with real prose and changes
 * nothing else. When the last slot on a page disappears, the page becomes live
 * on its own — there is no status flag to remember to flip.
 *
 * Slots are never shown to a visitor. In preview mode they render as
 * ⟦ brief ⟧ so an author can read the outline in the real layout; in every
 * other case the page falls back to the in-preparation notice, and
 * tools/qa.php fails the build if a brief ever reaches public HTML.
 */

/** Regex for one brief inside a string. */
const PF_SLOT_RE = '/\{\{\s*(.*?)\s*\}\}/s';

/** True when a value contains an unwritten copy brief. */
function has_slot(mixed $value): bool
{
    if (is_string($value)) {
        return (bool) preg_match(PF_SLOT_RE, $value);
    }
    if (is_array($value)) {
        foreach ($value as $v) {
            if (has_slot($v)) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Every unwritten brief in a structure, with the key path that leads to it.
 * This is what tools/copy-brief.php turns into a writing worklist.
 *
 * @return list<array{path:string,brief:string}>
 */
function slot_briefs(mixed $node, string $path = ''): array
{
    $out = [];
    if (is_string($node)) {
        if (preg_match_all(PF_SLOT_RE, $node, $m)) {
            foreach ($m[1] as $brief) {
                $out[] = ['path' => $path, 'brief' => $brief];
            }
        }
        return $out;
    }
    if (is_array($node)) {
        foreach ($node as $key => $child) {
            $childPath = $path === '' ? (string) $key : $path . '.' . $key;
            // A block's type makes the path readable: blocks.3 -> blocks.3(checklist)
            if (is_array($child) && isset($child['type']) && is_string($child['type'])) {
                $childPath .= '(' . $child['type'] . ')';
            }
            $out = array_merge($out, slot_briefs($child, $childPath));
        }
    }
    return $out;
}

/**
 * Replace briefs with a visible marker for preview rendering.
 * The marker is plain text, not markup, so it survives both the escaped and the
 * raw-HTML fields of the block templates without ever injecting an element.
 */
function mark_slots(mixed $node): mixed
{
    if (is_string($node)) {
        return preg_replace(PF_SLOT_RE, '⟦ $1 ⟧', $node);
    }
    if (is_array($node)) {
        foreach ($node as $k => $v) {
            $node[$k] = mark_slots($v);
        }
    }
    return $node;
}

/**
 * True when a value is either an unwritten brief or the marker a brief renders
 * as in preview. Blocks use it for values that must not be used structurally
 * while unwritten — a URL, an href, a date — as opposed to prose, which is
 * simply shown with its marker.
 */
function unwritten(mixed $value): bool
{
    return !is_string($value) || $value === '' || has_slot($value) || str_contains($value, '⟦');
}

/**
 * True when draft outlines may be rendered instead of the in-preparation
 * notice. Never true on a launched site, whatever the config says — a visitor
 * must not be able to reach an outline full of editorial briefs.
 */
function preview_mode(): bool
{
    $on = (bool) site('preview_drafts') || (bool) getenv('PF_PREVIEW');
    return $on && !site('launched');
}

/**
 * Resolve a page id to its final state: registry entry + content file + the
 * status the content actually justifies. Used by the renderer, the sitemap
 * builder, the QA harness and the copy-brief tool, so all four agree.
 *
 * @return array{page:array,slots:list<array{path:string,brief:string}>}|null
 */
function resolve_page(string $id): ?array
{
    $meta = page($id);
    if ($meta === null) {
        return null;
    }
    $file = PF_APP . '/content/en/pages/' . str_replace('.', '-', $id) . '.php';
    $content = is_file($file) ? require $file : [];
    $page = array_merge($meta, $content);

    if (empty($page['blocks'])) {
        return ['page' => ['status' => 'planned'] + $page, 'slots' => []];
    }

    $slots = slot_briefs($content);
    $page['status'] = $slots === [] ? 'live' : 'draft';

    return ['page' => $page, 'slots' => $slots];
}
