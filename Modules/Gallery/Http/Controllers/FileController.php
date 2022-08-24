<?php

namespace Modules\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Image;
use File;
use Modules\Language\Entities\Language;
use Validator;
use LaravelLocalization;
use Session;
use DB;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        $files = DB::table('files')->get();
        return view('gallery::file_gallery', compact('files'));
    }

    public function store(Request $request)
    {

        // dd(strlen('majid'));
        $request->validate([
            'file' => 'required'
        ]);

        $file = $request->file;
        $full_name = $file->getClientOriginalName();
        $name = pathinfo($full_name, PATHINFO_FILENAME);
        if (strlen($name) > 20) {
            return back()->with('error', 'نام فایل انتخابی باید کمتر از 20 کاراکتر باشد');
        }
        $ext = $file->extension();


        $row = DB::table('files')->where('name', $name)->count();
        if ($row) {
            return back()->with('error', 'فایل انتخابی تکراری است');
        }
        $path = base_path('public/files' . '/');
        $file->move($path, $full_name);

        $url = url('download-file' . '/' . $full_name);

        $data = [
            'full_name' => $full_name,
            'name' => $name,
            'ext' => $ext,
            'url' => $url,
        ];
        DB::table('files')->insert($data);
        return redirect()->back()->with('success', 'فایل مورد نظر با موفقیت اضافه گردید');
    }

    public function delete($id)
    {
        $file = DB::table('files')->find($id);
        @unlink("public/files/$file->full_name");
        DB::table('files')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'فایل مورد نظر با موفقیت حذف گردید');
    }
}
