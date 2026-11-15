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
 * Plugin class.
 */
final class Rah_Vinyl_Main
{
    private const DEFAULT_TAG = 'Textpattern';

    /**
     * Constructor.
     */
    public function __construct()
    {
        Txp::get('\Textpattern\Tag\Registry')->register('rah_vinyl', 'rah_vinyl');
        register_callback([$this, 'flushCache'], 'site.update');
        register_callback([$this, 'addHeaders'], 'textpattern_end');
    }

    /**
     * Flushes cache.
     *
     * Sends request with custom HTTP method `PURGEALL` to Vinyl Cache's server.
     * This method is triggered automatically when Textpattern's lastmod
     * date is updated.
     */
    public function flushCache(): void
    {
        $client = new Rah_Vinyl_Client();
        $client->purgeAll();
    }

    /**
     * Adds X-Pool header containing the tags configured on the requested page.
     */
    public function addHeaders(): void
    {
        $registeredTags = Rah_Vinyl_TagRegistry::get();

        if ($registeredTags) {
            $registeredTags[] = self::DEFAULT_TAG;
            $tags = (new Rah_Vinyl_BuildPoolStringAction())->execute($registeredTags);

            if ($tags) {
                header(\sprintf('X-Pool: %s', $tags));
            }

            Rah_Vinyl_TagRegistry::reset();
        }
    }
}
