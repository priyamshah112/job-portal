<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Mail\Feedback as MailFeedback;
use App\Models\Feedback;
use App\Models\User;
use App\Traits\NotificationTraits;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class FeedbackApiController extends AppBaseController
{
    use NotificationTraits;

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

        DB::beginTransaction();

        try
        {
            $filename = "";
            if ($request->hasFile('fileToUpload')) {
                $filenameWithExt = $request->file('fileToUpload');
                $path = 'storage/feedbacks';
                $filename = uniqid() . time() . '.' . $filenameWithExt->getClientOriginalExtension();
                $filenameWithExt->move($path, $filename);
            }
            $user = Auth::user();

            $input = [
                'user_id' =>2,
                'name' => $user->first_name.' '.$user->last_name,
                'email' => $user->email,
                'subject' => $request->subject,
                'message' => $request->feedback,
                'file_path' => $filename,
            ];

            Feedback::create($input);

            Mail::to(env('MAIL_USERNAME'))->send(new MailFeedback($input));

            // Mail To Candidate
            $this->notification([
                "title" => 'Your feedback form is submitted successful.',
                "description" => 'Your feedback form is submitted successful. Please check your mailbox.',
                "receiver_id" => $user->id,
                "sender_id" => $user->id,
            ]);

            //Mail To Administrator
            $admin_id = User::role('admin')->first()->id;
            $this->notification([
                "title" => 'You Have Received Feedback From '.$user->first_name.' '.$user->last_name,
                "description" => 'You Have Received Feedback. Please check your mailbox.',
                "receiver_id" => $admin_id,
                "sender_id" => $user->id,
            ]);

            DB::commit();
            
            return $this->sendSuccess('Feedback Form has been Submitted Successfully');
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
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
