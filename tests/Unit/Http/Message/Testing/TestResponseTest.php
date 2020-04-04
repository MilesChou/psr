<?php

namespace Tests\Unit\Http\Message\Testing;

use MilesChou\Psr\Http\Message\ResponseFactory;
use MilesChou\Psr\Http\Message\Testing\TestResponse;
use Tests\TestCase;

class TestResponseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCheckAssertRequest(): void
    {
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(200))->assertOk();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(201))->assertCreated();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(203))->assertSuccessful();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(204))->assertNoContent();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(300))->assertRedirect();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(401))->assertUnauthorized();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(403))->assertForbidden();
        TestResponse::fromBaseResponse((new ResponseFactory())->createResponse(404))->assertNotFound();
    }
}
