<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function home()
    {
        return view ('admin.home');
    }
    
    public function showList()
    {
        $users = User::paginate(10);
        return view('admin.email.list', compact('users'));
    }

    public function sendEmail(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $subject = session('mail_subject', 'お知らせ');
        $content = session('mail_content', 'これはテストメッセージです。');

        Mail::to($user->email)->send(new NotificationMail($subject, $content));

        return redirect()->route('admin.email.list')->with('success', 'メールが送信されました。');
    }

    public function sendEmailAll()
    {
        $users = User::all();

        $subject = session('mail_subject', 'お知らせ');
        $content = session('mail_content', 'これは一斉送信テストメッセージです。');

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($subject, $content));
        }

        return redirect()->route('admin.email.list')->with('success', 'すべてのユーザーにメールが送信されました。');
    }

    public function editEmail()
    {
        $emailSettings = [
            'subject' => session('mail_subject', 'お知らせ'),
            'content' => session('mail_content', 'これはテストメッセージです。')
        ];

        return view('admin.email.edit', compact('emailSettings'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        session([
            'mail_subject' => $request->input('subject'),
            'mail_content' => $request->input('content')
        ]);

        return redirect()->route('admin.home')->with('success', 'メール内容が更新されました。');
    }
}
