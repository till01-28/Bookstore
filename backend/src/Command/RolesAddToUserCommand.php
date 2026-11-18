<?php

namespace App\Command;

use App\Component\User\UserManager;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'roles:add-to-user',
    description: 'Add a role to User',
    aliases: ["r:add"]
)]
class RolesAddToUserCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserManager $userManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $idQuestion = new Question("Please enter the ID: ");

        # rol kiritilishda so'raladigan savol uchun obyekt yaratdik
        $roleQuestion = new Question("Plese, enter the role: ");

        $questionHelper = $this->getHelper('question');

        # user'ga rol qo'shish uchun o'zgaruvchan yaratdik
        $role = "";

        # $user nomli o'zgaruvchan yaratdik, standart holatda uning qiymati null'ga teng
        $user = null;

        $id = null;

        # $user null'ga teng bo'lsa, aylana ishlayveradi
        while (!$user) {
            while (!$id) {
                $id = $questionHelper->ask($input, $output, $idQuestion);

                if (!$id) {
                    $io->warning("Please enter the ID, compulsory information");
                }
            }

            # kiritilgan ID'ga teng user'ni MO'dan qidirdik
            $user = $this->userRepository->find($id);

            # agar foydalanuvchiga ega bo'lmagan ID kiritsak
            # bunday foydalanuvchi MO'da mavjud emas matni chiqadi
            if (!$user) {
                $io->warning("User with ID $id is not found");
                exit();
            }
        }
        # Rolni topish uchun aylanmai ishlatdik va rolni kiritish majburiy bo'lishi uchun uni if orqali tekshirdik
        while(!$role)
        {
            $role = $questionHelper->ask($input, $output, $roleQuestion);

            if(!$role)
            {
                $io->warning("Please enter the Role, compulsory information");
                exit();
            }
        }

        #MO'dan topib olingan user'ga Rolni berish uchun uni if bilan tekshirdik
        if ($user->getRoles())
        {
            # roles o'zgaruvchanini yaratdik, uning qiymati $user->getRoles'ga teng
            $roles = $user->getRoles();

            # Mavjud rol bor yoki yo'qligini PHP'ning mavjud in_array usuli orqali tekshirdik
            if (in_array($role, $roles, true)) {
                $io->warning("User has this $role already");
                return Command::SUCCESS;
            }
            # Kiritilayotgan ma'lumotni ko'plik shaklida qabul qilishni ko'rsatdik
            # Sababi, $user->role ko'plik shaklida
            $roles[] = $role;

            # setRoles orqali user'ning ma'lumotini oldik
            $user->setRoles($roles);

            # save() usuli orqali MO'ga saqladik
            $this->userManager->save($user,true);

            $io->success("The role $role is added to User with ID $id");
        }
        return Command::SUCCESS;
    }
}
