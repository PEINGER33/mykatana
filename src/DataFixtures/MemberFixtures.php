<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MemberFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public const OLIVIER_MEMBER = 'member_olivier';
    public const SLASH_MEMBER   = 'member_slash';

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager) : void
    {
        $this->loadMembers($manager);
    }

    private function loadMembers(ObjectManager $manager)
    {
        foreach ($this->getMemberData() as [$email,$plainPassword,$role, $ref]) {
            $member = new Member();
            $password = $this->hasher->hashPassword($member, $plainPassword);
            $member->setEmail($email);
            $member->setPassword($password);

            $roles = array();
            $roles[] = $role;
            $member->setRoles($roles);

            $manager->persist($member);
            $this->addReference($ref, $member);
        }
        $manager->flush();
    }
    private function getMemberData()
    {
        yield ['olivier@localhost','123456','ROLE_USER', self::OLIVIER_MEMBER];
        yield ['slash@localhost',  '123456','ROLE_ADMIN', self::SLASH_MEMBER];
    }
}
