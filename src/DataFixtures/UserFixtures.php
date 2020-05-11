<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    
    /**
     * __construct
     *
     * @param  mixed $encoder
     * @return void
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


        
        
    /**
     * load
     *
     * @param  mixed $manager
     * @return Response 
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('coucou');
        $user->setPassword($this->encoder->encodePassword($user, 'coucou'));
        $manager->persist($user);
        $manager->flush();
    }
}
