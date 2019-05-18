<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);
    }

    private function loadMicroPosts(ObjectManager $manager){
        for($i = 0; $i < 10; $i++){
            $micro_post = new MicroPost();
            $micro_post->setText('Some random text ' . rand(0, 100));
            $micro_post->setTime(new \DateTime('2019-05-16'));
            $manager->persist($micro_post);

            $micro_post->setUser($this->getReference('rashid_mall'));
        }

        $manager->flush();
    }

    private  function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setUsername('rashid_mall');
        $user->setEmail('rashid@mail.com');
        $user->setFullName('Rashid Mall');
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, 'Pass12345')
        );

        $this->setReference('rashid_mall', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
