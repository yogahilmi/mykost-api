<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * Create new kost data by owner
     */
    public function create() {
        return view('kost.create');
    }

    /**
     * Method to store data via API
     */
    public function store(Request $request) {
        $url = "http://localhost:8001/api/kost/create";
        $data = array(
            'name' => $request->name,
            'location' => $request->location,
            'price' => (int) $request->price,
            'description' => $request->description
        );
        $session = session()->get('data');
        $token = $session->access_token;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $this->client->post($url,[
                        'form_params' => $data,
                        'headers' => $headers])->getBody();
        $data = json_decode($response);
        return redirect()->route('dashboard')
                         ->with('success', 'Create success');
    }

    /**
     * Method view edit kost data
     */
    public function edit($id) {
        $url = "http://localhost:8001/api/kost/{$id}";
        $session = session()->get('data');
        $token = $session->access_token;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $this->client->get($url,['headers' => $headers])->getBody();
        $data = json_decode($response);
        return view('kost.edit', compact('data'));
    }

    /**
     * Method using for update kost data
     */
    public function update(Request $request, $id) {
        $url = "http://localhost:8001/api/kost/edit/{$id}";
        $data = array(
            'name' => $request->name,
            'location' => $request->location,
            'price' => (int) $request->price,
            'description' => $request->description
        );
        $session = session()->get('data');
        $token = $session->access_token;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $this->client->put($url,[
                        'form_params' => $data,
                        'headers' => $headers]);
        return redirect()->route('dashboard')
                         ->with('success', 'Update success');
    }

    /**
     * Method using for delete data
     */
    public function delete(Request $request, $id) {
        $url = "http://localhost:8001/api/kost/delete/{$id}";
        $session = session()->get('data');
        $token = $session->access_token;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $this->client->delete($url, ['headers' => $headers])->getBody();
        return redirect()->route('dashboard')
                         ->with('success', 'Delete success');
    }

    /**
     * Show all owner kost data list
     */
    public function dashboard() {
        $data = session()->get('data');
        $url = "http://localhost:8001/api/kost/data/list";
        $token = $data->access_token;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $this->client->get($url, ['headers' => $headers])->getBody();
        $kosts = json_decode($response);
        return view('kost.dashboard', compact('data', 'kosts'));
    }
}
