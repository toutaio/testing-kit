<?php

declare(strict_types=1);

namespace Touta\TestingKit;

/**
 * Thrown when an architecture assertion detects a violation.
 *
 * Replaces generic RuntimeException to provide typed, catchable
 * architecture violation reporting in test assertions.
 */
final class ArchitectureViolation extends \RuntimeException {}
