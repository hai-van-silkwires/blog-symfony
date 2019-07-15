<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index()
    {
        $listBlogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->getListBlogs();

        return $this->render(
            'blog/index.html.twig', [
            'listBlogs' => $listBlogs
            ]
        );
    }
}
