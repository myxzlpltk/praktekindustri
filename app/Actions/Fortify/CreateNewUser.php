<?php

namespace App\Actions\Fortify;

use App\Models\Prodi;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use ReCaptcha\ReCaptcha;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return User|void
     */
    public function create(array $input){
		if (env('RECAPTCHA_ON')){
			$recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET'));
			$response = $recaptcha->setExpectedHostname(request()->getHttpHost())
				->setExpectedAction('register')
				->setScoreThreshold(0.6)
				->verify($input['g-recaptcha-response'], request()->ip());

			if(!$response->isSuccess()){
				return abort(403, 'Kode reCAPTCHA gagal dikenali. Silahkan coba lagi nanti!');
			}
		}

        Validator::make($input, [
        	'nim' => ['required', 'numeric', Rule::unique(Student::class)],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'prodi_id' => ['required', Rule::exists(Prodi::class, 'id')],
            'angkatan' => ['required', 'date_format:Y', 'before_or_equal:now'],
            'password' => $this->passwordRules(),
			'ktm' => 'required|file|image|max:512'
        ])->validate();

		$ktm = $input['ktm']->store('ktm');

        $user = new User;
		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->username = $input['nim'];
		$user->password = Hash::make($input['password']);
		$user->role = 'student';
		$user->save();

        $student = new Student;
        $student->user_id = $user->id;
		$student->nim = $input['nim'];
		$student->angkatan = $input['angkatan'];
		$student->prodi_id = $input['prodi_id'];
		$student->ktm = basename($ktm);
		$student->save();

		$user->student;
		$user->sendEmailVerificationNotification();

        return $user;
    }
}
