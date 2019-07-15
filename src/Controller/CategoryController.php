<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{categoryId}", name="category_blog")
     */
    public function getCategoryBlog($categoryId)
    {
        $listBlogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->getBlogByCategoryId($categoryId);

        return $this->render(
            'category/blog.html.twig', [
            'listBlogs' => $listBlogs
            ]
        );
    }
}
