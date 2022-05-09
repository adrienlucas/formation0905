<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageTest extends WebTestCase
{
    public function testTheHomepageIsShown(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful(); // 200 - OK
        $this->assertSelectorTextContains('h1', 'Hello world');
    }

    /**
     * @dataProvider providePeopleToGreet
     */
    public function testItGreetsPeople(string $urlSuffix, string $expectedContent): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello'.$urlSuffix);

        $this->assertResponseIsSuccessful(); // 200 - OK
        $this->assertSelectorTextContains('h1', 'Hello '.$expectedContent);
    }

    public function providePeopleToGreet(): array
    {
        return [
            ['/toto', 'toto'],
            ['/1234', '1234'],
            ['', 'world'],
        ];
    }
}
