<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleController extends AbstractController
{

    /**
     * @Route("/" , name="article_list")
     * @Method({"GET"})
     */

    public function index()
    {
        // return new Response('<html><body>Hello</body></html>');
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('articles/index.html.twig', array('articles' => $articles));
    }




    /**
     * @Route("/article/new" , name="new_article")
     * @Method({"GET" , "POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)->
        add('title', TextType::class,
            array('attr' => array('class' => 'from-control')))
            ->add('body', TextareaType::class,
                array('required' => false, 'attr'
                => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-primary mt-3 btn-sm')
        ))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $article = $form-> getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }


        return $this->render('articles/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/article/{id}" , name="article_show")
     * @Method({"POST"})
     */

    public function show($id)
    {
        $article = $articles = $this->getDoctrine()->
        getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig', array('article' => $articles));

    }
//    /**
//     * @Route("/article/save")
//     * @Method({"POST"})
//     */
//
//    public function save (){
//        $entityMnager= $this->getDoctrine()->getManager();
//        $article = new Article();
//
//        $article->setTitle('Article Two');
//        $article->setBody('This is the body for article Tow');
//
//        $entityMnager->persist($article);
//        $entityMnager->flush();
//
//        return new Response('Saved an article with the id of '.$article->getId());
//  }

}

