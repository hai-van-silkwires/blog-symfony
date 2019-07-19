<?php

namespace App\Controller;

use App\DTO\Request\BlogRequest;
use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Repository\CategoryRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $blogRepository;
    private $categoryRepository;
    private $fileUpload;
    private $uploadDir;

    /**
     * @param BlogRepository $blogRepository [description]
     */
    public function __construct(BlogRepository $blogRepository,
                                CategoryRepository $categoryRepository,
                                FileUploader $fileUpload) {
        $this->blogRepository     = $blogRepository;
        $this->categoryRepository = $categoryRepository;
        $this->fileUpload         = $fileUpload;
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
     * @Route("/admin/blog/insert", name="blog_get_insert", methods={"GET"})
     */
    public function getInsert()
    {
      $listCategories = $this->categoryRepository
                             ->getListCategories();
      return $this->render(
          'blog/insert.html.twig', [
            'listCategories' => $listCategories
          ]
      );
    }

    /**
     * @Route("/admin/blog/insert", name="blog_insert", methods={"POST"})
     */
    public function postInsert(BlogRequest $request)
    {
      $listCategories = $this->categoryRepository
                             ->getListCategories();
      if (!empty($request->getErrors())) {
        return $this->render(
            'blog/insert.html.twig', [
              'listCategories' => $listCategories,
              'errors'         => $request->getErrors()
            ]
        );
      }

      $this->fileUpload->upload($this->uploadDir, $request->featureImage, $request->featureImageName);
      $request->featureImage = $this->imageDir . $request->featureImageName;

      $result = $this->blogRepository
                     ->insert($request);
      return $this->redirectToRoute('blog');
    }

    /**
     * @Route("/admin/blog/update/{id}", name="blog_update")
     */
    public function update(BlogRequest $request, $id)
    {
        // If request data has errors, redirect to blog detail
        if (!empty($request->getErrors())) {
          return $this->redirectToRoute('blog_detail', array(
              'id'     => $id,
              'errors' => $request->getErrors()
              )
          );
        }

        $this->fileUpload->upload($this->uploadDir, $request->featureImage, $request->featureImageName);
        $request->featureImage = $this->imageDir . $request->featureImageName;

        $result = $this->blogRepository
                       ->update($request, $id);
        return $this->redirectToRoute('blog_detail', array(
            'id' => $id
            )
        );
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
