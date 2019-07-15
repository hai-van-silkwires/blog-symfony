<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{id}", name="blog_detail")
     */
    public function detail($id)
    {
        $blog = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->getDetailBlogById($id);

        if (!empty($blog)) {
            $blog = $blog[0];
        }

        return $this->render(
            'blog/detail.html.twig', [
            'blog' => $blog
              ]);
    }
  
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
