<?php

declare(strict_types=1);

namespace Touta\TestingKit;

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\DependencyGraph;
use Touta\Aria\Build\LayerRule;

final class ArchitectureAssertions
{
    /**
     * @param array<ComponentDescriptor> $allComponents
     *
     * @throws \RuntimeException
     */
    public static function assertLayerRulePasses(ComponentDescriptor $component, array $allComponents): void
    {
        $result = (new LayerRule())->validate($component, $allComponents);

        if ($result->isFailure()) {
            throw new \RuntimeException(
                "Expected layer rule to pass for \"{$component->name}\", but it failed",
            );
        }
    }

    /**
     * @param array<ComponentDescriptor> $allComponents
     *
     * @throws \RuntimeException
     */
    public static function assertLayerRuleFails(ComponentDescriptor $component, array $allComponents): void
    {
        $result = (new LayerRule())->validate($component, $allComponents);

        if ($result->isSuccess()) {
            throw new \RuntimeException(
                "Expected layer rule to fail for \"{$component->name}\", but it passed",
            );
        }
    }

    /**
     * @throws \RuntimeException
     */
    public static function assertNoCycles(DependencyGraph $graph): void
    {
        if ($graph->hasCycle()) {
            throw new \RuntimeException('Expected no cycles in the dependency graph, but a cycle was found');
        }
    }

    /**
     * @throws \RuntimeException
     */
    public static function assertHasCycles(DependencyGraph $graph): void
    {
        if (!$graph->hasCycle()) {
            throw new \RuntimeException('Expected cycles in the dependency graph, but none were found');
        }
    }
}
