<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;

class CategoryController extends AbstractController
{
    private $blogRepository;

    /**
     * @param BlogRepository $blogRepository [description]
     */
    public function __construct(BlogRepository $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @Route("/category/{categoryId}", name="category_blog")
     */
    public function getCategoryBlog($categoryId)
    {
        $listBlogs = $this->blogRepository
                          ->getBlogByCategoryId($categoryId);

        if (empty($listBlogs)) {
            return $this->render(
                'bundles/TwigBundle/Exception/error.html.twig', [
                'message' => 'No any category have id is ' . $categoryId
                ]
            );
        }

        return $this->render(
            'category/blog.html.twig', [
            'listBlogs' => $listBlogs
            ]
        );
    }
}
