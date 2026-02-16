<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\TypeDeclaration\Rector\Empty_\EmptyOnNullableObjectToInstanceOfRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

return RectorConfig::configure()
    ->withPhpSets(php81: true)
    ->withPreparedSets(deadCode: true, codeQuality: true)
    ->withComposerBased(phpunit: true)
    ->withParallel(120, 8, 10)
    ->withCache(
        is_dir('/tmp') ? '/tmp/rector' : null,
        FileCacheStorage::class,
    )
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withAutoloadPaths([
        __DIR__ . '/vendor/autoload.php',
    ])
    ->withBootstrapFiles([
        __DIR__ . '/vendor/codeigniter4/framework/system/Test/bootstrap.php',
    ])
    ->withPHPStanConfigs([
        __DIR__ . '/phpstan.neon.dist',
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withSkip([
        StringifyStrNeedlesRector::class,
        RemoveUnusedPromotedPropertyRector::class, // Note: requires php 8
    ])
    ->withRules([
        ChangeIfElseValueAssignToEarlyReturnRector::class,
        ChangeNestedForeachIfsToEarlyContinueRector::class,
        CountArrayToEmptyArrayComparisonRector::class,
        DisallowedEmptyRuleFixerRector::class,
        EmptyOnNullableObjectToInstanceOfRector::class,
        FuncGetArgsToVariadicParamRector::class,
        MakeInheritedMethodVisibilitySameAsParentRector::class,
        PreparedValueToEarlyReturnRector::class,
        PrivatizeFinalClassPropertyRector::class,
        RemoveAlwaysElseRector::class,
        SimplifyUselessVariableRector::class,
        StringClassNameToClassConstantRector::class,
        VersionCompareFuncCallToConstantRector::class,
    ])
    ->withConfiguredRule(TypedPropertyFromAssignsRector::class, [
        // Allow public property inlining when BC breaks are acceptable.
        TypedPropertyFromAssignsRector::INLINE_PUBLIC => true,
    ]);
