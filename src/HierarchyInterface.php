<?php

namespace Andaniel05\HierarchyTrait;

/**
 * Interfaz de funcionalidad jerárquica en clases.
 *
 * Esta interfaz es de uso opcional pero recomendado. Si se usa en conjunto
 * con el trait la ventaja que se obtiene es que se logra una mejor semántica
 * en el código fuente. Por ejemplo, sería posible hacer:
 *
 * if (TRUE === $var instanceOf HierarchyInterface) {...}
 *
 * Si solo se usara el trait lo anterior no fuera posible. No está de más mencionar
 * que dicha interfaz es completamente compatible con el trait.
 *
 * @author Andy D. Navarro Taño <andaniel05@gmail.com>
 * @version 1.0.0
 */
interface HierarchyInterface
{
    /**
     * Devuelve el identificador de la instancia.
     *
     * Las clases que usen este trait están obligadas a presentar
     * un identificador. Este identificador se usa como índice en el array
     * de hijos.
     *
     * @return mixed Identificador de la instancia.
     */
    public function getId();

    /**
     * Establece el padre.
     *
     * @param object  $parent                Instancia padre. Tiene que ser del mismo tipo que el actual.
     * @param boolean $registerChildInParent Si vale TRUE será registrada la instancia actual como hija del padre.
     * @param boolean $unregisterFromOld     Si vale TRUE y si existe un padre anterior se eliminará el registro como hijo del padre anterior.
     *
     * @throws InvalidParentTypeException Se dispara cuando el padre no es del mismo tipo.
     */
    public function setParent($parent, $registerChildInParent = true, $unregisterFromOld = true);

    /**
     * Devuelve el padre.
     *
     * @return object
     */
    public function getParent();

    /**
     * Devuelve los hijos.
     *
     * @return array
     */
    public function getChildren();

    /**
     * Inserta un hijo.
     *
     * @param object  $child
     * @param boolean $registerParentInChild Si vale TRUE se le va a definir la instancia actual como padre del hijo.
     */
    public function addChild($child, $registerParentInChild = true);

    /**
     * Devuelve un hijo por su identificador.
     *
     * @param  mixed $id Identificador.
     * @return object|null
     */
    public function getChild($id);

    /**
     * Elimina un hijo.
     *
     * @param  mixed  $id                Identificador.
     * @param  boolean $unregisterParent Si vale TRUE se le definirá a NULL el padre del hijo eliminado.
     */
    public function removeChild($id, $unregisterParent = true);
}