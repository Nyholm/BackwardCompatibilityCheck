<?php

declare(strict_types=1);

namespace Roave\BackwardCompatibility\Git;

use Psl;
use Psl\Filesystem;

use function dirname;

/** @psalm-immutable */
final class CheckedOutRepository
{
    /** @param non-empty-string $path */
    private function __construct(private readonly string $path)
    {
    }

    /** @param non-empty-string $path */
    public static function fromPath(string $path): self
    {
        $testPath = $path;

        do {
            if (Filesystem\is_directory($testPath . '/.git')) {
                return new self($path);
            }

            $testPath = dirname($path);
        } while ($testPath !== '.');

        Psl\invariant_violation('Directory "%s" is not in a GIT repository.', $path);
    }

    /** @return non-empty-string */
    public function __toString(): string
    {
        return $this->path;
    }
}
