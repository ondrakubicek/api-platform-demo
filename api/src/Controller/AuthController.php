<?php declare(strict_types = 1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractController
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /**
     * AuthController Constructor
     *
     * @param UserRepository $usersRepository
     */
    public function __construct(UserRepository $usersRepository)
    {
        $this->userRepository = $usersRepository;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $newAccountData['email']    = $request->get('email');
        $newAccountData['password'] = $request->get('password');

        try {
            $account = $this->userRepository->createNewUser($newAccountData);
            return new Response(sprintf('User %s successfully created',$account->getEmail()));
        } catch (\Doctrine\ORM\ORMException $e) {
            return new Response(sprintf('User %s was not created.', $newAccountData['email'] ));
        }
    }

}
