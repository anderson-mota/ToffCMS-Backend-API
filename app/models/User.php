<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Libraries\SaveEloquentInterface;
use App\Libraries\RulesCollection;

/**
 * Class User
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $api_key
 */
class User extends Eloquent implements UserInterface, RemindableInterface, SaveEloquentInterface {

	/** @var self */
	protected static $user;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'updated_at');

	/**
	 * @var array
	 */
	protected $fillable = array('email', 'password', 'api_key');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * Validate the API key
	 * @param  string $api_key
	 * @param  integer $user_id
	 * @return boolean|object
	 */
	public static function validAPIKey($api_key, $user_id)
	{
		$user = self::where('id', $user_id)
					->where('api_key', $api_key)
					->get();

		// Wrong API key
		if ($user->count() !== 1)
		{
			return false;
		}

		static::$user = $user->first();

		// Return the users data
		return true;
	}

	/**
	 * Grab the current user
	 * @return static
	 */
	public static function getCurrent()
	{
		return static::$user;
	}

    /**
     * @param array $input
     * @param string|null $type
     * @return \Illuminate\Validation\Validator
     */
    public static function validate($input, $type = null)
    {
        $rules = new RulesCollection();
        $rules->add('email',  ['required', 'max:255', 'unique:users,email'])
            ->add('password', ['required', 'max:255,confirmed']) //use input password_confirmation
            ->add('api_key',  ['required', 'max:255']);

        return Validator::make($input, $rules->make($type));
    }

    /**
     * @param string $action
     */
    public function populate($action = 'insert')
    {
        $this->email = Input::get('email');

        if (Input::exists('password') and !empty(Input::get('password'))) {
            $this->password = Hash::make(Input::get('password'));
        }

        if ($action == 'insert') {
            $this->api_key = md5(uniqid(rand(), true));
        }
    }
}
