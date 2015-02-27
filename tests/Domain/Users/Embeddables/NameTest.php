<?php namespace Maatwebsite\Usher\Tests\Domain\Users\Embeddables;

use Maatwebsite\Usher\Domain\Users\Embeddables\Name;
use Maatwebsite\Usher\Tests\TestCase;

class NameTest extends TestCase
{

    public function test_name_requires_first_and_lastname()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');

        new Name(null, null);
    }


    public function test_name_requires_firstname()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');

        new Name(null, 'Test');
    }


    public function test_name_requires_lastname()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');

        new Name('Test', null);
    }


    public function test_valid_name()
    {
        $name = new Name('Patrick', 'Brouwers');

        $this->assertInstanceOf('Maatwebsite\Usher\Domain\Users\Embeddables\Name', $name);
    }


    public function test_name_too_string_should_display_full_name()
    {
        $name = new Name('Patrick', 'Brouwers');
        $this->assertEquals('Patrick Brouwers', (string) $name);
    }
}
