<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\DependencyGraph;
use Touta\Aria\Build\Layer;
use Touta\TestingKit\ArchitectureAssertions;
use Touta\TestingKit\ArchitectureViolation;

// Scenario: molecule depending on atom passes layer rule validation
it('passes valid layer rule', function (): void {
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM);

    ArchitectureAssertions::assertLayerRulePasses($molecule, [$molecule, $atom]);

    expect(true)->toBeTrue();
});

// Scenario: atom depending on molecule fails layer rule validation
it('catches invalid layer rule', function (): void {
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM, ['http-client']);
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE);

    ArchitectureAssertions::assertLayerRuleFails($atom, [$atom, $molecule]);

    expect(true)->toBeTrue();
});

// Scenario: acyclic dependency graph passes cycle detection
it('passes graph with no cycles', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L2_MOLECULE, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM));

    ArchitectureAssertions::assertNoCycles($graph);

    expect(true)->toBeTrue();
});

// Scenario: cyclic dependency graph is detected by assertHasCycles
it('catches graph with cycles', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L1_ATOM, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM, ['a']));

    ArchitectureAssertions::assertHasCycles($graph);

    expect(true)->toBeTrue();
});

// Scenario: assertLayerRuleFails throws when rule actually passes
it('throws when valid layer rule expected to fail', function (): void {
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM);

    ArchitectureAssertions::assertLayerRuleFails($molecule, [$molecule, $atom]);
})->throws(ArchitectureViolation::class);

// Scenario: assertLayerRulePasses throws when rule actually fails
it('throws when invalid layer rule expected to pass', function (): void {
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM, ['http-client']);
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE);

    ArchitectureAssertions::assertLayerRulePasses($atom, [$atom, $molecule]);
})->throws(ArchitectureViolation::class);

// Scenario: ArchitectureViolation extends RuntimeException for catchability
it('is a RuntimeException subclass', function (): void {
    $exception = new ArchitectureViolation('test message');

    expect($exception)->toBeInstanceOf(\RuntimeException::class);
});

// Scenario: ArchitectureViolation preserves descriptive violation message
it('carries the violation message', function (): void {
    $exception = new ArchitectureViolation('layer rule violated');

    expect($exception->getMessage())->toBe('layer rule violated');
});
