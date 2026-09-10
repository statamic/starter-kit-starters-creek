<?php

// Run against a fresh local installation: php tests/smoke.php http://starters-creek-preview.test
$base = rtrim($argv[1] ?? 'http://starters-creek-preview.test', '/');
$cases = [
    '/' => [200, 'An independent publication'],
    '/archive' => [200, 'Articles from 2026'],
    '/topics' => [200, 'Design &amp; making'],
    '/topics/design' => [200, 'Articles filed under'],
    '/topics/everyday' => [200, 'small notebook'],
    '/topics/culture' => [200, 'donuts'],
    '/about' => [200, 'Contributors'],
    '/attention' => [200, 'Always do more than one thing'],
    '/small-notebook' => [200, 'golf pencils'],
    '/pocket' => [200, 'Pocket lint'],
    '/donuts' => [200, 'donuts'],
    '/idea' => [200, 'language-php'],
    '/would-you-rather' => [200, 'pizza'],
    '/beginnings' => [200, 'Beginnings'],
    '/search?q=notebook' => [200, 'Results for'],
    '/search?q=zzzznonexistent' => [200, 'No articles found'],
    '/search?q=%20%20' => [200, 'Search our articles'],
    '/search?q[]=invalid' => [200, 'Search our articles'],
    '/missing-page' => [404, 'Error 404'],
    '/authors/missing-author' => [404, 'Error 404'],
];
$failures = [];
foreach ($cases as $path => [$expectedStatus, $needle]) {
    $curl = curl_init($base.$path);
    curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20]);
    $html = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $document = new DOMDocument;
    @$document->loadHTML($html ?: '<html></html>');
    $xpath = new DOMXPath($document);
    $text = html_entity_decode($html ?: '');
    if ($status !== $expectedStatus || !str_contains($text, html_entity_decode($needle))) $failures[] = "$path: HTTP $status or missing expected content";
    if ($xpath->query('//h1')->length !== 1) $failures[] = "$path: expected exactly one h1";
    if ($xpath->query('//main')->length !== 1) $failures[] = "$path: missing main landmark";
    $formal = $document->documentElement->getAttribute('data-personality') === 'formal';
    $personalityCopy = [
        '/' => $formal ? ['A closer look at everyday life.', 'Latest article', 'Recent articles', 'Explore by topic'] : ['Life’s weird. Stay curious.', 'Fresh off the brain', 'More rabbit holes', 'Pick a rabbit hole'],
        '/about' => [$formal ? 'Our approach' : 'Our very unofficial motto'],
        '/pocket' => [$formal ? 'Further reading' : 'While you’re down here'],
        '/missing-page' => [$formal ? 'Page not found.' : 'You’re up 404 creek.'],
    ];
    foreach ($personalityCopy[$path] ?? [] as $copy) {
        if (! str_contains($text, $copy)) $failures[] = "$path: missing personality string: $copy";
    }
    $footerCopy = $formal ? 'Independent writing on design, culture, and everyday life.' : 'A small publication. A very large curiosity.';
    if (! str_contains($text, $footerCopy)) $failures[] = "$path: missing personality footer";
    $description = $xpath->query('/html/head/meta[@name="description"]');
    if ($description->length !== 1) $failures[] = "$path: missing description in head";
    if ($xpath->query('/html/body/text()[normalize-space()]')->length) $failures[] = "$path: stray text outside page landmarks";
    if ($path === '/pocket' && $description->item(0)?->getAttribute('content') !== "Pocket lint (also known as gnurr) is one of the world's most unknown, underestimated, and ultimately lethal predators.") {
        $failures[] = "$path: rich-text description was not stripped and escaped correctly";
    }
    $articleSchema = false;
    foreach ($xpath->query('//script[@type="application/ld+json"]') as $script) {
        try {
            $schema = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            $articleSchema = $articleSchema || ($schema['@type'] ?? null) === 'BlogPosting';
        }
        catch (Throwable $e) { $failures[] = "$path: invalid JSON-LD"; }
    }
    if (in_array($path, ['/', '/topics', '/archive', '/about']) && $articleSchema) $failures[] = "$path: article schema on a non-article page";
    if (in_array($path, ['/attention', '/small-notebook', '/idea']) && ! $articleSchema) $failures[] = "$path: missing article schema";
    if (str_contains($html, 'alpine@v2')) $failures[] = "$path: legacy Alpine runtime";
    echo "$status $path\n";
}
if ($failures) { fwrite(STDERR, implode("\n", $failures)."\n"); exit(1); }
echo "All route, metadata, and landmark checks passed.\n";
