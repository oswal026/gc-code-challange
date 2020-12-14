<?php

namespace App\Controller\Api;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Get all users
     * @Route("/api/users", name="api_user_list", methods={"GET"})
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(['Users' => $this->session->all()]);
    }

    /**
     * Add new user
     * @Route("/api/user/add", name="api_user_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            throw new \Exception('The user information is not correct.');
        }

        $id = $data['id'] ?? '';

        if (!$id) {
            $id = Uuid::uuid4();
        }

        $user = [
            'name' =>  $data['name'] ?? '',
            'attributes' => $data['attributes'] ?? []
        ];

        $this->session->set($id, $user);

        return new JsonResponse(['status' => 'User created!', 'User'=> $this->session->all()], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/user/", name="api_user_attribute_search", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsersByAttributeValue(Request $request): JsonResponse
    {
        $param = $request->get('param', '');

        if (!$param) {
            throw new \Exception('The search parameter is wrong.');
        }

        $users = $this->session->all();
        $result = array_filter($users, static function ($user) use ($param){
           foreach ($user['attributes'] as $attribute) {
              foreach ($attribute as $key => $value) {
                  if ($value == $param) {
                      return true;
                  }
              }
           }
        });

        return new JsonResponse(['users' => $result]);

    }
}
