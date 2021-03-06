<?php

declare(strict_types=1);

namespace Roave\BackwardCompatibility\DetectChanges\BCBreak\PropertyBased;

use Roave\BackwardCompatibility\Change;
use Roave\BackwardCompatibility\Changes;
use Roave\BackwardCompatibility\Formatter\ReflectionPropertyName;
use Roave\BetterReflection\Reflection\ReflectionProperty;
use function sprintf;
use function var_export;

final class PropertyDefaultValueChanged implements PropertyBased
{
    /** @var ReflectionPropertyName */
    private $formatProperty;

    public function __construct()
    {
        $this->formatProperty = new ReflectionPropertyName();
    }

    public function __invoke(ReflectionProperty $fromProperty, ReflectionProperty $toProperty) : Changes
    {
        $fromPropertyDefaultValue = $fromProperty->getDefaultValue();
        $toPropertyDefaultValue   = $toProperty->getDefaultValue();

        if ($fromPropertyDefaultValue === $toPropertyDefaultValue) {
            return Changes::empty();
        }

        return Changes::fromList(Change::changed(
            sprintf(
                'Property %s changed default value from %s to %s',
                $this->formatProperty->__invoke($fromProperty),
                var_export($fromPropertyDefaultValue, true),
                var_export($toPropertyDefaultValue, true)
            ),
            true
        ));
    }
}
