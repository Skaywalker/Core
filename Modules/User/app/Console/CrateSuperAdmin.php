<?php

namespace Modules\User\Console;

use Illuminate\Console\Command;
use Modules\User\Actions\Fortify\PasswordValidationRules;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\User\Database\Factories\AdminUserFactoryFactory;

//Kiskuta
class CrateSuperAdmin extends Command
{
    use PasswordValidationRules;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bcms:create-super-admin';

    /**
     * The console command description.
     */
    protected $description = 'Seeds an admin user with a specified email and password';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        do{
        $email= $this->ask('Please enter the email of the super admin');
        $validatorEmail=validator(['email'=>$email],['email'=>'required|email'],[
            'email.required'=>'Email is required',
            'email.email'=>'Email is not valid'
        ]);
        if($validatorEmail->fails())
        {
            $this->error($validatorEmail->errors()->first());
        }
        }while($validatorEmail->fails());
        do{
        $password= $this->secret('Please enter the password of the super admin');
        $passwordConfirmation = $this->secret('Confirm the password');

        $validatorPassword=validator(['password'=>$password,
            'password_confirmation' => $passwordConfirmation,],['password'=>$this->passwordRules()],[
            'password.required'=>'Password is required',
            'password.min'=>'Password must be at least 8 characters',
            'password.confirmed'=>'Passwords do not match',
            'password.regex'=>'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character',
        ]);
        if ($validatorPassword->fails()) {
            $this->error($validatorPassword->errors()->first());
        }}while ($validatorPassword->fails());
        AdminUserFactoryFactory::new()->withEmail($email)->withPassword($password)->create();
        $this->info('Super admin created, email: '.$email.' password: '.$password);
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
       return [];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [];
    }
}
