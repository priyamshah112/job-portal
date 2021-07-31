<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\Cities;
use App\Models\States;
use App\Models\User;
use App\Traits\JobTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class CandidatesController extends AppBaseController
{
    use JobTrait;

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
                    $menu .= '<a title="View" href="' . route('candidates-view', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary ml-1 font-medium-5"></i></a>';
                    $menu .= '<a title="Edit" href="' . route('candidates-edit', ['id' => $data->user->id]) . '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
                    $menu .= '<buton title="Delete" onclick="deleter(' . $data->user->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                    return $menu;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('candidate.index');
    }

    public function show($id)
    {
        $breadcrumbs = [
            ['link' => "candidates", 'name' => "Candidate"],
            ['name' => "View Candidates"],
        ];
        $candidate = Candidate::with('user','qualification')->where('user_id', $id)->first();
        if(empty($candidate))
        {
            abort(404);
        }
        
        $userType = auth()->user()->user_type;

        if ($candidate) {
            $capturedVideo  = $candidate->video_resume_name ? true : false;
        } else {
            $capturedVideo  = false;
        }
       
        $candidate['skillNames'] = $this->convertSkillIdsToSkillNames($candidate->skills);

        return view('resume.my-resume.index', compact('candidate','capturedVideo','userType', 'breadcrumbs'));
    }

    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => "candidates", 'name' => "Candidate"],
            ['name' => "Edit Candidates"],
        ];
        $id = $request->id;
        $cities = Cities::get(["name", "id"])->take(10);
        $candidate = Candidate::with('user')->where('user_id', $id)->first();
        return view('candidate.edit', compact('candidate','cities', 'breadcrumbs'));
    }
}
