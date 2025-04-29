<?php

namespace App\Http\Controllers;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
        //the code below shows home page with cards added by the admin
        $cards = Card::latest()->get();
        return view('home', compact('cards'));
    }

    public function card()
    {
        $cards = Card::latest()->get(); // or paginate
        return view('admin.home', compact('cards'));
    }

    public function create()
    {
        return view('admin.home'); // create a view file for this
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
                $imagePaths[] = $image->store('uploads/cards', 'public');
            }
        }

        $imageLinks = array_map(function($link) {
            return $link ?: null;
        }, $request->input('image_links', []));

        // Make sure links match number of images
        while (count($imageLinks) < count($imagePaths)) {
            $imageLinks[] = null;
        }

        Card::create([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'images' => json_encode($imagePaths),
            'image_links' => json_encode($imageLinks),
        ]);

        return redirect('/admin/home')->with('success', 'Card created!');
    }

        public function edit($id)
    {
        $card = Card::findOrFail($id);
        return view('admin.editcard', compact('card'));
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

        $card = Card::findOrFail($id);

        // Start with existing images
        $existingImages = json_decode($card->images, true) ?? [];
        $existingLinks = json_decode($card->image_links, true) ?? [];

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
                $path = $image->store('uploads/cards', 'public');
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

        // Update the card
        $card->update([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'images' => json_encode(array_values($existingImages)), // re-index the images array
            'image_links' => json_encode(array_values($existingLinks)), // re-index the links array
        ]);

        return redirect('/admin/home')->with('success', 'Card updated!');
    }


    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        $card->delete();

        return redirect('/admin/home')->with('success', 'Card deleted!');
    }

}
