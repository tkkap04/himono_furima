<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'recommend'); 

        $items = collect();
        if ($tab === 'favorites' && Auth::check()) {
            $items = Auth::user()->favorites->map(function ($favorite) {
                return $favorite->item->load('images'); 
            });
        } elseif ($tab === 'recommend') {
            $search = $request->get('search');
            $items = Item::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%");
            })->with('images')->get();
        }

        return view('items.index', [
            'items' => $items,
            'activeTab' => $tab,
        ]);
    }


    public function show(Request $request, $id)
    {
        $item = Item::with(['images', 'category', 'condition'])->findOrFail($id);
        $isFavorited = Favorite::where('user_id', Auth::id())->where('item_id', $id)->exists();
        $isCommentPage = false;

        $fromMypage = $request->query('from') === 'mypage';

        $fromToppage = $request->query('from') === 'items.index';

        return view('items.show', compact('item', 'isFavorited', 'isCommentPage', 'fromMypage', 'fromToppage'));
    }

    public function commentsIndex($id)
    {
        $item = Item::with(['images', 'category', 'condition'])->findOrFail($id);
        $comments = $item->comments()->with('user')->get(); 
        $isFavorited = Favorite::where('user_id', Auth::id())->where('item_id', $id)->exists();
        $isCommentPage = true;

        return view('items.show', compact('item', 'comments', 'isFavorited', 'isCommentPage'));
    }

    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $conditions = Condition::all();

        return view('items.store', compact('categories', 'conditions'));
    }

    public function store(StoreRequest $request)
    {
        $item = new Item();
        $item->name = $request->name;
        $item->brand = $request->brand;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->condition_id = $request->condition_id;
        $item->seller_id = Auth::id();
        $item->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('public/images');

                \Log::info('Image uploaded: ' . $imagePath);

                $imageUrl = str_replace('public/', 'storage/', $imagePath);
                $item->images()->create([
                    'image_url' => $imageUrl,
                    'is_top' => $index === 0,
                ]);
            }
        } else {
            \Log::error('No images found in the request.');
        }

        return redirect()->route('items.store')->with('success', '商品を出品しました！');
    }
}
