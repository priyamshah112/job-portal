<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\SendMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    use ApiResponser,SendMail;

    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->get();
        $tempUsers = [];
        foreach($users as $user)
        {
            if($user->roles[0]['name'] !== 'super-admin'){
                $tempUsers[] = $user;
            }
        }
        return $this->sendResponse($tempUsers, 'Doc Users retrieved successfully');
    }


    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('write-user')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = $this->createValidation($request);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        //generate random password
        $length = 10;
        $str = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        $tempPassword = substr(str_shuffle($str), 0, $length);        
        $input['password'] = Hash::make($tempPassword);

        $data['subject'] = "Job Portal Credentials";
        $data['email'] = $input['email'];
        $data['password'] = $tempPassword;
        DB::beginTransaction();
        try{
            $user = $this->userRepository->create($input);

            $mailSend = $this->sendCredentialMail($data,$input['email']);
            if (empty($mailSend)) {
                return $this->sendError('Mail has not been send.');
            }
    
            $user->assignRole($input['user-role']);
            $user = User::where('id',$user->id)->with('roles')->first();
            DB::commit();
            return $this->sendResponse($user, 'User saved successfully');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                return ResponseFacade::json([
                    'success' => true,
                    'message' => [
                        'duplicate'=>'This gmail is already taken',
                    ]
                ],404);
            }
        }
    }

    public function changeInfo(Request $request)
    {
        $id = Auth::id();
        $input = $request->except(['email']);
        $rules = [
            'name' => 'required|max:256',
            'img_name' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=200,max_width=400,min_height=200,max_height=400',
        ];
        $messages = [
            'dimensions' => 'The image size must be at least minimum 200 x 200 pixels or maximum 400 x 400 pixels!',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $user = $this->userRepository->find($id);
        if(empty($user)){
            return $this->sendError('User Not Found');
        }
        try {
            //save thumbnail
            if($request->has('img_name')){
                if (!empty($user->thumbnail)) {
                    //delete last image
                    Storage::disk('public')->delete('profile_pic/' . $id . '/' . $user->thumbnail);
                }
                $input['thumbnail'] = $strFileName = uniqid() . time() .'.' . $request->img_name->getClientOriginalExtension();
                $filePath = '/public/profile_pic/'.$id;
                $path = $request->img_name->storeAs($filePath, $strFileName);
                Storage::url($path);
                $input['img_path'] = $request->getSchemeAndHttpHost() . '/storage/profile_pic/'.$id.'/'.$input['thumbnail'];   
            }
        
            $user = $this->userRepository->update($input, $id);
            return $this->sendResponse($user,'General Info Updated Successfully !');
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userid = Auth::id();
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
            return $this->sendError('Check your old password.');
        } else {
            if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                return $this->sendError('Please enter a password which is not similar then current password.');
            } else {
                $user = User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                return $this->sendResponse($user,'Password updated successfully.');
            }
        }

    }
    /**
     * Display the specified User.
     * GET|HEAD /Users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {    
        if(!auth()->user()->hasPermissionTo('read-user')){
            return $this->sendAccessDenied('Access Denied');
        }    
        $user = User::where('id',$id)->with('roles')->first();
        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user, 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /Users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id,Request $request)
    {
        if(!auth()->user()->hasPermissionTo('write-user')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $user = User::where('id',$id)->with('roles')->first();
        if (empty($user)) {
            return $this->sendValidationError('User not found');
        }
        $user = $this->userRepository->update($input, $id);
        if(count($user->roles) > 0){
            $user->removeRole($user->roles[0]->name); 
        }
        $user->assignRole($input['user-role']);
        $user = User::where('id',$id)->with('roles')->first();
        return $this->sendResponse($user, 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /Users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-user')){
            return $this->sendAccessDenied('Access Denied');
        }
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendResponse(new UserResource($user),' User deleted successfully');
    }

    public function createValidation($request)
    {
       $input = $request->all();
        $rules = array(
            'name' => 'required|max:256',
            'email' => ['required',Rule::unique('users')->whereNull('deleted_at')],
            'user-role'  => 'required'
        );
        return Validator::make($input, $rules);
     }
}