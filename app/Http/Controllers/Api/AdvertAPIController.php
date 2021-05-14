<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateAdvertAPIRequest;
use App\Http\Requests\API\UpdateAdvertAPIRequest;
use App\Http\Resources\AdvertResource;
use App\Models\Advert;
use App\Repositories\AdvertRepository;
use App\Traits\PhotoSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;

/**
 * Class AdvertController
 * @package App\Http\Controllers\API
 */

class AdvertAPIController extends AppBaseController
{
    use PhotoSave;
    /** @var  AdvertRepository */
    private $advertRepository;

    public function __construct(AdvertRepository $advertRepo)
    {
        $this->advertRepository = $advertRepo;
    }

    /**
     * Display a listing of the Advert.
     * GET|HEAD /adverts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $adverts = $this->advertRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AdvertResource::collection($adverts), 'Adverts retrieved successfully');
    }

    /**
     * Store a newly created Advert in storage.
     * POST /adverts
     *
     * @param CreateAdvertAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAdvertAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create-advert')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = $this->createValidation($request);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if ($request->has('image_name')) {
            $input['image_name'] = $filename = uniqid() . time() . '.'.$request->image_name->getClientOriginalExtension();
            $strFileName = $filename;

            $filePath = '/public/vert/';
            $path = $request->image_name->storeAs($filePath, $strFileName);
            Storage::url($path);
            $input['img_path'] = $request->getSchemeAndHttpHost() . '/storage/vert/' . $strFileName;
        }

        $advert = $this->advertRepository->create($input);

        return $this->sendResponse(new AdvertResource($advert), 'Advert saved successfully');
    }

    /**
     * Display the specified Advert.
     * GET|HEAD /adverts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('read-advert')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var Advert $advert */
        $advert = $this->advertRepository->find($id);

        if (empty($advert)) {
            return $this->sendError('Advert not found');
        }

        return $this->sendResponse(new AdvertResource($advert), 'Advert retrieved successfully');
    }

    /**
     * Update the specified Advert in storage.
     * PUT/PATCH /adverts/{id}
     *
     * @param int $id
     * @param UpdateAdvertAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdvertAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('write-advert')){
            return $this->sendAccessDenied('Access Denied');
        }
        $advert = $this->advertRepository->find($id);
        $input = $request->all();

        $validator = $this->updateValidation($input);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }
        if (empty($advert)) {
            return $this->sendError('Advert Banner not found.');
        }

        if ($request->has('image_name')) {
            Storage::disk('public')->delete('vert/' . $advert->image_name);
            $image = $this->savePhoto($request, 'public/vert/', '/storage/vert/');
            $input['image_name'] = $image['image_name'];

            $input['img_path'] = $image['img_path'];
        }

        $advert = $this->advertRepository->update($input, $id);

        return $this->sendResponse(new AdvertResource($advert), 'Advert updated successfully');
    }
    public function updateValidation($input)
    {
        $rules = array(
            'image_name' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|max:2048|dimensions:min_width=1500,max_width=1800,min_height=600,max_height=800',
            'url' => 'required|max:512',
        );
        $messages = array(
            'dimensions' => 'The :attribute must be at least minimum 1500 x 600 pixels or maximum 1800 x 800 pixels!',
        );

        return Validator::make($input, $rules, $messages);
    }

    /**
     * Remove the specified Advert from storage.
     * DELETE /adverts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-advert')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var Advert $advert */
        $advert = $this->advertRepository->find($id);

        if (empty($advert)) {
            return $this->sendError('Advert not found');
        }
        Storage::disk('public')->delete('vert/' . $advert->image_name);

        $advert->delete();

        return $this->sendResponse($advert, 'Advert deleted successfully');
    }

    public function createValidation($request)
    {
        $input = $request->all();
        $rules = array(
            'image_name' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|max:2048|dimensions:min_width=1500,max_width=1800,min_height=600,max_height=800',
            'url' => 'required|max:512',
        );
        $messages = array(
            'dimensions' => 'The :attribute must be at least minimum 1500 x 600 pixels or maximum 1800 x 800 pixels!',
        );

        return Validator::make($input, $rules, $messages);
    }
}
