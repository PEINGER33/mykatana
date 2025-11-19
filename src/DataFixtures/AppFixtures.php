<?php

namespace App\DataFixtures;

use App\Entity\Katanakake;
use App\Entity\Member;
use App\Entity\Trousseau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Katana;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    
    /* Version des Fixtures fonctionnelle avant  
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->loadTrousseau($manager);
        $this->loadKatana($manager);
        $this->loadMember($manager);
    }
    
    private function loadTrousseau(ObjectManager $manager)
    {
        
        foreach ($this->getTrousseauData() as [$description]) {
            $trousseau = new Trousseau();
            $trousseau->setDescription($description);
            $manager->persist($trousseau);
        }
        $manager->flush();
    }
    
    private function getTrousseauData()
    {
        // trousseau = [description];
        yield ['Lot de katana 1'];
        yield ['Lot de katana 2'];
        yield ['Lot de katana 3'];
        
    }
    
    
    private function loadKatana(ObjectManager $manager)
    { 
        
        // Récupère les trousseaux créés
        $trousseaux = $manager->getRepository(Trousseau::class)->findAll();
        
        foreach ($this->getKatanaData() as [$description, $type, $longueur, $trousseau_id]) {
            $katana = new Katana();
            $katana->setDescription($description);
            $katana->setType($type);
            $katana->setLongueur($longueur);
            
            $katana->setTrousseau($trousseaux[$trousseau_id]);

            
            $manager->persist($katana);
        }
        $manager->flush();
    }
 
    private function getKatanaData()
    {
        // katana = [description, type, longueur, trousseau_id];
        yield ['Honjo Masamune','Tachi', 71.0, 0];
        yield ['Kusanagi-no-Tsurugi', 'Ken', 72.0, 0];
        yield ['Muramasa', 'Shinogi Zukuri ', 72.0, 1];
        yield ['Mikazuki Munechika', 'Tachi', 80.0, 1];
        yield ['Dōjigiri Yasutsuna', 'Tachi', 80.0, 1];
        yield ['Ōdenta Mitsuyo', 'Tachi',  82.0, 2];
        yield ['Juzumaru Tsunetsugu', 'Tachi', 81.0, 2];
        yield ['Onimaru Kunitsuna', 'Tachi', 77.0, 2];
    }
    
    # Partie relatif aux Member
    
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    // /**
      * Generates initialization data for members :
      *  [email, plain text password]
      * @return \\Generator
     // 
    private function membersGenerator()
    {
        yield ['olivier@localhost','123456'];
        yield ['slash@localhost','123456'];
    }
    
    //...
    public function loadMember(ObjectManager $manager): void
    {
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            
            // $roles = array();
            // $roles[] = $role;
            // $user->setRoles($roles);
            
            $manager->persist($user);
        }
        $manager->flush();
    }
    
    */
    
    
    // Nouvelle version des Fixtures 
    
    // defines reference names for instances of Trousseau
    private const OLIVIER_TROUSSEAU = 'olivier-trousseau';
    private const SLASH_TROUSSEAU   = 'slash-trousseau';
    private const OLIVIER_MEMBER = 'member_olivier';
    private const SLASH_MEMBER   = 'member_slash';
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
    
    /**
     * Generates initialization data for members :
     * [email, plain text password, trousseau reference]
     * @return \Generator
     */
    private static function membersDataGenerator()
    {
        yield ['olivier@localhost', '123456', self::OLIVIER_TROUSSEAU, self::OLIVIER_MEMBER];
        yield ['slash@localhost', '123456', self::SLASH_TROUSSEAU, self::SLASH_MEMBER];
    }
    
    
    /**
     * Generates initialization data for trousseaux : [description, reference]
     * @return \Generator
     */
    private static function trousseauxDataGenerator()
    {
        yield ['Lot de katana 1', self::OLIVIER_TROUSSEAU];
        yield ['Lot de katana 2', self::SLASH_TROUSSEAU];
    }
    
    /**
     * Generates initialization data for katanas :
     * [trousseau reference, description, type, longueur]
     * @return \Generator
     */
    private static function katanasDataGenerator()
    {
        yield [self::OLIVIER_TROUSSEAU, 'Honjo Masamune', 'Tachi', 71.0,'honjo.jpg',  self::KATANA_HONJO];
        yield [self::OLIVIER_TROUSSEAU, 'Kusanagi-no-Tsurugi', 'Ken', 72.0,'kusanagi.jpg', self::KATANA_KUSANAGI];
        yield [self::SLASH_TROUSSEAU, 'Muramasa', 'Shinogi Zukuri', 72.0,'muramasa.jpg', self::KATANA_MURAMASA];
        yield [self::SLASH_TROUSSEAU, 'Mikazuki Munechika', 'Tachi', 80.0,'mikazuki.jpg', self::KATANA_MIKAZUKI];
    }
    
    /**
     * Generates initialization data for katanakake :
     * [description, publiee, createur reference]
     * @return \Generator
     */
    private static function katanakakeDataGenerator()
    {
        yield ["Collection d'Olivier", true, self::OLIVIER_MEMBER,  self::OLIVIER_KATANAKAKE,  [self::KATANA_HONJO, self::KATANA_KUSANAGI]];
        yield ["Les sabres légendaires de Slash", false, self::SLASH_MEMBER, self::SLASH_KATANAKAKE, [self::KATANA_MURAMASA, self::KATANA_MIKAZUKI]];
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
        
        //  création des membres, liés à leur trousseau
        foreach (self::membersDataGenerator() as [$email, $plainPassword, $trousseauRef, $memberRef]) {
            $member = new Member();
            $member->setEmail($email);
            $member->setPassword($this->hasher->hashPassword($member, $plainPassword));
            
            // récupère le trousseau correspondant (comme dans le code du prof)
            $trousseau = $this->getReference($trousseauRef, Trousseau::class);
            $member->setTrousseau($trousseau);
            
            $manager->persist($member);
            $this->addReference($memberRef, $member);
            $manager->flush();
            
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
        
        
        $manager->flush();
    }
}
