<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class NotificationsController extends Controller {

    public function index() {
        $notifications = auth()->user()->notifications()->paginate(20);
        return response(['data' => $notifications, 'message' => 'success'], 200);
    }

    public function markAllAsRead() {
        auth()->user()->notifications->markAsRead();
        return response(['data' => null, 'message' => 'success'], 200);
    }

}
