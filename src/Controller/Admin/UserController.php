<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userRepository;

    /**
     * @param UserRepository $userRepository [description]
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin/user", name="admin_user_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        $listUsers = $this->userRepository
                          ->getListUsers();

        return $this->render(
            'admin/user/index.html.twig', [
            'listUsers' => $listUsers
            ]
        );
    }

    /**
     * @Route("/admin/user/insert", name="user_get_insert", methods={"GET"})
     * @IsGranted("ROLE_EDITOR")
     */
    public function getInsert()
    {
      $listCategories = $this->categoryRepository
                             ->getListCategories();
      return $this->render(
          'user/insert.html.twig', [
            'listCategories' => $listCategories
          ]
      );
    }

    // /**
    //  * @Route("/admin/user/insert", name="user_insert", methods={"POST"})
    //  * @IsGranted("ROLE_EDITOR")
    //  */
    // public function postInsert(userRequest $request)
    // {
    //   $listCategories = $this->categoryRepository
    //                          ->getListCategories();
    //   if (!empty($request->getErrors())) {
    //     return $this->render(
    //         'user/insert.html.twig', [
    //           'listCategories' => $listCategories,
    //           'errors'         => $request->getErrors()
    //         ]
    //     );
    //   }
    // }
}