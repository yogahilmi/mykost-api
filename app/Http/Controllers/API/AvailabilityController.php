<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Kost;
use App\Models\User;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Show all availability
     * Show availability that user sent before. (User only)
     * Show availability that owner received based on 'owner_id'. (Owner only)
     */
    public function index(Request $request) {
        if ($request->user()['role'] != 0) {
            return response()->json(
                Availability::where('user_id', $request->user()['id'])
                ->with('kost')
                ->orderBy('kost_id', 'asc')
                ->get(),
                200
            );
        } else {
            return response()->json(
                Availability::where('owner_id', $request->user()['id'])
                ->with('kost')
                ->orderBy('kost_id', 'asc')
                ->get(),
                200
            );
        }
    }

    /**
     * Show all availability
     * Show availability that user sent before (User only)
     * Show availability that owner received based on 'kost_id' (Owner only)
     */
    public function show(Request $request, $kost_id) {
        if ($request->user()['role'] != 0) {
            return response()->json(
                Availability::where('user_id', $request->user()['id'])
                ->where('kost_id', $kost_id)
                ->with('kost')
                ->orderBy('kost_id', 'asc')
                ->get(),
                200
            );
        } else {
            return response()->json(Availability::where('kost_id', $kost_id)->with('kost')->get(), 200);
        }
    }

    /**
     * User can ask room availability to owner kost
     * Ask about room availability will reduce user credit by 5 point
     */
    public function getAvailabilityRoom(Request $request, $kost_id) {
        $user_id = $request->user()['id'];
        $user = User::find($user_id);
        $role = $user->role;
        if ($role == 0) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Access forbidden'
            ], 403);

        } else {
            $kost = Kost::find($kost_id);
            if ($kost) {
                $credit = $user->credit;
                if ($credit < 5){
                    return response()->json([
                        'status' => TRUE,
                        'message' => 'Insufficient Credit! Your credit is not enough'
                    ], 200);
                } else {
                    $availability = Availability::create([
                        'user_id' => $user_id,
                        'kost_id' => $kost_id,
                        'owner_id' => $kost->user_id,
                        'status' => 0
                    ]);

                    if ($user && $availability) {

                        $credit = $credit - 5;
                        $user->credit = $credit;
                        $user->save();

                        return response()->json([
                            'status' => TRUE,
                            'message' => 'Your request has been sent'
                        ], 202);
                    } else {
                        return response()->json([
                            'status' => FALSE,
                            'message' => 'Failed to send your request'
                        ], 500);
                    }
                }
            } else {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Data not found'
                ], 404);
            }
        }
    }

    /**
     * Owner can give room availability to user
     */
    public function sendAvailabilityRoom(Request $request, $id){
        $user_id = $request->user()['id'];
        $user = User::find($user_id);
        $role = $user->role;
        if ($role != 0) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Access forbidden'
            ], 403);
        } else {
            $availability = Availability::find($id);
            if ($availability) {
                $availability->status = 1;
                $availability->is_available = $request->is_available;
                $availability->save();

                return response()->json([
                    'status' => TRUE,
                    'message' => 'Room availability has been sent'
                ], 200);
            } else {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Data not found'
                ], 404);
            }
        }
    }
}
