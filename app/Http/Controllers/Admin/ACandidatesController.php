<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ACandidatesController extends AppBaseController
{

    public function __construct()
    {
        //
    }

    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Candidate::whereNull('deleted_at')->with('user'))
                ->addColumn('action', function ($data) {
                    $menu = '';
                    if ($data->user->active == 1) {
                        $menu = '<buton title="Change Status" onclick="disable(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="toggle-right" class="text-success font-large-1"></i></buton>';
                    } else {
                        $menu = '<buton title="Change Status" onclick="enable(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="toggle-left" class="text-danger font-large-1"></i></buton>';
                    }
                    $menu .= '<a title="View" href="' . route('acandidates-view', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary ml-1 font-medium-5"></i></a>';
                    $menu .= '<a title="Edit" href="' . route('acandidates-edit', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
                    $menu .= '<buton title="Delete" onclick="deleter(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                    return $menu;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin-candidates.index');
    }

    public function view($id)
    {
        $breadcrumbs = [
            ['link' => "admin/candidates", 'name' => "Candidate"],
            ['name' => "View Candidates"],
        ];
        $candidate = Candidate::with('user')->where('user_id', $id)->first();
        $userType = 'admin';
        $id = Auth::id();

        return view('resume.my-resume.index', compact('candidate','userType', 'breadcrumbs'));
    }
    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/candidates", 'name' => "Candidate"],
            ['name' => "Edit Candidates"],
        ];
        $id = $request->id;
        $cities = Cities::get(["name", "id"])->take(10);
        $candidate = Candidate::with('user')->where('user_id', $id)->first();
        return view('admin-candidates.edit', compact('candidate','cities', 'breadcrumbs'));
    }
    public function enable(Request $request)
    {
        $candidate = Candidate::where("user_id", $request->id)->first();
        if (!isset($candidate)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user->active = '1';
        $status = $user->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Status Changed Successfully"])->toJson();
    }

    public function disable(Request $request)
    {
        $candidate = Candidate::where("user_id", $request->id)->first();
        if (!isset($candidate)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user->active = '2';
        $status = $user->save();
        if (!isset($status)) {
            return collect(["status" => 0, "msg" => "Can't Change Status"])->toJson();
        }
        return collect(["status" => 1, "msg" => "Status Changed Successfully"])->toJson();
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $candidate = Candidate::where("user_id", $request->id)->first();
        if (!isset($candidate)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $user = User::find($request->id);
        if (!isset($user)) {
            return collect(["status" => 0, "msg" => "Invalid Candidate"])->toJson();
        }
        $rec = Recruiter::find($candidate->id);
        $recStatus = $rec->delete();
        $status = $user->delete();
        if (!isset($status) || !isset($recStatus)) {
            DB::rollBack();
            return collect(["status" => 0, "msg" => "Can't Delete Candidate"])->toJson();
        }
        DB::commit();
        return collect(["status" => 1, "msg" => "Deleted Successfully"])->toJson();
    }

    public function update(Request $request,$id)
    {
        $arr = [
            "first_name" => 'required',
            "last_name" => 'required',
            "dateOfBirth" => 'required',
            "permanent_address" => 'required',
            "city" => "required",
            "state" =>'required',
            "company_mobile_1" => "required",
            "email" => 'required',
            "alt_email" => 'required',
            "category" => 'required',
            "industry_type" => 'required',
            "job_location" => 'required',
            "img_name" => 'image|max:2048',
            "skills" => 'required|array',
            "education" => 'required',
            "about" => 'required',
        ];

        if($request->category == 'experienced'){
            $arr['category_type'] = 'required';

        }
        //  dd($arr); die();

        $request->validate($arr);
        // die($request);
        $image_name = "";
        if ($request->file('img_name')) {
            $filenameWithExt = $request->file('img_name')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_name')->getClientOriginalExtension();
            $image_name = $filename . '_' . time() . '.' . $extension;
            $request->file('img_name')->storeAs('public/profile_pic', $image_name);
            User::where('id', $id)->update(['img_path' => "storage/profile_pic", 'image_name' => $image_name]);
        }


        User::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->company_mobile_1,

        ]);
        $candidate_id = Candidate::where('user_id', $id)->first('id');
        $skills = json_encode($request->skills);

        $candidate = Candidate::where('id', $candidate_id->id)->update([
            'about'=> $request->about,
            'education' =>$request->education,
            'current_location_state' => $request->state,
            'current_location_city' => $request->city,
            'skills' => $skills,
            'dateOfBirth' => $request->dateOfBirth,
            'mobile_number' => $request->company_mobile_2,
            'alt_email' => $request->alt_email,
            'permanent_address' => $request->permanent_address,
            'category' => $request->category,
            'industry_type' => $request->industry_type,
            'category_work' => $request->category_type,

        ]);   $message = 'Resume Updated Successfully';
        return redirect()->back()->with(['message' => $message]);


    }
}
