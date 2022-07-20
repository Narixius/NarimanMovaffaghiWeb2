<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\HotelRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'owner-hotels',
    description: 'The list of hotels owners and all of their hotels',
)]
class OwnerHotelsCommand extends Command
{

    private UserRepository $userRepository;
    private HotelRepository $hotelRepository;

    public function __construct(UserRepository $userRepository, HotelRepository $hotelRepository)
    {
        parent::__construct('owner-hotels');
        $this->userRepository = $userRepository;
        $this->hotelRepository = $hotelRepository;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
//        /** @var User[] $users */
//        $users = $this->userRepository->createQueryBuilder('user')
//            ->select(['user.id', 'user.email', 'h.name'])
//            ->leftJoin('App:Hotel', 'h', 'WITH', 'h.created_by = user.id')
//            ->where('LOWER(user.roles) like :role')
//            ->setParameter('role', '%HOTEL_OWNER%')
//            ->getQuery()->getResult();

        $hotels = $this->hotelRepository->createQueryBuilder('hotel')
            ->select(['user.id', 'user.email', 'GROUP_CONCAT(hotel.name)'])
            ->leftJoin('hotel.createdBy', 'user')
            ->where('LOWER(user.roles) like :role')
            ->setParameter('role', '%HOTEL_OWNER%')
            ->groupBy('user.id')
            ->getQuery()->getResult();

        $io->table(['User id', 'User Email', 'Hotels Name'], $hotels);

        return Command::SUCCESS;
    }
}
