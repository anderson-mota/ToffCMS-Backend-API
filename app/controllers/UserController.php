<?php

use App\Libraries\ResponseJson;
use App\Libraries\SaveRecipe;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return SaveRecipe::insert(new User);
	}

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @throws Exception
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (!$user instanceof User) {
            throw new Exception("User Does not exists.");
        }

        return ResponseJson::success('user', $user->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param integer $id
     * @throws Exception
     * @return Response
     */
    public function update($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (!$user instanceof User) {
            throw new Exception("User Does not exists.");
        }

        return SaveRecipe::update($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @throws Exception
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user instanceof User) {
            throw new Exception("User Does not exists.");
        }

        $success = $user->delete();

        if (!$success) {
            throw new Exception("Fail to remove User.");
        }

        return ResponseJson::ok();
    }
}
