<?php

declare(strict_types=1);

class ViteService
{
    protected static string $publicPath = '/var/www/html/public';
    protected static string $indexEntry = 'src/TypeScript/app.ts';

    /**
     * @throws \Exception
     */
    public static function render(string $resolve)
    {
        if (!in_array($resolve, ['head', 'body'])) {
            throw new \Exception(
                sprintf(
                    'Can not resolve "%s". Available values are: "head" | "body".',
                    $resolve
                ),
                1635708161
            );
        }

        $publicPath = self::$publicPath;
        $indexEntry = self::$indexEntry;
        $distPath = "${publicPath}/dist";

        $devServerIsRunning = self::isDevServerRunning($distPath);

        if ($devServerIsRunning) {
            $devServerUri = self::getDevServerUri();
            if ($resolve === 'head') {
                return <<<HTML
                    <script type="module" src="{$devServerUri}/dist/@vite/client"></script>
                HTML;
            } elseif ($resolve === 'body') {
                return <<<HTML
                    <script type="module" src="{$devServerUri}/dist/{$indexEntry}"></script>
                HTML;
            }

            return;
        }

        $manifest = json_decode(file_get_contents(
            "${distPath}/manifest.json"
        ), true);

        $entry = $manifest[$indexEntry];

        if ($resolve === 'head' && isset($entry['css'])) {
            return <<<HTML
                <link rel="stylesheet" href="/dist/{$entry['css'][0]}">
            HTML;
        }

        if ($resolve === 'body') {
            return <<<HTML
                <script type="module" src="/dist/{$entry['file']}"></script>
            HTML;
        }
    }

    /**
     * Retrieving via dot-env (.env) file the protocol-scheme
     * and base-domain to know where the vite-client js is deposited.
     *
     * The env-value PROTOCOL_SCHEME represents (probably due to DDEV-Local)
     * "https" while the BASE_DOMAIN can be anything e.g. project-name.ddev.site
     * the server-port will be appended for vitejs/vite + HMR.
     */
    private static function getDevServerUri(): string
    {
        return self::env('PROTOCOL_SCHEME').'://'.self::env('BASE_DOMAIN').':'.self::env('HMR_PORT');
    }

    /**
     * Handling if the current (frontend-)request was made while
     * the dev-server (vitejs/vite watcher) is running or not.
     */
    private static function isDevServerRunning(string $distPath): bool
    {
        $hotPath = "${distPath}/hot";
        $devServerIsRunning = false;

        $isDevelopment = self::env('APP_ENV') === 'development';

        if ($isDevelopment && file_exists($hotPath)) {
            try {
                $devServerIsRunning = trim(file_get_contents($hotPath)) === 'development';
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $devServerIsRunning;
    }

    private static function env(string $key)
    {
        return getenv($key) !== false ? getenv($key) : ($_ENV[$key] !== false ? $_ENV[$key] : false);
    }
}
