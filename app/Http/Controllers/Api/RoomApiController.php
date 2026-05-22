<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class RoomApiController extends Controller
{
    public function schedule($id)
    {
        $schedules = Schedule::with(['module', 'professor'])
            ->where('room_id', $id)
            ->get();

        return response()->json(['schedule' => $schedules]);
    }
}
