<?php

declare(strict_types=1);

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

namespace Rah\Vinyl\Test\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BuildPoolStringActionTest extends TestCase
{
    private \Rah_Vinyl_BuildPoolStringAction $subject;

    protected function setUp(): void
    {
        $this->subject = new \Rah_Vinyl_BuildPoolStringAction();
    }

    #[DataProvider('dataProvider')]
    public function testExecute(
        array $input,
        string $expect
    ): void {
        $this->assertSame(
            $expect,
            $this->subject->execute($input)
        );
    }

    public static function dataProvider(): array
    {
        return [
            'basic' => [
                'input' => ['tag1', 'tag2', 'tag3'],
                'expect' => 'tag1, tag2, tag3',
            ],
        ];
    }
}
