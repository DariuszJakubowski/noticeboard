<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/new")
     * @Template
     */
    public function newAction()

    {
        return [];
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $category = new Category();

        $category->setName($request->request->get('name'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($category);
        $em->flush();

        return $this->redirectToRoute('showAllCategories', ['id' => $category->getId()]);
    }

    /**
     * @Route("/showAllCategories", name="showAllCategories")
     * @Template
     */
    public function showAllCategoriesAction()
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return ['categories' => $categories];

    }




}