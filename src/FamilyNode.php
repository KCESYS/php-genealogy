<?php

namespace KCESYS\Genealogy;

use JsonSerializable;

class FamilyNode implements JsonSerializable
{
    public string $id;
    public array $data;
    
    /** @var string[] */
    public array $parents = [];
    
    /** @var string[] */
    public array $spouses = [];
    
    /** @var string[] */
    public array $children = [];
    
    /** @var string[] */
    public array $siblings = [];

    public function __construct(string $id, array $data = [])
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function addParent(string $id): self
    {
        if (!in_array($id, $this->parents)) {
            $this->parents[] = $id;
        }
        return $this;
    }

    public function addSpouse(string $id): self
    {
        if (!in_array($id, $this->spouses)) {
            $this->spouses[] = $id;
        }
        return $this;
    }

    public function addChild(string $id): self
    {
        if (!in_array($id, $this->children)) {
            $this->children[] = $id;
        }
        return $this;
    }

    public function addSibling(string $id): self
    {
        if (!in_array($id, $this->siblings)) {
            $this->siblings[] = $id;
        }
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'parents' => $this->parents,
            'spouses' => $this->spouses,
            'children' => $this->children,
            'siblings' => $this->siblings,
        ];
    }
}
