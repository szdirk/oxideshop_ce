<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Container\Fixtures\CE;

class DummyExecutor
{
    public function execute()
    {
        return 'CE service!';
    }
}
