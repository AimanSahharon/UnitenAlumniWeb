<?php

namespace App\Http\Controllers;
use App\Models\Card;
use Illuminate\Http\Request;

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
}
