<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++){
            $micro_post = new MicroPost();
            $micro_post->setText('Some random text ' . rand(0, 100));
            $micro_post->setTime(new \DateTime('2019-05-16'));
            $manager->persist($micro_post);
        }

        $manager->flush();
    }
}
