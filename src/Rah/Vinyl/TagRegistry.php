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
 * Tag registry.
 *
 * ```
 * $action = new Rah_Vinyl_TagRegistry();
 * $action->add(['tag1', 'tag2']);
 * $action->get();
 * $action->reset();
 * ```
 */
final class Rah_Vinyl_TagRegistry
{
    /**
     * Tags.
     *
     * @var string[]
     */
    static private array $tags = [];

    /**
     * Registers the given tags.
     *
     * @param string[] $tags
     */
    static public function add(array $tags): void
    {
        self::$tags = array_merge(
            self::$tags,
            $tags
        );
    }

    /**
     * Gets registered tags.
     *
     * @return string[]
     */
    static public function get(): array
    {
        return self::$tags;
    }

    /**
     * Resets registered tags.
     */
    static public function reset(): void
    {
        self::$tags = [];
    }
}
