<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use Webmozart\Glob\Glob;

return static fn (Configuration $config): Configuration => $config
    ->setAdditionalFilesFor('codeigniter4/framework', [
        ...Glob::glob(__DIR__ . '/vendor/codeigniter4/framework/system/Helpers/*.php'),
    ]);
