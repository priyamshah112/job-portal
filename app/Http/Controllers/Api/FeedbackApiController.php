<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class FeedbackApiController extends AppBaseController
{
    public function userFeedbacks()
    {
            return DataTables::of(Feedback::whereNull('deleted_at')->with('user'))
                ->addColumn('action', function ($data) {
                    $menu = '<button title="Delete" onclick="deleter(' . $data->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                    return $menu;
                })
                ->rawColumns(['action'])
                ->make(true);


    }

    public function store(Request $request)
    {

        $validator  = Validator::make($request->all(),[
            'subject' => 'required',
            'feedback' => 'required',
            'fileToUpload' => 'mimes:jpeg,png|max:5048',
        ]);
        if($validator->fails()){
            return $this->sendValidationError($validator->errors());
        }

        $filename = "";
        if ($request->hasFile('fileToUpload')) {
            $filenameWithExt = $request->file('fileToUpload');
            $path = 'storage/feedbacks';
            $filename = uniqid() . time() . '.' . $filenameWithExt->getClientOriginalExtension();
            $filenameWithExt->move($path, $filename);
        }
        $user = Auth::user();
        Feedback::create([
            'user_id' =>2,
            'name' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
            'subject' => $request->subject,
            'message' => $request->feedback,
            'file_path' => $filename,
        ]);
        $message = 'Feedback Form has been Submitted Successfully';
        return collect(["status" => 1, 'message' => $message])->toJson();

    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $id = $request->id;
        $feedback = Feedback::find($id);
      if(!isset($feedback)){
          return collect(["status" => 0, "msg" => "Invalid Feedback"])->toJson();
        }
        $file =Feedback::find($id);
        if(!($file->file_path =='')){
            $oldFile ='storage/feedbacks/'.$file->file_path;
            unlink($oldFile);
        }
        $feedback = Feedback::where('id',$id)->firstOrFail()->delete();
        if($feedback == 0){
            DB::rollBack();
            return collect(["status" => 0, "msg" => "Can't Delete Feedback"])->toJson();
        }
        DB::commit();
        return collect(["status" => 1, "msg" => "Deleted Successfully"])->toJson();
    }
}
