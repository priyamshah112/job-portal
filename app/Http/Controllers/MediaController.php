<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Traits\NotificationTraits;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    use NotificationTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware(function () {
            if (!auth()->user()->hasPermissionTo('read-candidate-video-resume')) {
                abort(403);
            }
        });
        $id = Auth::id();
        $candidate = Candidate::where('user_id', $id)->first();
        if ($candidate) {
            $capturedVideo = $candidate->video_resume_name ? true : false;
        } else {
            $capturedVideo = false;
        }

        return view('video-resume.index', compact('capturedVideo', 'candidate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        try {
            if ($request->hasFile('video')) {
                $candidate = Candidate::where('user_id', $id)->first();
                // delete the previous video-resume if anything
                if(!empty($candidate->video_resume_name) )
                {
                    $store_path ='video-resume/'.$candidate->video_resume_name;
                    Storage::disk('public')->delete($store_path); 
                }

                $file = $request->file('video');
                $path = 'storage/video-resume';
                $extension = 'mp4';
                $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension() . $extension;
                $file->move($path, $filename);

                $candidate->update([
                    "video_resume_name" => $filename,
                    "video_resume_path" => $path
                ]);

                $id = Auth::id();
                $candidate = Candidate::where('user_id', $id)->first();
                if ($candidate && $candidate->video_resume_name) {
                    $capturedVideo = true;
                } else {
                    $capturedVideo = false;
                }

                $this->notification([
                    "title" => 'Your video resume has been saved successfully',
                    "description" => 'Your video resume has been saved successfully',
                    "receiver_id" => $id,
                    "sender_id" => $id,
                ]);

                return view('video-resume.index', 
                compact('capturedVideo', 'candidate', ['success-message' => "Successfully Updated"]));
            }
        } catch (Exception $e) {
            return response()->json(['error-message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Media $media
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Media $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Media $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Media $media
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $candidate = Candidate::where('user_id', auth()->user()->id)->first();
                // delete the previous video-resume if anything
        if(!empty($candidate->video_resume_name) )
        {
            $store_path ='video-resume/'.$candidate->video_resume_name;
            Storage::disk('public')->delete($store_path); 
        }

        return redirect()->route('video-resume.index')
            ->with('success', 'video deleted successfully');
    }
}
