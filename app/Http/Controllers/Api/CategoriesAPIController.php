<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateCategoriesAPIRequest;
use App\Http\Requests\API\UpdateCategoriesAPIRequest;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Validation\Rule;
/**
 * Class CategoriesController
 * @package App\Http\Controllers\API
 */

class CategoriesAPIController extends AppBaseController
{
    /** @var  CategoriesRepository */
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepo)
    {
        $this->categoriesRepository = $categoriesRepo;
    }

    /**
     * Display a listing of the Categories.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoriesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CategoriesResource::collection($categories), 'Categories retrieved successfully');
    }

    /**
     * Store a newly created Categories in storage.
     * POST /categories
     *
     * @param CreateCategoriesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoriesAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create-category')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:categories,name|max:256,min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $categories = $this->categoriesRepository->create($input);

        return $this->sendResponse(new CategoriesResource($categories), 'Categories saved successfully');
    }

    /**
     * Display the specified Categories.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('read-category')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var Categories $categories */
        $categories = $this->categoriesRepository->find($id);

        if (empty($categories)) {
            return $this->sendError('Categories not found');
        }

        return $this->sendResponse(new CategoriesResource($categories), 'Categories retrieved successfully');
    }

    /**
     * Update the specified Categories in storage.
     * PUT/PATCH /categories/{id}
     *
     * @param int $id
     * @param UpdateCategoriesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoriesAPIRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('write-category')){
            return $this->sendAccessDenied('Access Denied');
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => ['required','string','max:256','min:1',Rule::unique('categories')->whereNot('id',$id)],
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        /** @var Categories $categories */
        $categories = $this->categoriesRepository->find($id);
        if (empty($categories)) {
            return $this->sendError('Categories not found');
        }

        $categories = $this->categoriesRepository->update($input, $id);

        return $this->sendResponse(new CategoriesResource($categories), 'Categories updated successfully');
    }

    /**
     * Remove the specified Categories from storage.
     * DELETE /categories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-category')){
            return $this->sendAccessDenied('Access Denied');
        }
        /** @var Categories $categories */
        $categories = $this->categoriesRepository->find($id);

        if (empty($categories)) {
            return $this->sendError('Categories not found');
        }

        $categories->delete();

        return $this->sendResponse($categories, 'Categories deleted successfully');
    }
}