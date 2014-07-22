<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected static $user;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * @var array
	 */
	protected $fillable = array("email", "password", "api_key");

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
	 * @return object
	 */
	public static function getCurrent()
	{
		return static::$user;
	}
}
