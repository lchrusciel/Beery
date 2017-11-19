<?php

declare(strict_types=1);

namespace Tests\Behat\Service;

use Coduo\PHPMatcher\Lexer;
use Coduo\PHPMatcher\Matcher;
use Coduo\PHPMatcher\Parser;

final class MatcherFactory
{
    public static function buildJsonMatcher(): Matcher
    {
        return self::buildMatcher(Matcher\JsonMatcher::class);
    }

    private static function buildMatcher(string $matcherClass): Matcher
    {
        $orMatcher = self::buildOrMatcher();
        $chainMatcher = new Matcher\ChainMatcher([
            new $matcherClass($orMatcher),
        ]);

        return new Matcher($chainMatcher);
    }

    private static function buildOrMatcher(): Matcher\ChainMatcher
    {
        $scalarMatchers = self::buildScalarMatchers();
        $orMatcher = new Matcher\OrMatcher($scalarMatchers);
        $arrayMatcher = new Matcher\ArrayMatcher(
            new Matcher\ChainMatcher([
                $orMatcher,
                $scalarMatchers,
            ]),
            self::buildParser()
        );
        $chainMatcher = new Matcher\ChainMatcher([
            $orMatcher,
            $arrayMatcher,
        ]);

        return $chainMatcher;
    }

    private static function buildScalarMatchers(): Matcher\ChainMatcher
    {
        $parser = self::buildParser();

        return new Matcher\ChainMatcher([
            new Matcher\CallbackMatcher(),
            new Matcher\ExpressionMatcher(),
            new Matcher\NullMatcher(),
            new Matcher\StringMatcher($parser),
            new Matcher\IntegerMatcher($parser),
            new Matcher\BooleanMatcher(),
            new Matcher\DoubleMatcher($parser),
            new Matcher\NumberMatcher(),
            new Matcher\ScalarMatcher(),
            new Matcher\WildcardMatcher(),
        ]);
    }

    private static function buildParser(): Parser
    {
        return new Parser(new Lexer(), new Parser\ExpanderInitializer());
    }
}
