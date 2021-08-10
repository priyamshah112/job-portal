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
        $role = Auth::user()->user_type; 
    
        if($role === 'admin')
        {
            return view('candidate.index');
        }
        else if($role === 'recruiter')
        {
            return view('recruiter.all-candidates');
        }
        abort(403);
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

        if(!in_array($userType,['admin','recruiter']))
        {
            abort(403);
        }

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
