<?php

declare(strict_types=1);

namespace Tests\Behat\Service;

use Coduo\PHPMatcher\Matcher;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class JsonAsserter implements JsonAsserterInterface
{
    /** @var Matcher */
    private $matcher;

    public function __construct()
    {
        $this->matcher = MatcherFactory::buildJsonMatcher();
    }

    /**
     * {@inheritdoc}
     */
    public function assertResponse(Response $response, int $code, string $expectedContent): void
    {
        $this->assertResponseHeader($response);
        $this->assertResponseCode($response, $code);
        $this->assertResponseContent($response, $expectedContent);
    }

    /**
     * {@inheritdoc}
     */
    public function assertResponseContent(Response $response, string $expectedContent): void
    {
        $result = $this->matcher->match($response->getContent(), $expectedContent);

        if (!$result) {
            $diff = new \Diff(explode(PHP_EOL, $expectedContent), explode(PHP_EOL, $response->getContent()), []);

            throw new \InvalidArgumentException($diff->render(new \Diff_Renderer_Text_Unified()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function assertResponseCode(Response $response, int $code): void
    {
        $responseCode = $response->getStatusCode();

        Assert::same($code, $responseCode, sprintf(
            'Expected code %s number("%s"), but %s("%s") received',
            $code,
            Response::$statusTexts[$code],
            $responseCode,
            Response::$statusTexts[$responseCode]
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function assertResponseHeader(Response $response): void
    {
        Assert::true(
            $response->headers->contains('Content-Type', 'application/json'),
            'Response header doesn\'t contains the \'application/json\' header'
        );
    }
}
