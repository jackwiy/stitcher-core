<?php

namespace Stitcher\Test;

use Stitcher\File;
use Symfony\Component\Filesystem\Filesystem;

final class SetUp
{
    private const TEST_PROJECT = 'test_project';

    public static function run(): void
    {
        $fs = new Filesystem();

        $fs->mirror(
            __DIR__. '/' . self::TEST_PROJECT,
            __DIR__ . '/../' . self::TEST_PROJECT
        );

        File::base(__DIR__ . '/../' . self::TEST_PROJECT);
    }
}
