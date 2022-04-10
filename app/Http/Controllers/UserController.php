<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * Login page
     */
    public function index() {
        return view('auth.login');
    }

    /**
     * Register page
     */
    public function register() {
        return view('auth.register');
    }

    /**
     * Method using for login via API
     */
    public function login(Request $request) {
        $url = "http://localhost:8001/api/auth/login";
        $data = array(
            'email' => $request->email,
            'password' => $request->password
        );
        $response = $this->client->post($url, ['form_params' => $data])->getBody();
        $data = json_decode($response);
        session()->put('data', $data);
        return redirect()->route('dashboard')
                         ->with('success', 'Login success');
    }

    /**
     * Method using for register via API
     */
    public function signup(Request $request) {
        $url = "http://localhost:8001/api/auth/register";
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => (int)$request->role
        );
        dd($data);
        $response = $this->client->post($url, ['form_params' => $data])->getBody();
        $data = json_decode($response);
        return redirect()->route('index')
                         ->with('success', 'Register success');
    }

    /**
     * Method using for logout via API
     */
    public function logout() {
        $data = session()->get('data');
        $url = "http://localhost:8001/api/auth/logout";
        $token = $data->access_token;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $this->client->post($url, ['headers' => $headers])->getBody();
        session()->flush();
        return redirect()->route('index')
                         ->with('success', 'Logout success');
    }
}
