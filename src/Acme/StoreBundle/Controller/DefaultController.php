<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Acme\StoreBundle\Entity\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

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



//======================test read/write database  ==================

    public function createAction()
    {
        $category = new Category();
        $category->setName('Children');
        $category->setNamecat("Kid's dress, shoes");


        $product = new Product();
        $product->setName('dress');
        $product->setPrice(10);
        $product->setDescription('super puper dress for kids');
        // relate this product to the category
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();

        return new Response(
            'Created product id: '.$product->getId().' and category id: '.$category->getId()
        );
    }

    public function showAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.c
            );
        }
        $categoryName = $product->getCategory()->getName();

        return new Response('product name '.$product->getName().'category name '.$categoryName);
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $em->flush();

        return new Response('product name '.$product->getName());
    }

    public function selectAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM AcmeStoreBundle:Product p
            WHERE p.price > :price
            ORDER BY p.price ASC'
        )->setParameter('price', '19.99');
        $query->setMaxResults(1);

        try {
            $product = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $product = null;
        }

       return new Response('product name '.$product->getName());
    }

    public function findAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')
            ->findByNameAllOrdered();
        //$str = vardump($product,true);
        return new Response('product name sdfsfs' );
    }
}




