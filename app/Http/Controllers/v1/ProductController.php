<?php

namespace App\Http\Controllers\v1;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function index() {
        $products = Product::all();
        return response()->json($products);
    }

    public function create(Request $request) {
        if (!$this->callAction($request)) {
            return response()->json('Access Denied!');
        }
        $product = new Product;
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->in_stock = ($request->quantity > 0) ? true : false;
        $product->price = $request->price;
        $product->description = $request->description;

        $product->save();
        return response()->json($product);
    }

    public function show($id) {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id) {
        if (!$this->callAction($request)) {
            return response()->json('Access Denied!');
        }
        $product = Product::find($id);

        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->in_stock = ($request->quantity > 0) ? true : false;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        return response()->json($product);
    }

    public function destroy($id) {
        if (!$this->callAction($request)) {
            return response()->json('Access Denied!');
        }
        $product = Product::find($id);
        $product->delete();
        return response()->json('product removed successfully');
    }

    public function callAction($request) {
        $user = \Auth::user();
        $getAction = $request->route()[1]['uses'];
        $getFunction = explode('@', $getAction);
        $adminAction = ['create', 'update', 'destroy'];
        if (in_array($getFunction[1], $adminAction) && $user->id != 1) {
            return false;
        }
        return true;
    }

}
