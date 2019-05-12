<?php

namespace Core\Base\Commands\Scripts;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Core\User\Repositories\Interfaces\UserInterface;
use Validator;
use Exception;
use AclManager;
class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate user';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
       $this->createSuperUser();
    }

    /**
     * Create a superuser.
     *
     * @return bool
     * @author TrinhLe
     */
    protected function createSuperUser()
    {
        $this->info('Creating a Super User...');

        $user = app(UserInterface::class)->getModel();
        $user->first_name = $this->askWithValidate('Enter first name', 'required|min:2|max:60');
        $user->last_name = $this->askWithValidate('Enter last name', 'required|min:2|max:60');
        $user->email = $this->askWithValidate('Enter email address', 'required|email|unique:users,email');
        $user->username = $this->askWithValidate('Enter username', 'required|min:4|max:60|unique:users,username');
        $user->password = bcrypt($this->askWithValidate('Enter password', 'required|min:6|max:60'));
        $user->super_user = 1;
        $user->manage_supers = 1;
        $user->profile_image = config('base-user.acl.avatar.default');

        try {
            app(UserInterface::class)->createOrUpdate($user);
            if (AclManager::activate($user)) {
                $this->info('Super user is created.');
            }
        } catch (Exception $exception) {
            $this->error('User could not be created.');
            $this->error($exception->getMessage());
        }

        return true;
    }

    /**
     * @param $message
     * @param string $rules
     * @author TrinhLe
     */
    protected function askWithValidate($message, string $rules)
    {
        do {
            $input = $this->ask($message);
            $validate = $this->validate(compact('input'), ['input' => $rules]);
            if ($validate['error']) {
                $this->error($validate['message']);
            }
        } while ($validate['error']);

        return $input;
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     * @author TrinhLe
     */
    protected function validate(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return [
                'error'   => true,
                'message' => $validator->messages()->first(),
            ];
        }

        return [
            'error' => false,
        ];
    }
}