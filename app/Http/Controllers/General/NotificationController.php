<?php

namespace App\Http\Controllers\General;

use App\Helpers\PaginationResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponser;

    private array $texts = [
        'list' => 'لیست اطلاعیه ها',
        'mark_as_read' => 'اطلاعیه با موفقیت خوانده شد.',
        'not_found' => 'اطلاعیه مورد نظر یافت نشد.',
        'delete' => 'اطلاعیه با موفقیت حذف شد.',
        'mark_all_as_read' => 'تمامی اطلاعیه ها با موفقیت خوانده شدند.',
    ];

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(
            $this->texts['list'],
            NotificationResource::collection(auth()->user()->notifications()->latest()->limit(5)->get())
        );
    }

    public function getNotifications(): \Illuminate\Http\JsonResponse
    {
        $notifications = auth()->user()->notifications();
        $pagination = $notifications->paginate(20);
        return $this->successResponse(
            $this->texts['list'],
            [
                ...PaginationResource::make($pagination, [
                    'unread' => $notifications->whereNull('read_at')->count()
                ]),
                'notifications' => NotificationResource::collection($pagination)
            ]
        );
    }

    public function markAsRead(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:notifications,id'
        ]);
        $notification = auth()->user()->notifications()->where('id', $request->id)->first();

        if (!$notification) {
            return $this->errorResponse($this->texts['not_found'], 404);
        }

        $notification->markAsRead();
        return $this->successResponse($this->texts['mark_as_read']);
    }

    public function markAllAsRead(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->unreadNotifications->markAsRead();
        return $this->successResponse($this->texts['mark_all_as_read']);
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:notifications,id'
        ]);
        $notification = auth()->user()->notifications()->where('id', $request->id)->first();

        if (!$notification) {
            return $this->errorResponse($this->texts['not_found'], 404);
        }

        $notification->delete();
        return $this->successResponse($this->texts['delete']);
    }


}
