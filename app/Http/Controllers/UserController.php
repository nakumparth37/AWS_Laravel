<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Email_otp;
use App\Models\Product;
use Laravolt\Avatar\Avatar;

class UserController extends Controller
{
    //show the use listing in data table
    public function index(Request $request)
    {
        $avatar = new Avatar();

        // dd($data);
        if ($request->ajax()) {
            $data = User::select('id', 'name', 'surname', 'email', 'phone_number', 'role_id', 'profileImage')->get()->toArray();
            foreach ($data as &$item) {
                if ($item['role_id'] == 1) {
                    $item['role_id'] = "Admin";
                } elseif ($item['role_id'] == 2) {
                    $item['role_id'] = "Seller";
                } else {
                    $item['role_id'] = "User";
                }

                if (!$item['profileImage']) {
                    $name = strtoupper($item['name']);
                    $name = strtoupper($item['surname']);
                    $item['profileImage'] = $avatar
                        ->create($name . $name)
                        ->setBackground($this->getRandomConfiguredColor())
                        ->toGravatar(['d' => 'identicon', 'r' => 'pg', 's' => 50]);
                }
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('profileImage', function ($row) {
                    $btn = "<img src='" . $row['profileImage'] . "' class='rounded-circle object-fit-cover' width=50 height=50  alt='" . $row['name'] . "'/>";
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = "
                            <a href = '" . url("/admin/users/edit-" . $row['id'] . "") . "' class='edit btn  btn-sm m-1 editUserData' data-bs-toggle='modal' id=" . $row['id'] . " data-bs-target='#editUser'><i class='fa-solid fa-pen text-warning'></i>
                            </a><button class='edit btn btn-sm m-1 deleteUser'  id='" . $row['id'] . "'><i class='fa-solid fa-trash text-danger'></i></button>
                        ";
                    return $btn;
                })
                ->rawColumns(['action', 'profileImage'])
                ->make(true);
        }
        return view('admin.Users.UserListing');
    }

    public function editUserData($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'userData' => $user
        ], 200);
    }

    public function updateUserData(Request $request, User $user)
    {

        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:250',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role_type' => 'required',
                'surname' => 'required|string|max:250',
                'phone_number' => 'required|numeric|digits:10',
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        $userData = User::where('id', $user->id)->first();
        if ($userData) {
            $userData->name = $request->name;
            $userData->surname = $request->surname;
            $userData->email = $request->email;
            $userData->role_id = (int)$request->role_type;
            $userData->phone_number = (int)$request->phone_number;
            $userData->surname = $request->surname;

            $userData->save();
            return response()->json([
                'massage' => "$request->name is Updated successfully"
            ], 200);
        } else {
            return response()->json([
                'massage' => "Some thing went wrong try agin sone time after"
            ], 400);
        }
    }

    public function deleteUserData(User $user)
    {
        try {
            $userData = User::where('id', $user->id)->first();


            if ($userData) {
                $userData->delete();
                return response()->json([
                    'massage' => "$user->name is deleted successfully"
                ], 200);
            } else {
                return response()->json([
                    'massage' => "$userData->name is not exit any more"
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'massage' => $e->getMessage(),
            ], 500);
        }
    }

    public function addNewUser(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:250',
                'email' => 'required|email|unique:users',
                'role_type' => 'required',
                'surname' => 'required|string|max:250',
                'phone_number' => 'required|numeric|digits:10',
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        try {
            $userRoll = Role::where('id', $request->role_type)->firstOrFail();
            User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'role_id' => $userRoll->id,
                'password' => Hash::make("Password"),
                'is_email_verified' => 1,
                'created_at' => now()->timestamp,
                'email_verified_at' => now()->timestamp,
                'phone_number' => (int)$request->phone_number,
            ]);
            $userData = User::where('email', $request->email)->first();
            $name = $userData->name;
            $mailData = [
                "subject" => "Email Verification OTP",
                "name" => $name,
                "email" =>  $request->email,
                "password" => "Password",
            ];

            if (Mail::to($request->email)->send(new SendEmail($mailData, 'welcome_email'))) {
                return response()->json([
                    'massage' => "$request->name is created successfully!"
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'massage' => $th->getMessage()
            ], 500);
        }
    }

    public function getSellerList()
    {
        $seller = User::select('*')->where('role_id', 2)->get();
        return response()->json([
            'seller' => $seller
        ], 200);
    }

    private function getRandomConfiguredColor()
    {
        $backgrounds = config('laravolt.avatar.backgrounds');
        $randomColor = $backgrounds[array_rand($backgrounds)];
        return $randomColor;
    }
}
