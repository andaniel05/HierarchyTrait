<?php

use Andaniel05\HierarchyTrait\HierarchyInterface;
use Andaniel05\HierarchyTrait\HierarchyTrait;

class Person implements HierarchyInterface
{
    use HierarchyTrait;

    protected $name;
    protected $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

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

class HierarchyTraitTest extends PHPUnit_Framework_TestCase
{
    protected $andy;
    protected $andria;
    protected $antonio;
    protected $sonia;

    public function setUp()
    {
        $this->andy = new Person('andy', 27);
        $this->andria = new Person('andria', 35);
        $this->antonio = new Person('antonio', 53);
        $this->sonia = new Person('sonia', 51);
    }

    public function testParentIsNullOnDefault()
    {
        $this->assertNull($this->andy->getParent());
    }

    /**
     * @expectedException Andaniel05\HierarchyTrait\Exception\InvalidParentTypeException
     */
    public function testThrowInvalidParentTypeException()
    {
        $this->andy->setParent(new stdClass());
    }

    public function testGetParentAndSetParent()
    {
        $this->andy->setParent($this->antonio);

        $this->assertSame($this->antonio, $this->andy->getParent());
    }

    public function testGetChildrenReturnAnArray()
    {
        $children = $this->andy->getChildren();

        $this->assertTrue(is_array($children));
        $this->assertEmpty($children);
    }

    public function testGetChildrenReturnRightResult()
    {
        $this->antonio->addChild($this->andy);
        $this->antonio->addChild($this->andria);

        $children = $this->antonio->getChildren();

        $this->assertCount(2, $children);
        $this->assertSame($this->andy, $children['andy']);
        $this->assertSame($this->andria, $children['andria']);
    }

    /**
     * @expectedException Andaniel05\HierarchyTrait\Exception\InvalidChildTypeException
     */
    public function testThrowInvalidChildTypeException()
    {
        $this->antonio->addChild(new stdClass());
    }

    public function testAddChildAndGetChild()
    {
        $this->antonio->addChild($this->andy);

        $this->assertSame($this->andy, $this->antonio->getChild('andy'));
    }

    public function testRemoveChild()
    {
        $this->antonio->addChild($this->andy);
        $this->antonio->addChild($this->andria);

        $this->antonio->removeChild('andy');
        $children = $this->antonio->getChildren();

        $this->assertCount(1, $children);
        $this->assertSame($this->andria, $children['andria']);
    }

    public function testRegisterChildInParentOnSetParentCall()
    {
        $this->andy->setParent($this->antonio);

        $this->assertSame($this->andy, $this->antonio->getChild('andy'));
    }

    public function testNoRegisterChildInParentOnSetParentCall()
    {
        $this->andy->setParent($this->antonio, false);

        $this->assertNull($this->antonio->getChild('andy'));
    }

    public function testDeleteRegisterInOldParentOnSetParentCall()
    {
        $this->andy->setParent($this->antonio);
        $this->andy->setParent($this->sonia);

        $this->assertNull($this->antonio->getChild('andy'));
        $this->assertSame($this->andy, $this->sonia->getChild('andy'));
    }

    public function testNoDeleteRegisterInOldParentOnSetParentCall()
    {
        $this->andy->setParent($this->antonio);
        $this->andy->setParent($this->sonia, true, false);

        $this->assertSame($this->andy, $this->antonio->getChild('andy'));
        $this->assertSame($this->andy, $this->sonia->getChild('andy'));
    }

    public function testRegisterParentInChildOnAddChildCall()
    {
        $this->antonio->addChild($this->andy);

        $this->assertSame($this->antonio, $this->andy->getParent());
    }

    public function testNoRegisterParentInChildOnAddChildCall()
    {
        $this->antonio->addChild($this->andy, false);

        $this->assertNull($this->andy->getParent());
    }

    public function testUnregisterParentOnRemoveChild()
    {
        $this->andy->setParent($this->antonio);

        $this->antonio->removeChild('andy');

        $this->assertNull($this->andy->getParent());
    }

    public function testNoUnregisterParentOnRemoveChild()
    {
        $this->andy->setParent($this->antonio);

        $this->antonio->removeChild('andy', false);

        $this->assertSame($this->antonio, $this->andy->getParent());
    }
}