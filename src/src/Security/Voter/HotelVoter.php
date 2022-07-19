<?php

namespace App\Security\Voter;

use App\Entity\Hotel;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class HotelVoter extends Voter
{
    public const EDIT = 'HOTEL_EDIT';
    public const DELETE = 'HOTEL_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Hotel;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_EDITOR')) {
            return true;
        }

        switch ($attribute) {
            case self::EDIT:
                /** @var Hotel $subject */
                if($subject->getCreatedBy()->getId() === $user->getId())
                    return true;
                break;
            case self::DELETE:
                if($subject->getCreatedBy()->getId() === $user->getId())
                    return true;
                break;
        }

        return false;
    }
}
