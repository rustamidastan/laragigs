<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
        public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);

    }

    public function create() {
        return view('listings.create');
    }

    // public function store(Request $request) {
    //     // $formFiled = $request -> validate([
    //     //     'title'=>'required',
    //     //     'company'=>['reuqired', Rule::unique('listings', 'company')],
    //     //     'location'=>'required',
    //     //     'website'=>'required',
    //     //     'email'=>['required', 'email'],
    //     //     'tags'=>'required',
    //     //     'description'=>'required'
    //     // ]);
    //         dd($request->all());
    //     // Listing::cretae();
    //     // return redirect('/');
    // }

    public function store(Request $request) {
        // dd($request->all());
        return view('test');
    }
}
