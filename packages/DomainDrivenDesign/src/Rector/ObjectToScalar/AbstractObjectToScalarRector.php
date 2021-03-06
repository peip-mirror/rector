<?php declare(strict_types=1);

namespace Rector\DomainDrivenDesign\Rector\ObjectToScalar;

use PhpParser\Node;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\NamespaceAnalyzer;
use Rector\PhpParser\Node\BetterNodeFinder;
use Rector\Rector\AbstractRector;

abstract class AbstractObjectToScalarRector extends AbstractRector
{
    /**
     * @var string[]
     */
    protected $valueObjectsToSimpleTypes = [];

    /**
     * @var DocBlockManipulator
     */
    protected $docBlockManipulator;

    /**
     * @var BetterNodeFinder
     */
    protected $betterNodeFinder;

    /**
     * @var NamespaceAnalyzer
     */
    protected $namespaceAnalyzer;

    /**
     * @param string[] $valueObjectsToSimpleTypes
     */
    public function __construct(array $valueObjectsToSimpleTypes)
    {
        $this->valueObjectsToSimpleTypes = $valueObjectsToSimpleTypes;
    }

    /**
     * @required
     */
    public function setAbstractObjectToScalarRectorDependencies(
        DocBlockManipulator $docBlockManipulator,
        BetterNodeFinder $betterNodeFinder,
        NamespaceAnalyzer $namespaceAnalyzer
    ): void {
        $this->docBlockManipulator = $docBlockManipulator;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->namespaceAnalyzer = $namespaceAnalyzer;
    }

    protected function matchNewType(Node $node): ?string
    {
        foreach ($this->getTypes($node) as $nodeType) {
            if (! isset($this->valueObjectsToSimpleTypes[$nodeType])) {
                continue;
            }

            return $this->valueObjectsToSimpleTypes[$nodeType];
        }

        return null;
    }

    /**
     * @return string[]|null
     */
    protected function matchOriginAndNewType(Node $node): ?array
    {
        foreach ($this->getTypes($node) as $nodeType) {
            if (! isset($this->valueObjectsToSimpleTypes[$nodeType])) {
                continue;
            }

            return [$nodeType, $this->valueObjectsToSimpleTypes[$nodeType]];
        }

        return null;
    }
}
