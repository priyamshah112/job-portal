<?php

namespace App\Http\Controllers\API;

use App\Events\SendNotification;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateUserChatAPIRequest;
use App\Http\Requests\API\UpdateUserChatAPIRequest;
use App\Http\Resources\UserChatResource;
use App\Models\DocUser;
use App\Models\UserChat;
use App\Repositories\UserChatRepository;
use App\Traits\FrontendUserRole;
use App\Traits\PhotoSave;
use Illuminate\Http\Request;
use Response;

/**
 * Class UserChatController
 * @package App\Http\Controllers\API
 */

class UserChatAPIController extends AppBaseController
{

    use FrontendUserRole, PhotoSave;

    /** @var  UserChatRepository */
    private $userChatRepository;

    public function __construct(UserChatRepository $userChatRepo)
    {
        $this->userChatRepository = $userChatRepo;
    }

    /**
     * Display a listing of the UserChat.
     * GET|HEAD /userChats
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userChats = $this->userChatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(UserChatResource::collection($userChats), 'User Chats retrieved successfully');
    }
    /**
     * UserComment
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function Comment($id, Request $request)
    {
        $docUser = $this->userChatRepository->findUserChat($id, $request);

        if (empty($docUser)) {
            return $this->sendError(' User not found');
        }

        $comment = $docUser->comment($request->comment);
        $users['from'] = DocUser::where('id', $request->user()->id)->first(['first_name', 'last_name', 'img_path']);
        $users['to'] = DocUser::where('id', $id)->first(['first_name', 'last_name', 'img_path']);
        $docUser = DocUser::role('student')->where('id', $request->user()->id)->first();
        if (!empty($docUser)) {
            $data = $this->userChatRepository->notification($id, $request, $users,$comment);
            broadcast(new SendNotification($data, $id))->toOthers();
        }
        return $this->sendResponse($comment->toArray(), 'comment sended successfully');
    }

    /**
     * UserComments
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function UserComments($id, Request $request)
    {
        $docUser = $this->userChatRepository->findUserChat($id, $request);

        if (empty($docUser)) {
            return $this->sendError('User not found');
        }

        $comments = $docUser->comments()->with('commentator:id,first_name,last_name')->paginate(6);

        return $this->sendResponse($comments->toArray(), 'comment retrieved successfully');
    }

    /**
     * DosUserInstructor
     *
     * @param  mixed $request
     * @return void
    */
    public function DosUserInstructor(Request $request)
    {
        $docUser = DocUser::role('instructor')->with('roles')->paginate(6);
        return $this->sendResponse($docUser, 'User instructor retrieved successfully');
    }

    /**
     * DosUserStudent
     *
     * @param  mixed $request
     * @return void
    */

    public function DosUserStudent(Request $request)
    {
        $docUser = DocUser::role('student')->with('roles')->paginate(6);
        return $this->sendResponse($docUser, 'User student retrieved successfully');

    }

    /**
     * Store a newly created UserChat in storage.
     * POST /userChats
     *
     * @param CreateUserChatAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserChatAPIRequest $request)
    {
        $input = $request->all();

        $userChat = $this->userChatRepository->create($input);

        return $this->sendResponse(new UserChatResource($userChat), 'User Chat saved successfully');
    }

    /**
     * Display the specified UserChat.
     * GET|HEAD /userChats/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserChat $userChat */
        $userChat = $this->userChatRepository->find($id);

        if (empty($userChat)) {
            return $this->sendError('User Chat not found');
        }

        return $this->sendResponse(new UserChatResource($userChat), 'User Chat retrieved successfully');
    }

    /**
     * Update the specified UserChat in storage.
     * PUT/PATCH /userChats/{id}
     *
     * @param int $id
     * @param UpdateUserChatAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserChatAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserChat $userChat */
        $userChat = $this->userChatRepository->find($id);

        if (empty($userChat)) {
            return $this->sendError('User Chat not found');
        }

        $userChat = $this->userChatRepository->update($input, $id);

        return $this->sendResponse(new UserChatResource($userChat), 'UserChat updated successfully');
    }

    /**
     * Remove the specified UserChat from storage.
     * DELETE /userChats/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserChat $userChat */
        $userChat = $this->userChatRepository->find($id);

        if (empty($userChat)) {
            return $this->sendError('User Chat not found');
        }

        $userChat->delete();

        return $this->sendSuccess('User Chat deleted successfully');
    }
}