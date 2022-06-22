<?php

namespace App\Listener;

use App\Entity\Hotel;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TimeLogListener
{
    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if($entity instanceof Hotel){
            $entity->setCreatedAt(new \DateTimeImmutable());
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function preUpdate(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if($entity instanceof Hotel){
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}