<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\ApiResponse;


use App\Class\UserDetail;

class UserController extends Controller
{
    //
    public $search;

    use ApiResponse;
    public function getall(Request $request)
    {

        if ($request->host() != "127.0.0.1") {
           return $this->forbident();
        }
        try {

            $users = User::query()
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%');
                })
                ->where('is_active', 1)
                ->orderBy('id', 'ASC')
                ->get()
                ->map(function ($user) {
                    return new UserDetail(
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->roles->code
                    );
                })
                ->all();

            return  $this->success($users);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
