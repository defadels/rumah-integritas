<?php

namespace Modules\Dapodik\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Dapodik\Models\DapodikKepalaSekolahModel;

class DapodikController extends Controller
{
    use KepalaSekolahTrait;
    use GuruTrait;
    use SekolahTrait;
    use SekolahSiswaTrait;
    use SiswaTrait;
    use SekolahAdministrasiTrait;
    use SekolahRombelTrait;
    use SekolahSiswaRekapTrait;
    use SekolahRuangKelasTrait;
    use SekolahLabTrait;
    use SekolahRuangGuruTrait;
    use SekolahWcTrait;
    use SekolahLainTrait;

    protected $theme;

    public function __construct()
    {
        $this->theme = config('app.backend_theme');
        $this->breadcrumb = [];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dapodik::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dapodik::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('dapodik::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dapodik::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function test(Request $request)
    {
        $url = 'https://branda.antaranews.com/login_gauth.php';
        $client = new Client();

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $data = [
            'user' => $request->input('satuindonesia.co'),
            'pass' => $request->input('YCbEa678'),
        ];

        // POST request using the created object
        $postResponse = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        // Get the response code
        $responseCode = $postResponse->getStatusCode();
        return response()->json(['response_code' => $responseCode]);

    }
}
