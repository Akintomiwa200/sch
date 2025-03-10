<?php
namespace Dotenv\Tests;

use Dotenv\Dotenv;

class DotenvTest extends \PHPUnit\Framework\TestCase
{
    public function testLoadEnvVariables()
    {
        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();

        $this->assertEquals('value', getenv('KEY'));
    }
}
