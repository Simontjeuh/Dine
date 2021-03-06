<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Product;
use App\Allergen;
use App\Category;
use Illuminate\Http\Request;

class adminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add(Request $request)
    {
        $message = session('message');
        $request->session()->pull('message', 'default');
        $code = session('code');
        $request->session()->pull('code', 'default');
        $products = DB::table('products')
            ->leftJoin('allergen_product', 'allergen_product.product_id', '=', 'products.id')
            ->leftJoin('allergens', 'allergens.id', '=', 'allergen_id')
            ->select('products.*', 'allergens.id AS allergen_id')
            ->get();
        $allergens = Allergen::all();
        $categories = Category::all();
        return view('add', [
            'allergens' => $allergens,
            'categories' => $categories,
            'products' => $products,
            'message' => $message,
            'code' => $code,
            'username' => 'Jefke'
            ]);
    }

    public function edit(Request $request)
    {
        $message = session('message');
        $request->session()->pull('message', 'default');
        $code = session('code');
        $request->session()->pull('code', 'default');
        $products = DB::table('products')
            ->select('products.*', DB::raw('GROUP_CONCAT(allergen_id) AS allergen_id'))
            ->leftJoin('allergen_product', 'allergen_product.product_id', '=', 'products.id')
            ->leftJoin('allergens', 'allergens.id', '=', 'allergen_id')
            ->groupBy('products.id')
            ->get();
        $allergens = Allergen::all();
        $categories = Category::all();
        for ($i = 0; $i < count($products); $i++) {
            $allergensArray = explode(",", $products[$i]->allergen_id);
            $products[$i]->allergen_id = $allergensArray;
        }
        return view('edit', [
            'allergens' => $allergens,
            'categories' => $categories,
            'products' => $products,
            'message' => $message,
            'code' => $code,
            'username' => 'Jefke'
            ]);
    }

    public function rem(Request $request)
    {
        $message = session('message');
        $request->session()->pull('message', 'default');
        $allergens = Allergen::all();
        $categories = Category::all();
        return view('rem', ['allergens' => $allergens, 'categories' => $categories, 'message' => $message]);
    }


    public function noperm()
    {
        return view('nopermission');
    }

}
