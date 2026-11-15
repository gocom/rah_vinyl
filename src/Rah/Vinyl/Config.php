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
 * Vinyl Cache server configuration.
 *
 * ```
 * $server = new Rah_Vinyl_Config();
 * $server->getHost();
 * ```
 */
final class Rah_Vinyl_Config
{
    /**
     * Gets hostname.
     *
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        if (defined('\RAH_VINYL_BASEURL')) {
            return \RAH_VINYL_BASEURL;
        }

        return null;
    }
}
