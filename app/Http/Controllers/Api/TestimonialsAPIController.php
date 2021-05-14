<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateTestimonialsAPIRequest;
use App\Http\Requests\API\UpdateTestimonialsAPIRequest;
use App\Http\Resources\TestimonialsResource;
use App\Models\Testimonials;
use App\Repositories\TestimonialsRepository;
use App\Traits\PhotoSave;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\Storage;

/**
 * Class TestimonialsController
 * @package App\Http\Controllers\API
 */

class TestimonialsAPIController extends AppBaseController
{
    use PhotoSave;
    /** @var  TestimonialsRepository */
    private $testimonialsRepository;

    public function __construct(TestimonialsRepository $testimonialsRepo)
    {
        $this->testimonialsRepository = $testimonialsRepo;
    }

    /**
     * Display a listing of the Testimonials.
     * GET|HEAD /testimonials
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $testimonials = $this->testimonialsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TestimonialsResource::collection($testimonials), 'Testimonials retrieved successfully');
    }

    /**
     * Store a newly created Testimonials in storage.
     * POST /testimonials
     *
     * @param CreateTestimonialsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTestimonialsAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create-testimonial')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = $this->createValidation($request);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        if ($request->has('image_name')) {
            $image = $this->savePhoto($request, 'public/testimonial/', '/storage/testimonial/');
            $input['image_name'] = $image['image_name'];
            $input['image_path'] = $image['img_path'];
        }

        $testimonials = $this->testimonialsRepository->create($input);

        return $this->sendResponse(new TestimonialsResource($testimonials), 'Testimonials saved successfully');
    }

    /**
     * Display the specified Testimonials.
     * GET|HEAD /testimonials/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('read-testimonial')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var Testimonials $testimonials */
        $testimonials = $this->testimonialsRepository->find($id);

        if (empty($testimonials)) {
            return $this->sendError('Testimonials not found');
        }

        return $this->sendResponse(new TestimonialsResource($testimonials), 'Testimonials retrieved successfully');
    }

    /**
     * Update the specified Testimonials in storage.
     * PUT/PATCH /testimonials/{id}
     *
     * @param int $id
     * @param UpdateTestimonialsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTestimonialsAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('write-testimonial')){
            return $this->sendAccessDenied('Access Denied');
        }
        $testimonials = $this->testimonialsRepository->find($id);

        if (empty($testimonials)) {
            return $this->sendError('Testimonial Not found');
        }

        $input = $request->all();

        $validator = $this->updateValidation($request);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('image_name')) {
           Storage::disk('public')->delete('testimonial/'. $testimonials->image_name);
             $image = $this->savePhoto($request, 'public/testimonial/', '/storage/testimonial/');
            $input['image_name'] = $image['image_name'];

            $input['image_path'] = $image['img_path'];
        }

        $testimonials = $this->testimonialsRepository->update($input, $id);

        return $this->sendResponse(new TestimonialsResource($testimonials), 'Testimonials updated successfully');
    }
    public function updateValidation($request)
    {
        $input = $request->all();

        $rules = array(
            'image_name' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:width=60,height=60',
            'user_name' => 'required|max:256',
            'user_designation' => 'required|max:256',
            'title' => 'required|max:256',
            'comment' => 'required|max:256',
        );
        $messages = array(
            'dimensions' => 'The profile attribute must be 60 x 60 pixels !',
        );

        return Validator::make($input, $rules, $messages);
    }

    /**
     * Remove the specified Testimonials from storage.
     * DELETE /testimonials/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-testimonial')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var Testimonials $testimonials */
        $testimonials = $this->testimonialsRepository->find($id);
        if (empty($testimonials)) {
            return $this->sendError('Testimonials not found');
        }
        Storage::disk('public')->delete('testimonial/' . $testimonials->image_name);
        $testimonials->delete();

        return $this->sendResponse($testimonials, 'Testimonials deleted successfully');
    }

    public function createValidation($request)
    {
        $input = $request->all();
        $rules = array(
            'image_name' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:width=60,height=60',
            // 'image_name' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'user_name' => 'required|max:256',
            'user_designation' => 'required|max:256',
            'title' => 'required|max:256',
            'comment' => 'required|max:256',
        );
        $messages = array(
            'dimensions' => 'The profile attribute must be 60 x 60 pixels !',
        );

        return Validator::make($input, $rules, $messages);
    }
}