<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardMerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $merchandise = Merchandise::latest()->paginate(10);
        return view('dashboard.merchandises.index', [
            'title' => 'Merchs',
            'merchandise' => $merchandise,     
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.merchandises.addMerch', [
            'title' => 'Merchs'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'image' => 'image|file|max:7168',
            'content' => 'required',
        ]);

        


        // create a new news article
        $merchandise = new Merchandise;
        $merchandise->name = $validatedData['name'];
        $merchandise->price = $validatedData['price'];
        $merchandise->description = $validatedData['content'];

        $truncatedName = substr($validatedData['name'], 0, 50);
        $slug = Str::slug($truncatedName, '-') . '-' . uniqid();
        while (Merchandise::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedName, '-') . '-' . uniqid();
        }
        $merchandise->slug = $slug;

        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('merchandise-images');
            $merchandise->image = $validatedData['image'];
        }
        $merchandise->save();

        // redirect back to the form with a success message
        return redirect('/admin/dashboard/merchandise')->with('success', 'a new merchandise has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function show(Merchandise $merchandise)
    {
        //
        return view('dashboard.merchandises.show', [
            'title' => 'Merch',
            'song' => $merchandise
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchandise $merchandise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchandise $merchandise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchandise $merchandise)
    {
        //
    }
}
