<?php declare(strict_types=1);

namespace Models;


use Orkester\Manager;
use OrkesterSample\Models\TagModel;
use PHPUnit\Framework\TestCase;

class RetrieveTest extends TestCase
{
    public function testCriteria(): void
    {
        Manager::init();
        TagModel::getCriteria()->asResult();
        $this->assertTrue(true);
    }
}
