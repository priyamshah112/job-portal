<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateDocUserAPIRequest;
use App\Http\Requests\API\UpdateDocUserAPIRequest;
use App\Models\DocUser;
use App\Repositories\DocUserRepository;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DocUserController
 * @package App\Http\Controllers\API
 */

class DocUserAPIController extends AppBaseController
{
    use ApiResponser;

    /** @var  DocUserRepository */
    private $docUserRepository;

    public function __construct(DocUserRepository $docUserRepo)
    {
        $this->docUserRepository = $docUserRepo;
    }

    /**
     * Display a listing of the DocUser.
     * GET|HEAD /docUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $docUsers = DocUser::with('roles')->get();
        foreach($docUsers as $user){
            if(count($user->roles) > 0 ){
                $user->role = $user->roles[0]['name'];
            }
            else{
                $user->role = null;
            }
        }
        return $this->sendResponse($docUsers, 'Doc Users retrieved successfully');
    }

    /**
     * Store a newly created DocUser in storage.
     * POST /docUsers
     *
     * @param CreateDocUserAPIRequest $request
     *
     * @return Response
     */
    public function userProfileUpdate(Request $request)
    {
        try {
            $input = $request->all();

            $id = $request->user()->id;

            $docUser = DocUser::where(['id' => $id])->first();

            $validator = $this->validateUserProfile($input, $request, $id, $docUser);

            if ($validator->fails()) {
                $arr = [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "message" => $validator->errors()->first(),
                    "data" => [],
                ];
                return ResponseFacade::json($arr);
            }
            //save thumbnail
            if ($request->has('thumbnail')) {
                $image_parts = explode(";base64,", $request->get('thumbnail'));
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $strFileName = uniqid() . '_' . time() . '.' . $image_type;
                $file = 'profile_pic/' . $request->user()->id . '/' . $strFileName;
                $path = Storage::disk('public')->put($file, $image_base64);
                $input['thumbnail'] = $strFileName;
                $input['img_path'] = 'storage/' . $file;
            }
            $docUser = DocUser::where('id', $id)->update($input);
            $docUser = DocUser::where('id', $id)->first();

            return $this->sendResponse($docUser, 'DocUser updated successfully');
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function validateUserProfile($input, $request, $id, $docUser)
    {

        //user having thumbnail or not in table
        if (!empty($docUser->thumbnail)) {
            //delete last image
            Storage::disk('public')->delete('profile_pic/' . $request->user()->id . '/' . $docUser->thumbnail);
        }
        //check user having on same id and same email
        if ($docUser->email) {
            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            ];
        } else {
            //user not having same email on table check validation
            $rules = [
                'email' => 'required|unique:doc_users,email',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            ];
        }

        return Validator::make($input, $rules);

    }
    /**
     * Display the specified DocUser.
     * GET|HEAD /docUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('read-dos-user')){
            return $this->sendAccessDenied('Access Denied');
        }
        $user = DocUser::where('id', $id)->with('roles')->first();
        if (empty($user)) {
            return $this->sendError('Dos user not found');
        }

        return $this->sendResponse($user, 'Dos User retrieved successfully');
    }

    /**
     * Update the specified DocUser in storage.
     * PUT/PATCH /docUsers/{id}
     *
     * @param int $id
     * @param UpdateDocUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        if(!auth()->user()->hasPermissionTo('write-dos-user')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->only(['first_name','last_name','mobile_number','country_id','active']);
        $validator = $this->updateValidation($request, $id);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        $user = DocUser::where('id', $id)->with('roles')->first();
        if (empty($user)) {
            return $this->sendError('User not found');
        }
        $user = $this->docUserRepository->update($input, $id);
        $user = DocUser::where('id', $id)->with('roles')->first();
        return $this->sendResponse($user, 'Dos User updated successfully');
    }

    /**
     * Remove the specified DocUser from storage.
     * DELETE /docUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-dos-user')){
            return $this->sendAccessDenied('Access Denied');
        }
        $docUser = $this->docUserRepository->find($id);

        if (empty($docUser)) {
            return $this->sendError('Doc User not found');
        }

        $docUser->delete();

        return $this->sendResponse($docUser, 'Doc User deleted successfully');
    }

    public function updateValidation($request, $id)
    {
        $input = $request->only(['first_name','last_name','country_id','active']);
        $rules = array(
            'first_name' => 'required|max:256',
            'last_name' => 'required|max:256',
            'country_id' => 'required',
            'active' => 'required',
        );
        return Validator::make($input, $rules);
    }
}