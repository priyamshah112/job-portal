<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AFeedbackController extends Controller
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
