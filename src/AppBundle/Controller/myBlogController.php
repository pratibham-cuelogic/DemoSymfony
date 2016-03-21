<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class myBlogController extends Controller{
    /**
     * @Route("/", name="my_blog")
     */
    public function blogAction(){
        $blogs = $this->getDoctrine()
        ->getRepository('AppBundle:Blog')
        ->findAll();
        // replace this example code with whatever you need
        return $this->render('blog/index.html.twig', array(
            'blogs' => $blogs
            ));
    }

    /**
     * @Route("/blog/create", name="blog_create")
     */
    public function createAction(Request $request){
        
        $blog = new Blog;
        $form = $this->createFormBuilder($blog)
        ->add('heading', TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('heading', TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('heading', TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('heading', TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('data', TextareaType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('save', SubmitType::class, array('label' => 'Submit Blog', 'attr'=> array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Get the data from the form
            $heading = $form['heading']->getData();
            $data = $form['data']->getData();
            $now = new\DateTime('now');

            $blog->setHeading($heading);
            $blog->setData($data);
            $blog->setCreatedOn($now);
            $blog->setCreatedBy(1);
            $blog->setUpdatedOn($now);
            $blog->setUpdatedBy(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash(
                'notice',
                'Blog Added'
                );
           /* $name = $form['name']->getData();
            $name = $form['name']->getData();
            $name = $form['name']->getData();
            $name = $form['name']->getData();*/

            return $this->redirectToRoute('my_blog');
        }

        return $this->render('blog/create.html.twig', array(
            'form' =>$form->createView()
            ));
    }

    /**
     * @Route("/blog/edit/{id}", name="blog_edit")
     */
    public function editAction($id, Request $request){
        // replace this example code with whatever you need
        return $this->render('blog/edit.html.twig');
    }

    /**
     * @Route("/blog/details/{id}", name="blog_details")
     */
    public function detailsAction($id){
        
        $blogs = $this->getDoctrine()
        ->getRepository('AppBundle:Blog')
        ->findAll();
        // replace this example code with whatever you need
        return $this->render('blog/index.html.twig', array(
            'blogs' => $blogs
            ));

        return $this->render('blog/details.html.twig');
    }

}
