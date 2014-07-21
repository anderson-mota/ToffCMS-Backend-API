<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create(array(
			'email' => 'anderson.mota@lqdi.net',
			'password' => Hash::make('dev123'),
			'api_key' => sha1('key#1')
		));
	}

}
