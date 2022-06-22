<?php

namespace App\Listener;

use App\Entity\Hotel;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserLogListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getObject();
        $user = $this->tokenStorage->getToken()->getUser();
        if($entity instanceof Hotel){
            $entity->setCreatedBy($user);
            $entity->setUpdatedBy($user);
        }
    }

    public function preUpdate(LifecycleEventArgs $args){
        $entity = $args->getObject();
        $user = $this->tokenStorage->getToken()->getUser();
        if($entity instanceof Hotel){
            $entity->setUpdatedBy($user);
        }
    }
}