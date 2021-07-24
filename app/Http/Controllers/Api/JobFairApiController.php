<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Job_fair;
use App\Traits\SaveTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobFairApiController extends AppBaseController
{

    use SaveTrait;

    public function index()
    {
        $role = Auth::user()->user_type; 
    
        if($role === 'admin')
        {
        }
        else if($role === 'recruiter')
        {
        }
        else if($role === 'candidate')
        {
        }

        return "index";
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'img_name' => 'required',
            'organizer_name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('img_name') && !empty($request->img_name)) {
            $image = $this->save_job_fair_banner($request->img_name);
            $input['img_name'] = $image['img_name'];
            $input['img_path'] = $request->getSchemeAndHttpHost().$image['img_path'];
        }

        $job_fair = Job_fair::create($input);
        return $this->sendResponse($job_fair, "Successfully Job Fair Created");
    }

    public function jobFairDetailsUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'organizer_name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('img_name') && !empty($request->img_name)) {
            $image = $this->save_job_fair_banner($request->img_name);
            $input['img_name'] = $image['img_name'];
            $input['img_path'] = $request->getSchemeAndHttpHost().$image['img_path'];
        }

        $job_fair = Job_fair::findOrFail($id);
        $job_fair->update($input);
        return $this->sendResponse($job_fair, "Successfully Updated Job Fair");
    }

    public function jobFairContactUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'address' => 'required',
            'mobile_number' => 'required',
            'email' => 'required|email',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        $job_fair = Job_fair::findOrFail($id);

        $job_fair->update($input);

        return $this->sendResponse($job_fair, "Successfully Updated Job Fair");
    }

    public function jobFairEventDateTimeUpdate($id, Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($input,[
            'dates' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'draft' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }
        
        $job_fair = Job_fair::findOrFail($id);

        $date = explode("to", $request->dates);

        $input['start_date'] = $date[0];
        $input['end_date'] = $date[1];
        $input['number_of_days'] = Carbon::parse($date[0])->diffInDays(Carbon::parse($date[1]));
        $job_fair->update($input);

        return $this->sendResponse($job_fair, "Successfully Updated Job Fair");
    }

    public function show($id)
    {
        $job_fair = Job_fair::findOrFail($id);

        return $this->sendResponse($job_fair, "Job Fair Retreived Successfully");
    }

    public function update($id, Request $request)
    {
        $job_fair = Job_fair::findOrFail($id);

        $input = $request->all();

        $validator  = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'organizer_name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
            'type' => 'required',
            'price' => 'required',
            'number_of_days' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('img_name') && !empty($request->img_name)) {
            $image = $this->save_job_fair_banner($request->img_name);
            $input['img_name'] = $image['img_name'];
            $input['img_path'] = $request->getSchemeAndHttpHost().$image['img_path'];
        }

        $job_fair->update($input);

        return $this->sendResponse($job_fair, 'Successfully Updated Job Fair');
    }

    public function destroy($id){
        $job_fair = Job_fair::findOrFail($id);
        Storage::disk('public')->delete('job_fair/' . $job_fair->img_name);
        $job_fair->delete();

        return $this->sendResponse($job_fair, "Successfully Job Fair Deleted");
    }
}