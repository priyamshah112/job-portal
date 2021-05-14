<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Validator;

class RoleApiController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    public function index(Request $request)
    {
        $notInRole=array('student','instructor','super-admin');
        $roles = $this->roleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        )->whereNotIn('name',$notInRole);

        return $this->sendResponse(RoleResource::collection($roles), 'Roles retrieved successfully');
    }

    public function frontEndRoles(Request $request)
    {
        $inRole=array('student','instructor');
        $roles = $this->roleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        )->whereIn('name',$inRole);

        return $this->sendResponse(RoleResource::collection($roles), 'Roles retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('create-role')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required',
            'permissions' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        DB::beginTransaction();
        try{
            $role = $this->roleRepository->create($input);
            $role->givePermissionTo($input['permissions']);
            DB::commit();
            return $this->sendResponse(new RoleResource($role), 'Role saved successfully');
        }
        catch(\Exception $e){
            return $e;
            DB::rollBack();
            return $this->sendError("Something Went Wrong At Server Side");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('read-role')){
            return $this->sendAccessDenied('Access Denied');
        }
        $role = $this->roleRepository->allQuery()->with('permissions')->where('id',$id)->first();
        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        return $this->sendResponse($role, 'Role retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        if(!auth()->user()->hasPermissionTo('write-role')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required',
            'permissions' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        $role = $this->roleRepository->allQuery()->with('permissions')->where('id',$id)->first();
        if (empty($role)) {
            return $this->sendError('Role not found');
        }
        if(count($role->permissions) > 0){
            foreach($role->permissions as $permission){
                $role->revokePermissionTo($permission->name); 
            }
        }
        $role->givePermissionTo($input['permissions']);

        $role = $this->roleRepository->update($input, $id);

        return $this->sendResponse(new RoleResource($role), 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-role')){
            return $this->sendAccessDenied('Access Denied');
        }
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role->delete();

        return $this->sendResponse($role,'Role deleted successfully');
    }
}