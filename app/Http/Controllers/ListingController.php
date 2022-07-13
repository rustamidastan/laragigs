<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
        public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(10)
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

    public function store(Request $request) {
        $formFiled = $request -> validate([
            'title'=>'required',
            'company'=>['required', Rule::unique('listings', 'company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required', 'email'],
            'tags'=>'required',
            'logo'=>'required',
            'description'=>'required'
        ]);
        if($request->hasFile('logo')) {
            $formFiled['logo']=$request->file('logo')->store('logos', 'public');
        }

        $formFiled['user_id']=auth()->id();
        Listing::create($formFiled);
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing) {
        return view('listings.edit', [
            'listing' => $listing
        ]);

    }

    public function update(Request $request, Listing $listing) {

        //Make sure logged in user is owner

        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }


        $formFileds = $request -> validate([
            'title'=>'required',
            'company'=>'required',
            'location'=>'required',
            'website'=>'required',
            'email'=>['required', 'email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if($request->hasFile('logo')) {
            $formFileds['logo']=$request->file('logo')->store('logos', 'public');
        }
        $listing->update($formFileds);
        return back()->with('message', 'Listing updated successfully!');
    }

    public function delete(Listing $listing) {
        
        //Make sure logged in user is owner

        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        else {
            $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
        }
    }

    public function manage() {
        return view('listings.manage', ['listings'=>auth()->user()->listings()->get()]);
    }

   
}
