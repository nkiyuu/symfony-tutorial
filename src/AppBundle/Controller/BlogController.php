<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
*/
class BlogController extends Controller
{
    /**
     * @Route("/", name="blog_index")
    */
    public function indexAction(Request $request)
    {
        $em = $this ->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAll();

        return $this -> render('blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_show")
    */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }

        return $this->render('blog/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/new", name="blog_new")
    */
    public function newAction(Request $request)
    {
        $form = $this->createFormBuilder(new Post())
            ->add('title')
            ->add('content')
            ->getForm();

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
