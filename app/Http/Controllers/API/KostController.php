<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Validator;
use App\Models\Kost;
use Illuminate\Http\Request;

class KostController extends Controller
{
    /**
     * Show all kost data
     */
    public function index() {
        return response()->json(Kost::all(), 200);
    }

    /**
     * Allow user to see kost detail
     */
    public function getKostById($id) {
        return response()->json(Kost::find($id), 200);
    }

    /**
     * Insert data kost
     * Allow owner to add kost
     *
     * @param  [string] name
     * @param  [string] description
     * @param  [string] location
     * @param  [string] price
     * @return [boolean] status
     * @return [string] message
     * @return [object] data
     */
    public function insertKost(Request $request) {
        if ($request->user()['role'] != 0) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Access forbidden'
            ], 403);
        } else {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required',
                'description' => 'required',
                'location' => 'required',
                'price' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Validation Error.'.$validator->errors()
                ], 400);
            }
            $data['user_id'] = $request->user()['id'];
            $kost = Kost::create($data);

            return response()->json([
                'status' => TRUE,
                'message' => 'Create success',
                'data' => $data
            ], 201);
        }
    }

    /**
     * Update data kost
     * Allow owner to update data
     *
     * @param  [string] name
     * @param  [string] description
     * @param  [string] location
     * @param  [string] price
     * @return [boolean] status
     * @return [string] message
     * @return [object] data
     */
    public function updateKost(Request $request, $id) {
        if ($request->user()['role'] != 0) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Access forbidden'
            ], 403);
        } else {
            $kost = Kost::find($id);
            if ($kost) {
                if ($request->name != null) {
                    $kost->name = $request->name;
                }
                if ($request->description != null) {
                    $kost->description = $request->description;
                }
                if ($request->location != null) {
                    $kost->location = $request->location;
                }
                if ($request->price != null) {
                    $kost->price = $request->price;
                }
                $kost->save();

                return response()->json([
                    'status' => TRUE,
                    'message' => 'Update success',
                    'data' => $kost
                ], 200);
            } else {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Data not found'
                ], 404);
            }
        }
    }

    /**
     * Delete data kost
     * Allow owner to delete data
     *
     * @return [boolean] status
     * @return [string] message
     */
    public function deleteKost(Request $request, $id) {
        if ($request->user()['role'] != 0) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Access forbidden'
            ], 403);
        } else {
            $kost = Kost::find($id);
            if ($kost) {
                /**
                 * Deleted availability with kost_id if available.
                 */
                $kost->destroy($id);
                $availability = Availability::where('kost_id', $id);
                if ($availability) {
                    $availability->delete();
                }
                return response()->json([
                    'status' => TRUE,
                    'message' => 'Delete success'
                ], 200);
            } else {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Data not found'
                ], 404);
            }
        }
    }

    /**
     * Search kost by several criteria: name, location, price
     * Sorted by price
     *
     * @param  [string] name
     * @param  [string] location
     * @param  [string] price
     * @return [string] status
     * @return [string] message
     * @return [object] data
     */
    public function searchKost(Request $request) {
        $name = $request->name;
        $location = $request->location;
        $price = $request->price;
        $kost = Kost::when($name, function ($query) use ($name) {
                        return $query->where('name', 'like', '%'.$name.'%');
                    })
                ->when($location, function ($query) use ($location) {
                        return $query->where('location', 'like', '%'.$location.'%');
                    })
                ->when($price, function ($query) use ($price) {
                        return $query->where('price', $price);
                    })
                ->orderBy('price', 'desc')->get();
        if (count($kost) !== 0) {
            return response()->json([
                'status' => TRUE,
                'message' => 'Search success',
                'data' => $kost
            ], 200);
        } else {
            return response()->json([
                'status' => FALSE,
                'message' => 'Data not found'
            ], 404);
        }
    }

    /**
     * Show Kost Data by OwnerID
     * Allow owner to see his kost list
     */
    public function getKostList(Request $request) {
        if ($request->user()['role'] != 0) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Access forbidden'
            ], 403);
        } else {
            return response()->json([
                'status' => TRUE,
                'data' => Kost::where('user_id', $request->user()['id'])
                ->orderBy('price', 'asc')
                ->get()
            ], 200);
        }
    }
}
