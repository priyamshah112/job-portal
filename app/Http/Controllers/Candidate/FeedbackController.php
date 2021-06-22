<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\AppBaseController;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class FeedbackController extends AppBaseController
{

    public function __construct()
    {
        //
    }
    public function userFeedbacks()
    {
        if (request()->ajax()) {
            return DataTables::of(Feedback::whereNull('deleted_at')->with('user'))
                ->addColumn('action', function ($data) {
                    $menu = '<button title="Delete" onclick="deleter(' . $data->id . ', this)" class="btn p-0 m-0"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
                    return $menu;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $pageConfigs = ['pageHeader' => false];
        return view('admin-feedback.index', ['pageConfigs' => $pageConfigs]);
    }

    public function candidates()
    {
        $userType = 'candidate';
        return view('feedback.index',compact('userType'));
    }
    public function recruiter()
    {
        $userType = 'recruiter';
        return view('feedback.index',compact('userType'));
    }
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'feedback' => 'required',
            'fileToUpload' => 'mimes:jpeg,png|max:5048',
        ]);
        $filename = "";
        if ($request->hasFile('fileToUpload')) {
            $filenameWithExt = $request->file('fileToUpload');
            $path = 'storage/feedbacks';
            $filename = uniqid() . time() . '.' . $filenameWithExt->getClientOriginalExtension();
            $filenameWithExt->move($path, $filename);
        }
        $user_id = auth()->user()->id;

        Feedback::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->feedback,
            'file_path' => $filename,
        ]);
        $message = 'Feedback Form has been Submitted Successfully';
        return redirect()->back()->with(['message' => $message]);
    }
    public function delete(Request $request)
    {
        DB::beginTransaction();
        $id = $request->id;
        $file =Feedback::find($id);
     //   dd($file->file_path); die();
        if(!($file->file_path =='')){
            $oldFile ='storage/feedbacks/'.$file->file_path;
            unlink($oldFile);
        }

     //   dd($oldFile); die();
//        if(file_exists($oldFile))
//        {
//
//        }
        $feedback = Feedback::where('id',$id)->firstOrFail()->delete();

        if($feedback == 0){
            DB::rollBack();
            return collect(["status" => 0, "msg" => "Can't Delete Feedback"])->toJson();
        }
        DB::commit();
        return collect(["status" => 1, "msg" => "Deleted Successfully"])->toJson();
    }
}
