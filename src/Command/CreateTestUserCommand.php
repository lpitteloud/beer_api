<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-test-user',
    description: 'Create a user for test purpose',
)]
class CreateTestUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('password', InputArgument::OPTIONAL, 'Password', 'password')
            ->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Username', 'testuser')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $plainPassword = $input->getArgument('password');
        $username = $input->getOption('username');

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        if ($existingUser) {
            $io->error(sprintf('User already exists for username "%s"', $username));

            return Command::FAILURE;
        }

        $user = new User(
            username: $username,
            roles: ['ROLE_USER']
        );

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf(
            'User successfully created !' . PHP_EOL .
            'Username: %s' . PHP_EOL .
            'Mot de passe: %s' . PHP_EOL .
            'Rôles: %s',
            $user->getUsername(),
            $plainPassword,
            implode(', ', $user->getRoles())
        ));

        return Command::SUCCESS;
    }
}