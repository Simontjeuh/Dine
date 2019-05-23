<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Allergen;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return response()->json(['data' => $product], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data["image"] = $request->image->store('');
        // afbeelding opslaan in /public/img/random gegenereerde naam
        // $data["image"] bevat gegenereerde naam voor in de database
        $product = Product::create($data);
        $allergens = array_values(array_filter($data["allergens"]));
        // id 0 uit array halen
        if (count($allergens) > 0) {
            $product->Allergens()->attach($allergens);
        }

        // return response()->json(['data' => $product], 201);
        // $allergens = Allergen::all();
        // $categories = Category::all();
        // return view('add', ['allergens' => $allergens, 'categories' => $categories, 'message' => 'Product toegevoegd.']);
        return redirect('/add')->with('message', 'Product: \''. $data["name"] .'\' toegevoegd.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json(['data' => $product], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->has("category_id")) {
            $product->category_id = $request->category_id;
        }

        if ($request->has("name")) {
            $product->name = $request->name;
        }

        if ($request->has("image")) {
            $request->image = $request->image->store('');
            $product->image = $request->image;
        }

        if ($request->has("price")) {
            $product->price = $request->price;
        }

        if ($request->has("description")) {
            $product->description = $request->description;
        }

        if (!$product->isDirty()){
            return response()->json(['data' => 'You need to specify a different value to update.', 'code' => 422], 422);
        }
            $product->save();

            // return redirect()->route('edit');
            return redirect('/edit')->with('message', 'Product gewijzigd.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        // $products = DB::table('products')
        //     ->leftJoin('allergen_product', 'allergen_product.product_id', '=', 'products.id')
        //     ->leftJoin('allergens', 'allergens.id', '=', 'allergen_id')
        //     ->select('products.*', 'allergens.id AS allergen_id')
        //     ->get();
        // // return $products;
        // $allergens = Allergen::all();
        // $categories = Category::all();
        // $message = 'Product Verwijderd.';
        // return Response::view('edit', [
        //     'allergens' => $allergens,
        //     'categories' => $categories,
        //     'products' => $products,
        //     'message' => $message
        //     ]);
        // return response()->json('Product verwijderd.');
        return redirect('/edit')->with('message', 'Product verwijderd.');
        // return redirect()->route('add');
    }
}
