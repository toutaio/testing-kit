<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\DependencyGraph;
use Touta\Aria\Build\Layer;
use Touta\TestingKit\ArchitectureAssertions;

it('passes valid layer rule', function (): void {
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM);

    ArchitectureAssertions::assertLayerRulePasses($molecule, [$molecule, $atom]);

    expect(true)->toBeTrue();
});

it('catches invalid layer rule', function (): void {
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM, ['http-client']);
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE);

    ArchitectureAssertions::assertLayerRuleFails($atom, [$atom, $molecule]);

    expect(true)->toBeTrue();
});

it('passes graph with no cycles', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L2_MOLECULE, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM));

    ArchitectureAssertions::assertNoCycles($graph);

    expect(true)->toBeTrue();
});

it('catches graph with cycles', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L1_ATOM, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM, ['a']));

    ArchitectureAssertions::assertHasCycles($graph);

    expect(true)->toBeTrue();
});

it('throws when valid layer rule expected to fail', function (): void {
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM);

    ArchitectureAssertions::assertLayerRuleFails($molecule, [$molecule, $atom]);
})->throws(RuntimeException::class);

it('throws when invalid layer rule expected to pass', function (): void {
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM, ['http-client']);
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE);

    ArchitectureAssertions::assertLayerRulePasses($atom, [$atom, $molecule]);
})->throws(RuntimeException::class);
