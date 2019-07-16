<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\FileUploader;

class BlogController extends AbstractController
{
    private $blogRepository;
    private $categoryRepository;
    private $uploadDir;

    /**
     * @param BlogRepository $blogRepository [description]
     */
    public function __construct(BlogRepository $blogRepository,
                                CategoryRepository $categoryRepository) {
        $this->blogRepository     = $blogRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageDir           = '/assets/images/blog/';
        $this->uploadDir          = $_SERVER['DOCUMENT_ROOT'] . $this->imageDir;
    }

    /**
     * @Route("/blog/{id}", name="blog_detail")
     */
    public function getDetail($id)
    {
        $blog = $this->blogRepository
                     ->getDetailBlogById($id);
        $listCategories = $this->categoryRepository
                               ->getListCategories();

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
            'blog'           => $blog,
            'listCategories' => $listCategories
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

    /**
     * @Route("/admin/blog/insert", name="blog_insert")
     */
    public function insert(Request $request)
    {
        $listCategories = $this->categoryRepository
                               ->getListCategories();

      $data = $request->request->all();
      if (empty($data)) {
        return $this->render(
            'blog/insert.html.twig', [
              'listCategories' => $listCategories
            ]
        );
      }
      $result = $this->blogRepository
                     ->insert($data);
      return $this->redirectToRoute('blog');
    }

    /**
     * @Route("/admin/blog/update/{id}", name="blog_update")
     */
    public function update(Request $request, FileUploader $uploader, $id)
    {
      $data = $request->request->all();

      // If data is empty, redirect to blog index
      if (empty($data)) {
        return $this->redirectToRoute('blog');
      }
      // If featureImage is not uploaded, remove this index
      if (empty($data['featureImage'])) {
        unset($data['featureImage']);
      }

      $file                 = $request->files->get('featureImage');
      $filename             = $file->getClientOriginalName();
      $uploader->upload($this->uploadDir, $file, $filename);
      $data['featureImage'] = $this->imageDir . $filename;

      $result = $this->blogRepository
                     ->update($data, $id);
      return $this->redirectToRoute('blog_detail', ['id' => $id]);
    }

    /**
     * @Route("/admin/blog/delete/{id}", name="blog_delete")
     */
    public function delete(int $id)
    {
        $result = $this->blogRepository
                       ->delete($id);
        if ($result['success']) {
          $this->addFlash('success', $result['message']);
        } else {
          $this->addFlash('success', $result['message']);
        }

        return $this->redirectToRoute('blog');
    }
}
