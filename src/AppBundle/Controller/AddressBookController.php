<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AddressBookController extends Controller
{
    /**
     * @Route("/addresses", name="addresses")
     */
    public function indexAction()
    {
        $addresses = $this->getDoctrine()
            ->getRepository('AppBundle:Address')
            ->findAll();

        return $this->render('addressbook/index.html.twig', array('data' => $addresses));
    }

    /**
     * @Route("/create", name="create_address")
     */
    public function createAction(Request $request)
    {
        $address = new Address();
        $form = $this->createFormBuilder($address)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('street', TextareaType::class)
            ->add('zip', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('phoneNo', TextType::class)
            ->add('birthday', DateType::class, array('widget' => 'choice'))
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class, array('label' => 'New Address'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirect('/show/'.$address->getId());
        }

        return $this->render(
            'addressbook/edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/update/{id}", name = "update_address" )
     */
    public function updateAction($id, Request $request)
    {
        $doct = $this->getDoctrine()->getManager();
        $address = $doct->getRepository('AppBundle:Address')->find($id);

        if (!$address) {
            throw $this->createNotFoundException(
                'No Address found for id '.$id
            );
        }
        $form = $this->createFormBuilder($address)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('street', TextareaType::class)
            ->add('zip', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('phoneNo', TextType::class)
            ->add('birthday', DateType::class, array(
                'widget' => 'text',
            ))
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $doct = $this->getDoctrine()->getManager();

            // tells Doctrine you want to save the Product
            $doct->persist($address);

            //executes the queries (i.e. the INSERT query)
            $doct->flush();

            return $this->redirect('/show/'.$id);

        //return $this->redirectToRoute('app_book_display');
        } else {
            return $this->render('addressbook/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/destroy/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository('AppBundle:Address')->find($id);

        if (!$address) {
            throw $this->createNotFoundException('no address found for id: '.$id);
        }

        $em->remove($address);
        $em->flush();

        return $this->redirectToRoute('addresses');
    }

    /**
     * @Route("/show/{id}")
     */
    public function showAction($id)
    {
        $address = $this->getDoctrine()
            ->getRepository('AppBundle:Address')
            ->find($id);

        if (!$address) {
            throw $this->createNotFoundException(
                'There are no address with the following id: '.$id
            );
        }

        return $this->render(
            'addressbook/view.html.twig',
            array('address' => $address)
        );
    }
}
