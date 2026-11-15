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
 * Adds instruction headers for Vinyl Cache to the page response.
 *
 * @param array $atts Attributes
 *
 * @return void
 */
function rah_vinyl($atts)
{
    extract(lAtts([
        'ignore' => false,
        'tags' => '',
        'purge' => false,
    ], $atts));

    $tags = $tags
        ? array_map('trim', explode(',', $tags))
        : [];

    if ($ignore) {
        header('X-Pool: ignore');
        return;
    }

    if ($purge) {
        $client = new Rah_Vinyl_Client();

        if ($tags) {
            $client->purge($tags);
        } else {
            $client->purgeAll();
        }

        return;
    }

    if ($tags) {
        Rah_Vinyl_TagRegistry::add($tags);
    }
}
