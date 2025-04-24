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
        return view('home');
        //the code below shows home page with cards added by the admin
        /*$cards = Card::latest()->get();
        return view('admin.home', compact('cards'));*/
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
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp'
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('uploads/cards', 'public');
            }
        }

        Card::create([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'images' => json_encode($imagePaths),
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
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp'
        ]);

        $card = Card::findOrFail($id);

        // Start with existing images
        $existingImages = json_decode($card->images, true) ?? [];

        // Handle image deletions BEFORE updating images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imagePath) {
                if (($key = array_search($imagePath, $existingImages)) !== false) {
                    unset($existingImages[$key]);
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $existingImages[] = $image->store('uploads/cards', 'public');
            }
        }

        // Update the card
        $card->update([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'images' => json_encode(array_values($existingImages)), // re-index
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
