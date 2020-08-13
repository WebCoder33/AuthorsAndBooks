<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AddAdminUserCommand extends Command
{
    protected static $defaultName = 'app:add-admin-user';

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }


    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('pass', InputArgument::REQUIRED, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $pass = $input->getArgument('pass');

        if ($pass) {
            $io->note(sprintf('You passed an argument: %s', $pass));
        }

        $User = new User();
        $User->setUsername('admin');
        $User->setRoles(['ROLE_ADMIN']);

        $User->setPassword($this->passwordEncoder->encodePassword(
            $User,
            $pass
        ));

        $entityManager =  $this->entityManager;
        $entityManager->persist($User);
        $entityManager->flush();

        $io->success('Admin user has been created');
    }
}