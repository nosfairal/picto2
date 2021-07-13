<?php
namespace App\Tests\Entity;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;
class CategoryTest extends TestCase
{
    public function testName()
    {
        $category  = new Category();
        $name = "Coucou";
        
        $category->setName($name);
        $this->assertEquals("Coucou", $category->getName());
    }
}