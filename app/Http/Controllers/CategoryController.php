<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addcategory(){
        return view('admin.addcategory');
    }
    public function categories(){
        $categories = Category::all();

        return view('admin.categories')->with('categories', $categories);
    }

    public function savecategory(Request $request){
//        dd($request->all());
        $this->validate($request, [
             'category_name'  =>  'required|unique:categories'
        ]);
        $category = new Category;
        $category->category_name = $request->input('category_name');
        $category->save();

        return back()->with('status', ('The Category has been successffuly added'));
    }

    public function editcategory($id){

        $category = Category::findOrFail($id);

        return view('admin.editcategory')->with('category', $category);
    }

    public function updatecategory(Request $request){
        $this->validate($request, [
            'category_name' => 'required|unique:categories'
        ]);
        $category = Category::find($request->input('id'));
        $category->category_name = $request->input('category_name');

        $category->update();

        return redirect('/categories')->with('status', ('The Category has been successfully updated'));
    }

    public function deletecategory($id){
        $category = Category::find($id);
        $category->delete();

        return redirect('/categories')->with('status', ('The Category has been successfully deleted'));
    }
}
