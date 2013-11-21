<?php

namespace Acme\StoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\StoreBundle\Entity\Product;

class LoadProductsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $p1 = new Product();
        $p1->setName('dress');
        $p1->setPrice(10);
        $p1->setDescription('super puper dress for kids');
        $p1->setCategory($this->getReference('children-category'));

        $p2 = new Product();
        $p2->setName('little black dress');
        $p2->setPrice(100);
        $p2->setDescription('Very nice little black dress,');
        $p2->setCategory($this->getReference('women-category'));

        $p3 = new Product();
        $p3->setName('blouse');
        $p3->setPrice(85);
        $p3->setDescription('blouse kdjfh jhd  kjhf dkfjh kjdfh kjdfh kdfj ');
        $p3->setCategory($this->getReference('women-category'));

        $p4 = new Product();
        $p4->setName('shirt');
        $p4->setPrice(25);
        $p4->setDescription("shirt -----------You now have a usable Product class with mapping information so that
         Doctrine knows exactly how to persist it. Of course, you don't yet have the corresponding product table in your
          database. Fortunately, Doctrine can automatically create all the database tables needed for every known entity
           in your application. To do this, run:");
        $p4->setCategory($this->getReference('men-category'));

        $p5 = new Product();
        $p5->setName('hat');
        $p5->setPrice(15);
        $p5->setDescription("hat ----- Actually, this command is incredibly powerful. It compares what your database
         should look like (based on the mapping information of your entities) with how it actually looks, and generates
          the SQL statements needed to update the database to where it should be. In other words, if you add a new p");
        $p5->setCategory($this->getReference('men-category'));

        $manager->persist($p1);
        $manager->persist($p2);
        $manager->persist($p3);
        $manager->persist($p4);
        $manager->persist($p5);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}