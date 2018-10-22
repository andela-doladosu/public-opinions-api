<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Delete user, together with all their comments and opinions
     *
     * @param int $id
     *
     * @return array
     */
    public function delete($id)
    {
        $requestUser = User::find($id);
        $loggedUser = \Auth::user()->id;

        if ($requestUser) {
            if ($requestUser->id === $loggedUser) {

                $requestUser->comments()->delete();
                $requestUser->opinions()->delete();

                if ($requestUser->delete()) {
                    return response()->json(
                        [
                            'errors' => [],
                            'data' => [],
                            'message' => 'User has been deleted.'
                        ],
                        200
                    );
                }
            }
        }
    }
}
