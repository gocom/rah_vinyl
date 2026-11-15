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
 * Get pool tags action.
 *
 * ```
 * $action = new Rah_Vinyl_BuildPoolStringAction();
 * $action->execute('tag1, tag2');
 * ```
 */
final class Rah_Vinyl_BuildPoolStringAction
{
    /**
     * Gets sanitized X-Pool header tag list string.
     *
     * @param string[] $tags
     *
     * @return string
     */
    public function execute(array $tags): string
    {
        $cleaned = \array_map(
            fn ($tag) => (string) \preg_replace('/[^a-z0-9_\-]/i', '', $tag),
            $tags
        );

        return \join(', ', \array_unique(\array_filter($cleaned)));
    }
}
