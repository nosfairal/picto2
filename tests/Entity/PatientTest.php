<?php
namespace App\Tests\Entity;
use App\Entity\Patient;
use PHPUnit\Framework\TestCase;
class PatientTest extends TestCase
{
    public function testFirstname()
    {
        $patient  = new Patient();
        $prenom = "Test 2";
        
        $patient->setFirstname($prenom);
        $this->assertEquals("Test 2", $patient->getFirstname());
    }
}