# PHP Genealogy

A framework-agnostic PHP SDK for managing genealogy data structures compatible with [@kcesys/react-genealogy](https://github.com/KCESYS/react-genealogy).

## Installation

```bash
composer require kcesys/php-genealogy
```

## Usage

Use the `Builder` to transform your raw data (Arrays, Objects, Database Models) into a valid Graph structure.

```php
use KCESYS\Genealogy\Builder;

$users = [
    (object)['id' => 1, 'name' => 'Grandpa', 'father_id' => null],
    (object)['id' => 2, 'name' => 'Father', 'father_id' => 1],
];

$graph = Builder::from($users)
    ->mapId(fn($u) => $u->id)
    ->mapLabel(fn($u) => $u->name)
    ->mapParents(fn($u) => $u->father_id ? [$u->father_id] : [])
    ->build();

// Output JSON for React
echo json_encode($graph); 
```

## Manual Construction

You can also build the graph manually using `FamilyNode`.

```php
use KCESYS\Genealogy\GenealogyGraph;
use KCESYS\Genealogy\FamilyNode;

$graph = new GenealogyGraph();
$node = new FamilyNode('1', ['label' => 'Me']);
$graph->addNode($node);
```
