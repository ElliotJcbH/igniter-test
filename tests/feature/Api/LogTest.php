<?php

namespace Tests\Feature\Api;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
// use CodeIgniter\Test\ControllerTestTrait;

class LogTest extends CIUnitTestCase
{
    // use ControllerTestTrait;
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = true;
    protected $refresh = true;
    protected $namespace   = 'App';

    protected function setUp(): void
    {
        parent::setUp();

        // Do something here....
    }

    public function testCreateLogViaPost(): void
    {       
        $result = $this->withBodyFormat('json')->post('/api/log', [
            'message' => 'Test log'
        ]);

        $result->assertOK();
        $result->assertStatus(201);
        $result->assertJSONFragment(['message' => 'Test log']);
    }

    public function testCreateLogShouldFailValidation(): void
    {
        $result = $this->withBodyFormat('json')->post('/api/log', [
            "message" => ""
        ]);

        $body = json_decode($result->getJSON(), true, 512, JSON_THROW_ON_ERROR);

        $result->assertNotOK();
        $result->assertStatus(400);
        $this->assertArrayHasKey('message', $body);
        $this->assertSame(
            ['message' => 'The message field is required.'],
            $body
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Do something here....
    }
}
