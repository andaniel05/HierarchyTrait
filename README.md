HierarchyTrait
================

Añade funcionalidad jerárquica a clases.

## Requerimientos

PHP 5.4.0+

## Ejemplos de uso

```php
<?php

require_once 'vendor/autoload.php';

use Andaniel05\HierarchyTrait\HierarchyInterface;
use Andaniel05\HierarchyTrait\HierarchyTrait;

/**
 * Es opcional pero recomendable implementar la interfaz.
 */
class Person implements HierarchyInterface
{
    use HierarchyTrait; // Activar la funcionalidad jerárquica.

    protected $name;
    protected $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    /**
     * Es obligatorio implementar este método y lo recomendable
     * es que devuelva un valor tipo string.
     */
    public function getId()
    {
        return $this->name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }
}

// Instancias jerárquicas.
$andy    = new Person('andy', 27);
$andria  = new Person('andria', 35);
$antonio = new Person('antonio', 53);
$sonia   = new Person('sonia', 51);

// Ejemplo 1. Cuando una entidad define el padre automáticamente el padre
// lo registra como hijo. Si se desea cambiar ese comportamiento ver HierarchyTrait::setParent()

$andy->setParent($antonio);

echo isset($antonio->getChildren()['andy']); // TRUE

// Ejemplo 2. Al insertar un hijo a este se le define la instancia actual
// como padre.
$sonia->addChild($andria);

echo $andria->getParent() === $sonia; // True

```