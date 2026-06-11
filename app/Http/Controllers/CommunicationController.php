<?php

namespace App\Http\Controllers;

use App\Models\CommunicationMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunicationController extends Controller
{
    public function index(): View
    {
        return view('communication.index', [
            'messages' => CommunicationMessage::query()->latest()->paginate(12),
            'unreadCount' => CommunicationMessage::where('is_read', false)->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:pesan,notifikasi'],
            'title' => ['required', 'string', 'max:160'],
            'body' => ['required', 'string', 'max:2000'],
            'sender' => ['required', 'string', 'max:120'],
            'recipient' => ['required', 'string', 'max:120'],
        ]);

        CommunicationMessage::create($data);

        return back()->with('status', 'Pesan berhasil dikirim.');
    }

    public function markRead(CommunicationMessage $message): RedirectResponse
    {
        $message->update(['is_read' => true]);

        return back()->with('status', 'Pesan ditandai sudah dibaca.');
    }
}

