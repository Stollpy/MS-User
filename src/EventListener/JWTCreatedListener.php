<?php



namespace App\EventListener;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;


class JWTCreatedListener
{

    private $requestStack;

    private $userRepository;

    private $security;

    /**
     * @param RequestStack $requestStack
     * @param UserRepository $user_repository
     * @param Security $security
     */
    public function __construct(RequestStack $requestStack, UserRepository $userRepository, Security $security)
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $this->userRepository->find($this->security->getUser());

        $payload = $event->getData();
        $payload['data']['user_id'] = $user->getId();

        $event->setData($payload);
    }

}