<?php

namespace Acme\StoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\StoreBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $women = new Category();
        $women->setName('Women');
        $women->setNamecat('Women dress, shoes');

        $men = new Category();
        $men->setName('Men');
        $men->setNamecat('Men clothes, shoes');

        $children = new Category();
        $children->setName('Children');
        $children->setNamecat("Kid's dress, shoes");

        $manager->persist($women);
        $manager->persist($men);
        $manager->persist($children);
        $manager->flush();

        $this->addReference('women-category', $women);
        $this->addReference('men-category', $men);
        $this->addReference('children-category', $children);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}