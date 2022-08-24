<?php

use Modules\Post\Entities\Post;



// Route::get('test2', function () {


//     $data = array('title' => 'سبقت ماکسیما');
//     $data = json_encode($data);

//     $headers = [
//         'Authorization: Apikey f32ff8bd-8083-5b6e-8fd5-594a4dd47013',
//         'Content-Type: application/json'
//     ];



//     $curl = curl_init();
//     $url = 'https://napi.arvancloud.com/vod/2.0/videos/e9dbd1a7-1983-4676-bc7c-09f52c022ed8';
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
//     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//     $resp = curl_exec($curl);
//     curl_close($curl);


//     $resp = json_decode($resp);
//     // dd($resp->data[0]->title);
// });


Route::get('test', function () {
dd(base_path());
    // header("Content-type: application/pdf");
    // header("Content-Disposition: attachment;filename='doc.pdf'");
    // readfile("1.pdf");
    // return view('test');
    exec("cd\ && cd Users\majid\Desktop && copy NUL ppppp.txt");
});

Route::post('file-post', function () {

    dd(request()->all());
});
