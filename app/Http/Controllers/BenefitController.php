<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $benefits = Benefit::latest()->get();
        return view('benefits', compact('benefits'));
    }

    public function Benefit()
    {
        $benefits = Benefit::latest()->get(); // or paginate
        return view('benefits', compact('benefits'));
    }

    public function create()
    {
        return view('benefits'); // create a view file for this
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'image_links.*' => 'nullable|url',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('uploads/Benefits', 'public');
            }
        }

        $imageLinks = array_map(function($link) {
            return $link ?: null;
        }, $request->input('image_links', []));

        // Make sure links match number of images
        while (count($imageLinks) < count($imagePaths)) {
            $imageLinks[] = null;
        }

        Benefit::create([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'images' => json_encode($imagePaths),
            'image_links' => json_encode($imageLinks),
        ]);

        return redirect('/benefits')->with('success', 'Benefit created!');
    }

        public function edit($id)
    {
        $benefit = Benefit::findOrFail($id);
        return view('admin.editBenefit', compact('benefit'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'delete_images.*' => 'nullable|integer',
            'existing_image_links.*' => 'nullable|url',
            'new_image_links.*' => 'nullable|url',
        ]);

        $benefit = Benefit::findOrFail($id);

        // Start with existing images
        $existingImages = json_decode($benefit->images, true) ?? [];
        $existingLinks = json_decode($benefit->image_links, true) ?? [];

        // Handle image deletions BEFORE updating images
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $index) {
                if (isset($existingImages[$index])) {
                    Storage::disk('public')->delete($existingImages[$index]);
                    unset($existingImages[$index]);
                    unset($existingLinks[$index]);
                }
            }
            $existingImages = array_values($existingImages);
            $existingLinks = array_values($existingLinks);
        }

        // Handle new image uploads and their links
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Store the image and get its path
                $path = $image->store('uploads/Benefits', 'public');
                $existingImages[] = $path;

                // Get the corresponding URL from the form input, if provided
                $newImageLink = $request->input("new_image_links.{$index}");
                $existingLinks[] = $newImageLink ?: null; // Store the URL, or null if not provided
            }
        }

        // Handle new image links for existing images
        if ($request->has('existing_image_links')) {
            foreach ($request->input('existing_image_links') as $i => $link) {
                if (isset($existingLinks[$i])) {
                    $existingLinks[$i] = $link;
                }
            }
        }

        // Update the Benefit
        $benefit->update([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'images' => json_encode(array_values($existingImages)), // re-index the images array
            'image_links' => json_encode(array_values($existingLinks)), // re-index the links array
        ]);

        return redirect('/benefits')->with('success', 'Benefit updated!');
    }


    public function destroy($id)
    {
        $benefit = Benefit::findOrFail($id);
        $benefit->delete();

        return redirect('/benefits')->with('success', 'Benefit deleted!');
    }
}
