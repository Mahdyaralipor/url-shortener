<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::latest()->paginate(10);
        return view('welcome', compact('urls'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url|max:2048'
        ], [
            'original_url.required' => 'لطفا یک URL وارد کنید',
            'original_url.url' => 'URL وارد شده معتبر نیست',
            'original_url.max' => 'URL خیلی طولانی است'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $url = Url::create([
            'original_url' => $request->original_url,
            'short_code' => Url::generateShortCode()
        ]);

        return back()->with('success', 'لینک کوتاه شما آماده است!')
                    ->with('short_url', url($url->short_code));
    }

    public function redirect($code)
    {
        $url = Url::where('short_code', $code)->firstOrFail();

        $url->increment('clicks');

        return redirect($url->original_url);
    }
}
