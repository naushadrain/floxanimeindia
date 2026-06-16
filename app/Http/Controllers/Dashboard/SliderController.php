<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->orderBy('id')->get();
        return view('dashboard.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('dashboard.slider.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:5120'],
            'image_url'   => ['nullable', 'url', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('sliders', 'public');
        }

        $data['is_active'] = true;
        unset($data['image']);

        Slider::create($data);

        return redirect()->route('dashboard.slider.index')
            ->with('success', 'Slider created successfully.');
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:5120'],
            'image_url'   => ['nullable', 'url', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image_path) Storage::disk('public')->delete($slider->image_path);
            $data['image_path'] = $request->file('image')->store('sliders', 'public');
        }

        unset($data['image']);
        $slider->update($data);

        return redirect()->route('dashboard.slider.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function toggle(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        return back()->with('success', 'Slider status updated.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image_path) Storage::disk('public')->delete($slider->image_path);
        $slider->delete();

        return redirect()->route('dashboard.slider.index')
            ->with('success', 'Slider deleted.');
    }
}
