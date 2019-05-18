<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private const USERS = [
        [
            'username' => 'rashid_mall',
            'email' => 'rashid@mail.com',
            'fullName' => 'Rashid Mall',
            'password' => 'Pass12345',
        ],
        [
            'username' => 'bob_sanchez',
            'email' => 'bob@mail.com',
            'fullName' => 'Bob Sanchez',
            'password' => 'Bob12345',
        ],
        [
            'username' => 'alice_wonderland',
            'email' => 'alice@mail.com',
            'fullName' => 'Alice Wonderland',
            'password' => 'Alice12345',
        ]
    ];

    private const MICRO_POST_TEXT = [
        "A chicken sandwidch walked into the bar, ordered some food and beer. 
        The bartender says: \"Sorry, we don't serve food here\".
        Because people keep hitting them with dictionaries.",
        "Do not meddle in the affairs of cats, 
        for they are subtle and will whiz on your computer.",
        "I wonder if you choke a smurf, what color does it turn?",
        "I'd explain it to you, but your brain would explode.",
        "I've got the ship, you've got the harbor ... what say we tie up for the night?",
        "It's no accident that stressed spelled backwards is desserts.",
        "Just because you're paranoid, it doesn't mean they're NOT out to get you.",
        "Lightyears ahead! Just a phonecall away!",
        "Minds are like Parachutes. They work best when open.",
        "My Reality Check bounced.",
        "What did the drummer get on his IQ test? Drool...",
        "Why do farts smell? For benefit of the deaf.",
        "Why'd the couple stop after 3 children? Cos they heard every fourth child born is chinese.",
        "You're slower than a herd of turtles stampeding through peanut butter."
    ];

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
        for($i = 0; $i < 30; $i++){
            $micro_post = new MicroPost();
            $micro_post->setText(
                self::MICRO_POST_TEXT[rand(0, count(self::MICRO_POST_TEXT)-1)]
            );

            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . ' day');
            $micro_post->setTime($date);

            $manager->persist($micro_post);

            $micro_post->setUser($this->getReference(
                self::USERS[rand(0, count(self::USERS)-1)]['username'])
            );
        }

        $manager->flush();
    }

    private  function loadUsers(ObjectManager $manager){
        foreach (self::USERS as $userData){
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setFullName($userData['fullName']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user, $userData['password'])
            );

            $this->setReference($userData['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
