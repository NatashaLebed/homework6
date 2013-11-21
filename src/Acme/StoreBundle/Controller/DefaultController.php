<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Acme\StoreBundle\Entity\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig');
    }

    public function showProductsAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('AcmeStoreBundle:Default:products.html.twig', array('products' => $products));
    }

    public function showCategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No categories found'
            );
        }

        return $this->render('AcmeStoreBundle:Default:categories.html.twig', array('categories' => $categories));
    }

    public function descriptionProductAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for Id'.$id
            );
        }

        return $this->render('AcmeStoreBundle:Default:descriptionProducts.html.twig', array(
            'product' => $product,
            'description' => $product->getDescription()
        ));
    }

    public function allProductsOfCategoryAction($id)
    {
        $category = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Category')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AcmeStoreBundle:Product')
                  ->findByCategory($id);



        return $this->render('AcmeStoreBundle:Default:allProductsOfCategory.html.twig', array(
            'category' => $category,
            'products' => $products
        ));
    }

    public function fixtureAction()
    {
        return $this->render('AcmeStoreBundle:Default:fixture.html.twig');
    }

    public function fixtureDoneAction()
    {
            $em = $this->getDoctrine()->getManager();
            $loader = new Loader();
            $loader->loadFromDirectory(__DIR__ . '/../DataFixtures');

            $purger = new ORMPurger();
            $executor = new ORMExecutor($em, $purger);
            $executor->execute($loader->getFixtures());

        return $this->render('AcmeStoreBundle:Default:fixture_done.html.twig');
    }


}




