<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($id)
    {
        $item = Item::with(['category', 'condition'])->findOrFail($id);
        $isFavorited = $item->favorites()->where('user_id', Auth::id())->exists();
        $isCommentPage = true;
        $comments = Comment::where('item_id', $id)->orderBy('created_at', 'asc')->get();

        return view('items.show', compact('item', 'isFavorited', 'isCommentPage', 'comments'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $id,
            'content' => $request->comment
        ]);

        return redirect()->route('comments.index', ['id' => $id])->with('success', 'コメントを投稿しました。');
    }
}