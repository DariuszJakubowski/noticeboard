<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Advertisement;
use AppBundle\Entity\Category;
use AppBundle\Form\AdvertisementType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


/**
 *
 * @Route("/advertisement")
 */
class AdvertisementController extends Controller
{

    /**
     * @Route("/new")
     * @Template()
     */
   /* public function newAction()
    {
        $advertisement = new Advertisement();

        $form = $this->createForm(
            new AdvertisementType(),
            $advertisement,
            [
                'action' => $this->generateUrl('app_advertisement_create')
            ]
        );
        $form->add('submit', 'submit');

        return ['form' => $form->createView()];
    }*/
    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $advertisement = new Advertisement();
        $advertisement->setDate(new DateTime('+2 months')); //musi być obiekt Datatime
        /*
         * data wygasania ogłoszenia po tym czasie ogłoszenie będzie
        skasowane
        */


        $form = $this->createForm(
            new AdvertisementType(),
            $advertisement,
            [
                'action' => $this->generateUrl('app_advertisement_create')
            ]
        );

        $form->add('submit', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($advertisement);
            $em->flush();

            return $this->redirectToRoute(
                'app_advertisement_show',
                [
                    'id' => $advertisement->getId()
                ]
            );
        }

        return ['form' => $form->createView()];
    }


    /**
     * @Route("/showAll")
     * @Template
     */
    public function showAllAction()
    {
        $advertisement = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Advertisement')
            ->findAll();

        return ['advertisements' => $advertisement];

    }
    /**
     * @Route("/show/{id}")
     * @Template()
     */
    public function showAction($id)
    {
        $advertisement = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Advertisement')
            ->find($id);

        if (!$advertisement) {
            throw $this->createNotFoundException('Advertisement not found');
        }

        return ['advertisement' => $advertisement];
    }



}