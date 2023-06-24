<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\MerchCategory;

class DashboardMerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $merchandise = Merchandise::with(['merchCategory'])->latest()->paginate(10);
        return view('dashboard.merchandises.index', [
            'title' => 'Merchs',
            'merchandise' => $merchandise,
            'startIndex' => $startIndex,
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
        $categories = MerchCategory::all();

        return view('dashboard.merchandises.addMerch', [
            'title' => 'Merchs',
            'categories' => $categories,
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

        //validate data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'image' => 'image|file|max:7168',
            'content' => 'required',
            'category_id' => 'required|exists:merch_categories,id',
        ]);




        // create a new news merhcandise entry
        $merchandise = new Merchandise;
        $merchandise->name = $validatedData['name'];
        $merchandise->price = $validatedData['price'];
        $merchandise->description = $validatedData['content'];
        $merchandise->category_id = $validatedData['category_id'];

        $truncatedName = substr($validatedData['name'], 0, 50);
        $slug = Str::slug($truncatedName, '-') . '-' . uniqid();
        while (Merchandise::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedName, '-') . '-' . uniqid();
        }
        $merchandise->slug = $slug;

        if ($request->file('image')) {
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
            'merchandise' => $merchandise
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
        $categories = MerchCategory::all();
        
        return view('dashboard.merchandises.edit', [
            'title' => 'Merchs',
            'merchandise' => $merchandise,
            'categories' => $categories,
        ]);
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
        //validate data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'image' => 'image|file|max:7168',
            'content' => 'required',
            'category_id' => 'required|exists:merch_categories,id',
        ]);


        // update the merhcandise entry
        $merchandise = Merchandise::find($merchandise->id);
        $merchandise->name = $validatedData['name'];
        $merchandise->price = $validatedData['price'];
        $merchandise->description = $validatedData['content'];
        $merchandise->category_id = $validatedData['category_id'];

        $truncatedName = substr($validatedData['name'], 0, 50);
        $slug = Str::slug($truncatedName, '-') . '-' . uniqid();
        while (Merchandise::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedName, '-') . '-' . uniqid();
        }
        $merchandise->slug = $slug;

        if ($request->file('image')) {
            if ($merchandise->image != null) Storage::delete($merchandise->image);
            $validatedData['image'] = $request->file('image')->store('merchandise-images');
            $merchandise->image = $validatedData['image'];
        }
        $merchandise->save();

        // redirect back to the form with a success message
        return redirect('/admin/dashboard/merchandise')->with('success', 'The merchandise has been updated!');
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
        if ($merchandise->image != null) Storage::delete($merchandise->image);
        Merchandise::destroy($merchandise->id);
        return redirect('/admin/dashboard/merchandise')->with('success', 'The merchandise has been deleted!');
    }
}
