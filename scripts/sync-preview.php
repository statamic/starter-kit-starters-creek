<?php

// Copies kit-owned files only. It never copies users, .env, or application config.
// Usage: php scripts/sync-preview.php /absolute/path/to/preview
$source = dirname(__DIR__);
$target = realpath($argv[1] ?? '');
if (! $target || $target === $source || ! is_file($target.'/artisan') || ! is_file($target.'/vendor/autoload.php')) {
    fwrite(STDERR, "Supply the path to a separate installed Statamic application.\n");
    exit(1);
}
require $target.'/vendor/autoload.php';
$paths = Symfony\Component\Yaml\Yaml::parseFile($source.'/starter-kit.yaml')['export_paths'];
$paths[] = 'starter-kit.yaml';
foreach ($paths as $path) {
    if (is_dir($source.'/'.$path)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source.'/'.$path, FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if (! $file->isFile()) continue;
            $relative = substr($file->getPathname(), strlen($source) + 1);
            if (! is_dir(dirname($target.'/'.$relative))) mkdir(dirname($target.'/'.$relative), 0777, true);
            copy($file->getPathname(), $target.'/'.$relative);
            touch($target.'/'.$relative);
        }
    } else {
        if (! is_dir(dirname($target.'/'.$path))) mkdir(dirname($target.'/'.$path), 0777, true);
        copy($source.'/'.$path, $target.'/'.$path);
        touch($target.'/'.$path);
    }
}
chdir($target);
passthru(escapeshellarg(PHP_BINARY).' artisan statamic:stache:clear', $status);
if ($status !== 0) exit($status);
passthru(escapeshellarg(PHP_BINARY).' artisan statamic:search:update --all', $status);
exit($status);
