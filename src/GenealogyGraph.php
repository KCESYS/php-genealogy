<?php

namespace KCESYS\Genealogy;

use JsonSerializable;

class GenealogyGraph implements JsonSerializable
{
    /** @var FamilyNode[] */
    private array $nodes = [];

    public function addNode(FamilyNode $node): self
    {
        $this->nodes[$node->id] = $node;
        return $this;
    }

    public function getNode(string $id): ?FamilyNode
    {
        return $this->nodes[$id] ?? null;
    }

    /**
     * Helper to create a complete graph structure compatible with the React frontend.
     */
    public function jsonSerialize(): array
    {
        return array_values($this->nodes);
    }
}
