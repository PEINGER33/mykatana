<?php

namespace App\DataFixtures;

use App\Entity\Katanakake;
use App\Entity\Member;
use App\Entity\Trousseau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Katana;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\MemberFixtures;


class AppFixtures extends Fixture implements DependentFixtureInterface
{

    // Nouvelle version des Fixtures 
    
    // definition des references 
    private const OLIVIER_TROUSSEAU = 'olivier-trousseau';
    private const SLASH_TROUSSEAU   = 'slash-trousseau';

    private const OLIVIER_KATANAKAKE = 'katanakake_olivier';
    private const SLASH_KATANAKAKE   = 'katanakake_slash';
    
    
    private const KATANA_HONJO    = 'katana_honjo';
    private const KATANA_KUSANAGI = 'katana_kusanagi';
    private const KATANA_MURAMASA = 'katana_muramasa';
    private const KATANA_MIKAZUKI = 'katana_mikazuki';
    
    
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function getDependencies(): array
    {
        return [
            MemberFixtures::class,
        ];
    }
    


    private static function trousseauxDataGenerator()
    {
        yield ['Lot de katana 1', self::OLIVIER_TROUSSEAU];
        yield ['Lot de katana 2', self::SLASH_TROUSSEAU];
    }
    

    private static function katanasDataGenerator()
    {
        yield [self::OLIVIER_TROUSSEAU, 'Honjo Masamune', 'Tachi', 71.0,'honjo.jpg',  self::KATANA_HONJO];
        yield [self::OLIVIER_TROUSSEAU, 'Kusanagi-no-Tsurugi', 'Ken', 72.0,'kusanagi.jpg', self::KATANA_KUSANAGI];
        yield [self::SLASH_TROUSSEAU, 'Muramasa', 'Shinogi Zukuri', 72.0,'muramasa.jpg', self::KATANA_MURAMASA];
        yield [self::SLASH_TROUSSEAU, 'Mikazuki Munechika', 'Tachi', 80.0,'mikazuki.jpg', self::KATANA_MIKAZUKI];
    }
    

    private static function katanakakeDataGenerator()
    {
        yield ["Collection d'Olivier", true, MemberFixtures::OLIVIER_MEMBER,  self::OLIVIER_KATANAKAKE,  [self::KATANA_HONJO, self::KATANA_KUSANAGI]];
        yield ["Les sabres légendaires de Slash", false, MemberFixtures::SLASH_MEMBER, self::SLASH_KATANAKAKE, [self::KATANA_MURAMASA, self::KATANA_MIKAZUKI]];
    }
    
    private static function memberTrousseauLinks()
    {
        yield [MemberFixtures::OLIVIER_MEMBER, self::OLIVIER_TROUSSEAU];
        yield [MemberFixtures::SLASH_MEMBER,   self::SLASH_TROUSSEAU];
    }
    
    public function load(ObjectManager $manager): void
    {
        // création des trousseaux
        foreach (self::trousseauxDataGenerator() as [$description, $trousseauRef]) {
            $trousseau = new Trousseau();
            $trousseau->setDescription($description);
            $manager->persist($trousseau);
            $manager->flush();
            
            // on sauvegarde une référence vers cet objet
            $this->addReference($trousseauRef, $trousseau);
        }
        
        
        //  création des katanas, associés à leur trousseau
        foreach (self::katanasDataGenerator() as [$trousseauRef, $desc, $type, $longueur, $imageName, $katanaRef ]) {
            $katana = new Katana();
            $katana->setDescription($desc);
            $katana->setType($type);
            $katana->setLongueur($longueur);
            
            // récupère le trousseau via la référence
            $trousseau = $this->getReference($trousseauRef, Trousseau::class);
            $katana->setTrousseau($trousseau);
            $katana->setImageName($imageName);
            
            $manager->persist($katana);
            $this->addReference($katanaRef, $katana);
            
        }
        
        //  création des Katanakake (galeries)
        foreach (self::katanakakeDataGenerator() as [$description, $publiee, $memberRef, $katanakakeRef, $katanaRefs]) {
            $katanakake = new Katanakake();
            $katanakake->setDescription($description);
            $katanakake->setPubliee($publiee);
            
            // on relie le createur à un Member existant
            $createur = $this->getReference($memberRef, Member::class);
            $katanakake->setCreateur($createur);
            
            foreach ($katanaRefs as $katanaRef) {
                $katanakake->addKatana($this->getReference($katanaRef, Katana::class));
            }
            
            $manager->persist($katanakake);
            
            $this->addReference($katanakakeRef, $katanakake);
        }
        
        // Lier les membres à leurs trousseaux
        foreach (self::memberTrousseauLinks() as [$memberRef, $trousseauRef]) {

            $member = $this->getReference($memberRef, Member::class);

            $trousseau = $this->getReference($trousseauRef, Trousseau::class);
            
            $member->setTrousseau($trousseau);
            $manager->persist($member);
        }
        
        
        $manager->flush();
    }
}
