<?php

namespace App\DataFixtures;

use App\Entity\Marks;
use App\Entity\Students;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $student = new Students();

        $student->setName('Shubham');
        $student->setClass('X');
        $student->setRollNumber('1');
        $dateOfBirth = new \DateTime('2000-10-05'); // "yyyy-MM-dd
        $student->setDateOfBirth($dateOfBirth);
        $student->setSession('2019-2023');
        $student->setFatherName('Sultan Singh');
        $manager->persist($student);

        $marks = new Marks();
        $marks->setStudent($student);
        $marks->setSubject('English');
        $marks->setTotalMarks(100);
        $marks->setPassingMarks(35);
        $marks->setObtainedMarks(90);
        $marks->setGrade('A');
        $manager->persist($marks);

        $marks1 = new Marks();
        $marks1->setStudent($student);
        $marks1->setSubject('Hindi');
        $marks1->setTotalMarks(100);
        $marks1->setPassingMarks(35);
        $marks1->setObtainedMarks(90);
        $marks1->setGrade('A');
        $manager->persist($marks1);

        $marks2 = new Marks();
        $marks2->setStudent($student);
        $marks2->setSubject('Math');
        $marks2->setTotalMarks(100);
        $marks2->setPassingMarks(35);
        $marks2->setObtainedMarks(90);
        $marks2->setGrade('A');
        $manager->persist($marks2);

        $manager->flush();
    }
}
