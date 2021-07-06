<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RecruitersApiController extends AppBaseController
{

    public function index()
    {
        return DataTables::of(Recruiter::whereNull('deleted_at')->with('user')->with('package'))
            ->addColumn('action', function ($data) {
                $menu = '';
                if ($data->user->active == 1) {
                    $menu = '<buton title="Change Status" onclick="disable(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="toggle-right" class="text-success font-large-1"></i></buton>';
                } else {
                    $menu = '<buton title="Change Status" onclick="enable(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="toggle-left" class="text-danger font-large-1"></i></buton>';
                }
                $menu .= '<a title="View" href="' . route('recruiters-view', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary ml-1 font-medium-5"></i></a>';
                $menu .= '<a title="Edit" href="' . route('recruiters-edit', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
                $menu .= '<buton title="Delete" onclick="deleter(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                return $menu;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function view($id)
    {
        $breadcrumbs = [
            ['link' => "recruiters", 'name' => "Recruiter"],
            ['name' => "View Recruiter"],
        ];
        $user = User::find($id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::with('recruiter')->where('id', $id)->first();
        return response()->json([
            $user, $breadcrumbs
        ]);

    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $recruiter = Recruiter::where("user_id", $request->id)->first();
        if (!isset($recruiter)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $rec = Recruiter::find($recruiter->id);
        $recStatus = $rec->delete();
        $status = $user->delete();
        if (!isset($status) || !isset($recStatus)) {
            DB::rollBack();
            return collect(["status" => 0, "msg" => "Can't Delete Recruiter"])->toJson();
        }
        DB::commit();
        return collect(["status" => 1, "msg" => "Deleted Successfully"])->toJson();
    }

    public function updateCompany(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'company_name' => 'required',
            'company_address' => 'required',
            'company_mobile_1' => 'required',
            'company_mobile_2' => '',
            'company_landline_1' => '',
            'company_landline_2' => '',
            'department_id' => 'required',
            'no_of_employees' => 'required',
            'annual_turnover' => 'required',
            'doc_name' => '',
            'state' => 'required',
            'city' => 'required',
        ]);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
            return $this->sendValidationError($validator->errors());
        }
        Recruiter::where('user_id', $request->id)->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_mobile_1' => $request->company_mobile_1,
            'company_mobile_2' => $request->company_mobile_2,
            'company_landline_1' => $request->company_landline_1,
            'company_landline_2' => $request->company_landline_2,
            'department_id' => $request->department_id,
            'no_of_employees' => $request->no_of_employees,
            'annual_turnover' => $request->annual_turnover,
            'doc_name' => $request->doc_name,
            'city' => $request->city,
            'state' => $request->state
        ]);

        $message = 'Recruiter Data Updated Successfully';

        return collect(["status" => 1, "msg" => $message])->toJson();

    }

    public function updateAccount(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'active' => $request->status,
        ]);
        $message = 'Recruiter Data Updated Successfully';

        return collect(["status" => 1, "msg" => $message])->toJson();

    }

    public function disable(Request $request)
    {
        $recruiter = Recruiter::where("user_id", $request->id)->first();

        if (!isset($recruiter)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $user->active = '2';
        $status = $user->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Recruiter disabled successfully"])->toJson();
    }

    public function enable(Request $request)
    {
        $recruiter = Recruiter::where("user_id", $request->id)->first();
        if (!isset($recruiter)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Recruiter"])->toJson();
        }
        $user->active = '1';
        $status = $user->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Recruiter enabled successfully"])->toJson();
    }

}
