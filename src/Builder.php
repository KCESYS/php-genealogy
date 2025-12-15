<?php

namespace KCESYS\Genealogy;

use Closure;

class Builder
{
    private array $items = [];
    private ?Closure $idMapper = null;
    private ?Closure $labelMapper = null;
    private ?Closure $parentsMapper = null;
    private ?Closure $spousesMapper = null;
    private ?Closure $childrenMapper = null;
    private ?Closure $siblingsMapper = null;
    private ?Closure $dataMapper = null;

    protected function __construct(iterable $items)
    {
        $this->items = is_array($items) ? $items : iterator_to_array($items);
    }

    public static function from(iterable $items): self
    {
        return new self($items);
    }

    public function mapId(callable $callback): self
    {
        $this->idMapper = $callback;
        return $this;
    }

    public function mapLabel(callable $callback): self
    {
        $this->labelMapper = $callback;
        return $this;
    }

    public function mapParents(callable $callback): self
    {
        $this->parentsMapper = $callback;
        return $this;
    }
    
    public function mapSpouses(callable $callback): self
    {
        $this->spousesMapper = $callback;
        return $this;
    }

    public function mapChildren(callable $callback): self
    {
        $this->childrenMapper = $callback;
        return $this;
    }

    public function mapSiblings(callable $callback): self
    {
        $this->siblingsMapper = $callback;
        return $this;
    }

    public function mapData(callable $callback): self
    {
        $this->dataMapper = $callback;
        return $this;
    }

    public function build(): GenealogyGraph
    {
        $graph = new GenealogyGraph();

        foreach ($this->items as $item) {
            $id = ($this->idMapper)($item);
            $label = $this->labelMapper ? ($this->labelMapper)($item) : (string)$item;

            // Base Data
            $data = $this->dataMapper ? ($this->dataMapper)($item) : [];
            $data['label'] = $label;

            $node = new FamilyNode((string)$id, $data);

            if ($this->parentsMapper) {
                $parents = ($this->parentsMapper)($item);
                if (is_iterable($parents)) {
                    foreach ($parents as $pid) {
                        $node->addParent((string)$pid);
                    }
                }
            }
            if ($this->spousesMapper) {
                $spouses = ($this->spousesMapper)($item);
                if (is_iterable($spouses)) {
                    foreach ($spouses as $sid) $node->addSpouse((string)$sid);
                }
            }
            if ($this->childrenMapper) {
                $children = ($this->childrenMapper)($item);
                if (is_iterable($children)) {
                    foreach ($children as $cid) $node->addChild((string)$cid);
                }
            }
            if ($this->siblingsMapper) {
                $siblings = ($this->siblingsMapper)($item);
                if (is_iterable($siblings)) {
                    foreach ($siblings as $sid) {
                        $node->addSibling((string)$sid);
                    }
                }
            }

            $graph->addNode($node);
        }

        return $graph;
    }
}
