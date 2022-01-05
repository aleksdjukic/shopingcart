<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function addslider(){
        return view('admin.addslider');
    }

    public function sliders(){
        $sliders = Slider::all();
        return view('admin.sliders')->with('sliders', $sliders);
    }

    public function saveslider(Request $request){
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'slider_image' => 'required|nullable|max:1999',
        ]);

        // 1:get file name with extension
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            // 2: just get file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3: get just extension
            $extension = $request->file('slider_image')->getClientOriginalExtension();
            // 4: file name to store
            $fileNameToStore = $fileName . "_" . time() . '.' . $extension;
            // Upload image
            $path = $request->file('slider_image')->storeAs('public/slider-images', $fileNameToStore);

        $slider = new Slider;
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->status = 1;
        $slider->slider_image = $fileNameToStore;

        $slider->save();
        return back()->with('status', ('The Slider has been successffuly added'));
    }

    public function editslider($id)
    {
        $slider = Slider::findOrFail($id);

        return view('admin.editslider')->with('slider', $slider);
    }

    public function updateslider(Request $request)
    {
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'slider_image' => 'image|nullable|max:1999',
        ]);

        $slider = Slider::findOrFail($request->input('id'));
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');

        if ($request->hasFile('slider_image')) {
            // 1:get file name with extension
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            // 2: just get file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3: get just extension
            $extension = $request->file('slider_image')->getClientOriginalExtension();
            // 4: file name to store
            $fileNameToStore = $fileName . "_" . time() . '.' . $extension;
            // Upload image
            $path = $request->file('slider_image')->storeAs('public/slider-images', $fileNameToStore);

            if ($slider->slider_image != 'noname.png') {
                Storage::delete('public/slider_images/' . $slider->slider_image);
            }
            $slider->slider_image = $fileNameToStore;
        }

        $slider->update();
        return redirect('/sliders')->with('status', ('The Slider has been successfully updated'));
    }

    public function deleteslider($id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->slider_image != 'noname.png') {
            Storage::delete('public/slider_images/' . $slider->slider_image);
        }
        $slider->delete();

        return redirect('/sliders')->with('status', ('The Slider has been successfully deleted'));
    }

    public function activateslider($id){
        $slider = Slider::findOrFail($id);

        $slider->status = 1;
        $slider->update();

        return redirect('/sliders')->with('status', ('The Slider has been successfully activated'));
    }

    public function deactivateslider($id){
        $slider = Slider::findOrFail($id);

        $slider->status = 0;
        $slider->update();

        return redirect('/sliders')->with('status', ('The Slider has been successfully deactivated'));
    }
}
