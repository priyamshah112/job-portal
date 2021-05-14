<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateHomeBannerAPIRequest;
use App\Http\Requests\API\UpdateHomeBannerAPIRequest;
use App\Http\Resources\HomeBannerResource;
use App\Models\HomeBanner;
use App\Repositories\HomeBannerRepository;
use App\Traits\PhotoSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

/**
 * Class HomeBannerController
 * @package App\Http\Controllers\API
 */

class HomeBannerAPIController extends AppBaseController
{
    use PhotoSave;
    /** @var  HomeBannerRepository */
    private $homeBannerRepository;

    public function __construct(HomeBannerRepository $homeBannerRepo)
    {   
        $this->homeBannerRepository = $homeBannerRepo;
    }

    /**
     * Display a listing of the HomeBanner.
     * GET|HEAD /homeBanners
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $homeBanners = $this->homeBannerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(HomeBannerResource::collection($homeBanners), 'Home Banners retrieved successfully');
    }

    /**
     * Store a newly created HomeBanner in storage.
     * POST /homeBanners
     *
     * @param CreateHomeBannerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateHomeBannerAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create-banner')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();

        $validator = $this->createValidation($request);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('image_name')) {
            $image = $this->savePhoto($request, 'public/banner/', '/storage/banner/');
            $input['image_name'] = $image['image_name'];

            $input['image_path'] = $image['img_path'];
        }
        $homeBanner = $this->homeBannerRepository->create($input);

        return $this->sendResponse(new HomeBannerResource($homeBanner), 'Home Banner saved successfully');
    }

    public function createValidation($request)
    {
        $input = $request->all();
        $rules = array(
            'image_name' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=1500,max_width=1800,min_height=600,max_height=800',
            'title' => 'required|max:256',
            'description' => 'required|max:256',
            'button_text' => 'required|max:256',
            'preference' => 'required|integer|max:4,min:1|unique:home_banners,preference',
            'url' => 'required|max:256',
        );
        $messages = array(
            'dimensions' => 'The :attribute must be at least minimum 1500 x 600 pixels or maximum 1800 x 800 pixels!',
        );
        return Validator::make($input, $rules, $messages);
    }

    /**
     * Display the specified HomeBanner.
     * GET|HEAD /homeBanners/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('read-banner')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var HomeBanner $homeBanner */
        $homeBanner = $this->homeBannerRepository->find($id);

        if (empty($homeBanner)) {
            return $this->sendError('Home Banner not found');
        }

        return $this->sendResponse(new HomeBannerResource($homeBanner), 'Home Banner retrieved successfully');
    }

    /**
     * Update the specified HomeBanner in storage.
     * PUT/PATCH /homeBanners/{id}
     *
     * @param int $id
     * @param UpdateHomeBannerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHomeBannerAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('write-banner')){
            return $this->sendAccessDenied('Access Denied');
        }
        $homeBanner = $this->homeBannerRepository->find($id);
        $input = $request->all();

        if (empty($homeBanner)) {
            return $this->sendError('Home Banner not found.');
        }
        $validator = $this->updateValidation($request, $id);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('image_name')) {
            Storage::disk('public')->delete('banner/' . $homeBanner->image_name);
            $image = $this->savePhoto($request, 'public/banner/', '/storage/banner/');
            $input['image_name'] = $image['image_name'];

            $input['image_path'] = $image['img_path'];

        }

        $homeBanner = $this->homeBannerRepository->update($input, $id);

        return $this->sendResponse(new HomeBannerResource($homeBanner), 'HomeBanner updated successfully');
    }
    public function updateValidation($request, $id)
    {
        $input = $request->all();
        $rules = array(
            'image_name' => 'image|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=1500,max_width=1800,min_height=600,max_height=800',
            'title' => 'required|max:256',
            'description' => 'required|max:256',
            'button_text' => 'required|max:256',
            'preference' => ['required','integer','max:4','min:1',Rule::unique('home_banners')->whereNot('id',$id)],
            'url' => 'required|max:256',
        );
        $messages = array(
            'dimensions' => 'The :attribute must be at least minimum 1500 x 600 pixels or maximum 1800 x 800 pixels!',
        );

        return Validator::make($input, $rules, $messages);
    }

    /**
     * Remove the specified HomeBanner from storage.
     * DELETE /homeBanners/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-banner')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var HomeBanner $homeBanner */
        $homeBanner = $this->homeBannerRepository->find($id);

        if (empty($homeBanner)) {
            return $this->sendError('Home Banner not found');
        }
        Storage::disk('public')->delete('banner/' . $homeBanner->image_name);

        $homeBanner->delete();

        return $this->sendResponse($homeBanner, 'Home Banner deleted successfully');
    }
}