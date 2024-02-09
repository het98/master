<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ResizeImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('image.display');
     
    
    }

    public function resizeImage(Request $request){
        $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $image = $request->file('file');
        $input['file'] = time().'.'.$image->getClientOriginalExtension();
        
        $destinationPath = public_path('/productImage');
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(275, 200, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath.'/'.$input['file']);
        $destinationPath = public_path('/uploads');
        $image->move($destinationPath, $input['file']);
        return back()
        	->with('success','Image has successfully uploaded.')
        	->with('fileName',$input['file']);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function zillowAPI(Request $request){

        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://zillow69.p.rapidapi.com/search?location=Houston%2C%20TX",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: zillow69.p.rapidapi.com",
                "X-RapidAPI-Key: eb0995cecbmshb5d08ee150e9d10p12fa79jsn0d20b35fe89a"
            ],
        ]);
        
        $response = curl_exec($curl);
        $data = json_decode($response,true);
        dd($data);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            dd($err);
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
