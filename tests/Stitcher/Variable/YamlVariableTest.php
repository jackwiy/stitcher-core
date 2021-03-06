<?php

namespace Stitcher\Variable;

use Stitcher\File;
use Stitcher\Test\CreateStitcherObjects;
use Stitcher\Test\StitcherTest;
use Symfony\Component\Yaml\Yaml;

class YamlVariableTest extends StitcherTest
{
    use CreateStitcherObjects;

    /** @test */
    public function it_can_be_parsed(): void
    {
        $path = File::path('/YamlVariableTest_test.yaml');
        File::write($path, <<<EOT
root:
    entry:
        - a
        - b
        - c
EOT
        );

        $variable = YamlVariable::make($path, new Yaml(), $this->createVariableParser())->parse();

        $this->assertTrue(\is_array($variable->getParsed()));
        $this->assertTrue(isset($variable->getParsed()['root']['entry']));
        $this->assertTrue(isset($variable->getParsed()['root']['id']));
        $this->assertEquals('root', $variable->getParsed()['root']['id']);
    }
}
