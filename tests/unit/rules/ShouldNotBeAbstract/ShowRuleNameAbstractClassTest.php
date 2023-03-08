<?php

declare(strict_types=1);

namespace Tests\PHPat\unit\rules\ShouldNotBeAbstract;

use PHPat\Configuration;
use PHPat\Rule\Assertion\Declaration\ShouldNotBeAbstract\AbstractRule;
use PHPat\Rule\Assertion\Declaration\ShouldNotBeAbstract\ShouldNotBeAbstract;
use PHPat\Selector\Classname;
use PHPat\Statement\Builder\StatementBuilderFactory;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\FileTypeMapper;
use Tests\PHPat\fixtures\Simple\SimpleAbstractClass;
use Tests\PHPat\unit\FakeTestParser;

/**
 * @extends RuleTestCase<AbstractRule>
 */
class ShowRuleNameAbstractClassTest extends RuleTestCase
{
    public const RULE_NAME = 'test_SimpleAbstractClassShouldNotBeAbstract';
    public function testRule(): void
    {
        $this->analyse(['tests/fixtures/Simple/SimpleAbstractClass.php'], [
            [sprintf('%s: %s should not be abstract', self::RULE_NAME, SimpleAbstractClass::class), 7],
        ]);
    }

    protected function getRule(): Rule
    {
        $testParser = FakeTestParser::create(
            self::RULE_NAME,
            ShouldNotBeAbstract::class,
            [new Classname(SimpleAbstractClass::class, false)],
            []
        );

        return new AbstractRule(
            new StatementBuilderFactory($testParser),
            new Configuration(false, true),
            $this->createReflectionProvider(),
            self::getContainer()->getByType(FileTypeMapper::class)
        );
    }
}
