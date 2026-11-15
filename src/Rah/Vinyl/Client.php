<?php

/*
 * rah_vinyl - Vinyl Cache integration for Textpattern CMS
 * https://github.com/gocom/rah_vinyl
 *
 * Copyright (C) 2026 Jukka Svahn
 *
 * This file is part of rah_vinyl.
 *
 * rah_vinyl is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 2.
 *
 * rah_vinyl is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with rah_vinyl. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Sends request to Vinyl Cache server.
 *
 * ```
 * $action = new Rah_Vinyl_Client();
 * $action->purgeAll();
 * $action->purge('tag1, tag2');
 * ```
 */
final class Rah_Vinyl_Client
{
    private const METHOD_PURGE_ALL = 'PURGEALL';
    private const METHOD_PURGE = 'PURGE';

    /**
     * Config.
     *
     * @var Rah_Vinyl_Config
     */
    private Rah_Vinyl_Config $config;

    /**
     * Build pool string action.
     *
     * @var Rah_Vinyl_BuildPoolStringAction
     */
    private Rah_Vinyl_BuildPoolStringAction $buildPoolStringAction;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->config = new Rah_Vinyl_Config();
        $this->buildPoolStringAction = new Rah_Vinyl_BuildPoolStringAction();
    }

    /**
     * Purges all items from the Vinyl Cache.
     *
     * Sends request with custom HTTP method `PURGEALL` to Vinyl Cache's server,
     * which can be targeted in Vinyl Cache's VCL configuration to execute
     * full cache purging.
     *
     * @return void
     */
    public function purgeAll(): void
    {
        $this->sendRequest(
            self::METHOD_PURGE_ALL
        );
    }

    /**
     * Purges specified tags from the Vinyl Cache.
     *
     * Sends request with custom HTTP method `PURGE` to Vinyl Cache's server.
     * Specified tags are sent in `X-Pool` header as a comma-separated list.
     * The method and header can be targeted in Vinyl Cache's VCL configuration
     * to execute cache purging for the specified tags.
     *
     * @param string[] $tags
     *
     * @return void
     */
    public function purge(array $tags): void
    {
        $this->sendRequest(
            self::METHOD_PURGE,
            $tags
        );
    }

    /**
     * @param string $method
     * @param string[]|null $tags
     *
     * @return void
     */
    private function sendRequest(
        string $method,
        ?array $tags = null
    ): void {
        $baseUrl = $this->config->getBaseUrl();

        if (!$baseUrl || !$method) {
            return;
        }

        $ch = curl_init();
        curl_setopt($ch, \CURLOPT_URL, $baseUrl);
        curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, \CURLOPT_TIMEOUT, 30);

        $tagString = $tags
            ? $this->buildPoolStringAction->execute($tags)
            : null;

        if ($tagString) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                \sprintf('X-Pool: %s', $tagString)
            ]);
        }

        curl_exec($ch);
    }
}
