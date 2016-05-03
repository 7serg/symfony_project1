<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Form\Type\PostType;

class PostController extends Controller
{
    /**
     * @Route("/create", name = "create_post")
     
     * @Template
     */
    public function createAction(Request $r)
    {
        $post = new Post;
        $form = $this -> createForm(PostType::class, $post );

        $form->handleRequest($r);
        if ($form->isValid()){
           $f = $post->getImageFile();
            if($f){
                $on =$f->getClientOriginalName();
                $f->move('public/images', $on);
                $path= 'public/images/' . $on;
                $post->setImagePath($path);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('create_post');
        }
           dump($post->getImageFile());             
        return [
        'form' => $form->createView()
        ];
    }

    /**
     * @Route("/show/{post}", name = "show_post")
     * @Template
     */
    public function showAction(Post $post)
    {
        return ['post'=> $post];
    }

    /**
     * @Route("/update/{post}", name = "update_post")
     * @Template
     */
    public function updateAction(Post $post, Request $r)
    {
         $form = $this -> createForm(PostType::class, $post);
         $form->handleRequest($r);
         if ($form->isValid()) {
            $em= $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('all_posts');

         }

        return ['form'=>$form->createView()];
    }

    /**
     * @Route("/remove/{post}", name = "remove_post")
     * @Template
     */
    public function removeAction(Post $post)
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('all_posts');
    }

    /**
     * @Route("/index", name = "all_posts")
     * @Template
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post');
        $posts = $em->findAll();
        return ['posts' => $posts];
    }

}
