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
 * Adds headers action.
 */
final class Rah_Vinyl_AddHeadersAction
{
    /**
     * Adds X-Pool header containing the tags configured on the requested page.
     */
    public function execute(): void
    {
        $registeredTags = Rah_Vinyl_TagRegistry::get();

        if ($registeredTags) {
            Rah_Vinyl_TagRegistry::reset();

            if (in_array(Rah_Vinyl_TagRegistry::TAG_IGNORE, $registeredTags, true)) {
                $this->send(Rah_Vinyl_TagRegistry::TAG_IGNORE);
                return;
            }

            $registeredTags[] = Rah_Vinyl_TagRegistry::TAG_DEFAULT;
            $tags = (new Rah_Vinyl_BuildPoolStringAction())->execute($registeredTags);

            if ($tags) {
                $this->send($tags);
                return;
            }
        }

        $this->send(Rah_Vinyl_TagRegistry::TAG_DEFAULT);
    }

    /**
     * Sends the header.
     *
     * @param string $value
     *
     * @return void
     */
    private function send(string $value): void
    {
        header(\sprintf('X-Pool: %s', $value));
    }
}
