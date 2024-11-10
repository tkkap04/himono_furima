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
        $tab = $request->query('tab', 'recommend');

        $search = $request->get('search');
        
        if ($tab === 'favorites') {
        $items = Auth::user()->favorites->map(function ($favorite) {
            return $favorite->item;
        });
        } else {
            $items = Item::when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%");
            })->get();
        }

        $searchParams = [
            'search' => $search
        ];

        return view('items.index', compact('items', 'searchParams', 'tab'));
    }

    public function show($id)
    {
        $item = Item::with(['category', 'condition'])->findOrFail($id);
        $isFavorited = Favorite::where('user_id', Auth::id())->where('item_id', $id)->exists();
        $isCommentPage = false;

        return view('items.show', compact('item', 'isFavorited', 'isCommentPage'));
    }

    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $conditions = Condition::all();

        return view('items.store', compact('categories', 'conditions'));
    }

    // 商品保存処理
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
                $imageUrl = Storage::url($imagePath);

                $item->images()->create([
                    'image_url' => $imageUrl,
                    'is_top' => $index === 0,
                ]);
            }
        }

        return redirect()->route('items.store')->with('success', '商品を出品しました！');
    }
}
