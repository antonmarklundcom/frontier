<?php
declare(strict_types=1);

/**
 * The locale layer.
 *
 * Content is already separated by locale on disk (`app/content/<locale>/`).
 * This file is the other half: the request knows which locale it is in, and
 * every function that reads content takes that locale as a parameter.
 *
 * Today `config` lists exactly one locale, so every code path below resolves
 * to 'en' and the rendered HTML is unchanged. The plumbing exists now because
 * retrofitting it under 130 written pages costs far more than adding it under
 * three. Full specification: docs/TRANSLATION-ARCHITECTURE.md.
 *
 * The rule that does not bend: a locale appearing in `config['locales']` is a
 * commitment that its pages were professionally localised and reviewed by that
 * locale's own named reviewer. Adding a locale here does not translate
 * anything; it only stops the code from hiding what is already written.
 */

/** Locales this site is configured to serve. The first is the default. */
function locales(): array
{
    $configured = site('locales');
    if (!is_array($configured) || $configured === []) {
        return ['en'];
    }
    return array_values(array_filter($configured, 'is_string'));
}

/** The default locale — the one served at the root, with no URL prefix. */
function default_locale(): string
{
    return locales()[0];
}

/** True when this locale is configured to be served. */
function locale_configured(string $locale): bool
{
    return in_array($locale, locales(), true);
}

/**
 * The locale of the current request. Set once by render_page(); everything
 * downstream reads it rather than being threaded through by hand.
 */
function locale(): string
{
    return $GLOBALS['PF_LOCALE'] ?? default_locale();
}

/**
 * Set the current locale. An unconfigured locale is refused rather than
 * trusted: a route that asks for a locale the site does not serve is a bug,
 * and serving the default is the safe reading of it.
 */
function set_locale(string $locale): string
{
    $resolved = locale_configured($locale) ? $locale : default_locale();
    $GLOBALS['PF_LOCALE'] = $resolved;
    return $resolved;
}

/**
 * BCP 47 tag for <html lang>. The locale codes are already valid language
 * subtags, so this is identity today — it exists so that a regional locale
 * ('pt-BR') has one place to be handled rather than several.
 */
function locale_lang(string $locale): string
{
    return $locale;
}

/**
 * Open Graph wants language_TERRITORY, not a bare language code. Facebook's
 * parser ignores 'en' and falls back to its default, which is why this map
 * exists rather than a bare echo of the locale.
 *
 * Territories are the conventional default for each language, not a claim
 * about audience: og:locale is a content-language signal, and no consumer of
 * it treats the territory as targeting.
 */
function og_locale(string $locale): string
{
    $map = [
        'en' => 'en_US',
        'es' => 'es_ES',
        'de' => 'de_DE',
        'pt' => 'pt_BR',
    ];
    return $map[$locale] ?? $locale;
}

/**
 * The other locales in which a given page id is live, as
 * [locale => absolute URL]. Empty whenever only one locale is configured,
 * which is what keeps hreflang and the language switcher dormant without
 * either of them needing to know why.
 */
function locale_alternates(string $id, string $current): array
{
    $out = [];
    foreach (locales() as $locale) {
        if ($locale === $current) {
            continue;
        }
        $entry = registry($locale)[$id] ?? null;
        if ($entry === null) {
            continue;               // nothing requires parity between locales
        }
        // The registry's status is documentation; resolve_page() is the
        // authority, because a page whose copy is still unwritten resolves to
        // 'draft' no matter what the registry claims. Advertising an
        // alternate that shows an in-preparation notice is worse than
        // advertising none.
        $resolved = resolve_page($id, $locale);
        if ($resolved === null || $resolved['page']['status'] !== 'live') {
            continue;
        }
        $out[$locale] = url($entry['url']);
    }
    return $out;
}
