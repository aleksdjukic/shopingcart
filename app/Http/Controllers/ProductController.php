<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function addproduct()
    {
        $categories = Category::all()->pluck('category_name', 'category_name');

        return view('admin.addproduct')->with('categories', $categories);
    }

    public function products()
    {
        $products = Product::all();
        return view('admin.products')->with('products', $products);
    }

    public function saveproduct(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_image' => 'required|nullable|max:1999',
        ]);

        if ($request->hasFile('product_image')) {
            // 1:get file name with extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            // 2: just get file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3: get just extension
            $extension = $request->file('product_image')->getClientOriginalExtension();
            // 4: file name to store
            $fileNameToStore = $fileName . "_" . time() . '.' . $extension;
            // Upload image
            $path = $request->file('product_image')->storeAs('public/product-images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.png';
        }

        $product = new Product;
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        $product->product_image = $fileNameToStore;
        $product->status = 1;

        $product->save();
        return back()->with('status', ('The Product has been successffuly added'));
    }

    public function editproduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all()->pluck('category_name', 'category_name');

        return view('admin.editproduct')->with('product', $product)->with('categories', $categories);
    }

    public function updateproduct(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
        ]);

        $product = Product::findOrFail($request->input('id'));
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');

        if ($request->hasFile('product_image')) {
            // 1:get file name with extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            // 2: just get file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3: get just extension
            $extension = $request->file('product_image')->getClientOriginalExtension();
            // 4: file name to store
            $fileNameToStore = $fileName . "_" . time() . '.' . $extension;
            // Upload image
            $path = $request->file('product_image')->storeAs('public/product-images', $fileNameToStore);

            if ($product->product_image != 'noname.png') {
                Storage::delete('public/product_images/' . $product->product_image);
            }
            $product->product_image = $fileNameToStore;
        }

        $product->update();
        return redirect('/products')->with('status', ('The Product has been successfully updated'));
    }

    public function deleteproduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->product_image != 'noname.png') {
            Storage::delete('public/product_images/' . $product->product_image);
        }
        $product->delete();

        return redirect('/products')->with('status', ('The Product has been successfully deleted'));
    }

    public function activateproduct($id){
        $product = Product::findOrFail($id);

        $product->status = 1;
        $product->update();

        return redirect('/products')->with('status', ('The Product has been successfully activated'));
    }

    public function deactivateproduct($id){
        $product = Product::findOrFail($id);

        $product->status = 0;
        $product->update();

        return redirect('/products')->with('status', ('The Product has been successfully deactivated'));
    }
}
