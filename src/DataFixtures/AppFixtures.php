<?php

namespace App\DataFixtures;

use App\Entity\Trousseau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Katana;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->loadTrousseau($manager);
        $this->loadKatana($manager);
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
        yield ['lot de katana 1'];
        yield ['lot de katana 2'];
        
    }
    
    
    private function loadKatana(ObjectManager $manager)
    { 
        
        // 1) Créer un seul trousseau
        #$trousseau = $manager->getRepository(Trousseau::class)->findOneBy([]);
        
        foreach ($this->getKatanaData() as [$description, $type, $longueur]) {
            $katana = new Katana();
            $katana->setDescription($description);
            $katana->setType($type);
            $katana->setLongueur($longueur);
            #$katana->setTrousseau($trousseau);

            
            $manager->persist($katana);
        }
        $manager->flush();
    }
 
    private function getKatanaData()
    {
        // katana = [description, type, longueur];
        yield ['Honjo Masamune','Tachi', 71.0];
        yield ['Kusanagi-no-Tsurugi', 'Autre', 72.0];
        yield ['Muramasa', 'Shinogi Zukuri ',72.0];
        
        
    }
}
