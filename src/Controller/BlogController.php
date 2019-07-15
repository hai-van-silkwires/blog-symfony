<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;

class BlogController extends AbstractController
{
    private $blogRepository;

    /**
     * @param BlogRepository $blogRepository [description]
     */
    public function __construct(BlogRepository $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @Route("/blog/{id}", name="blog_detail")
     */
    public function getDetail($id)
    {
        $blog = $this->blogRepository
                     ->getDetailBlogById($id);

        if (!empty($blog)) {
            $blog = $blog[0];
        } else {
            return $this->render(
                'bundles/TwigBundle/Exception/error.html.twig', [
                'message' => 'No any blogs have id is ' . $id
                ]
            );
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
        $listBlogs = $this->blogRepository
                          ->getListBlogs();

        return $this->render(
            'blog/index.html.twig', [
            'listBlogs' => $listBlogs
            ]
        );
    }
}
