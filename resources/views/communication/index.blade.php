@extends('layouts.app')

@section('content')
    <h1>Notif & Komunikasi</h1>
    <p>{{ $unreadCount }} pesan belum dibaca. Notifikasi stok minimum dibuat otomatis oleh queue worker.</p>

    <div class="grid two">
        <section class="panel">
            <h2>Kirim Pesan</h2>
            <form method="post" action="{{ route('communication.store') }}">
                @csrf
                <label>Tipe
                    <select name="type" required>
                        <option value="pesan">Pesan</option>
                        <option value="notifikasi">Notifikasi</option>
                    </select>
                </label>
                <label>Judul <input name="title" required></label>
                <label>Pengirim <input name="sender" value="Admin Gudang" required></label>
                <label>Penerima <input name="recipient" value="Tim Operasional" required></label>
                <label>Isi <textarea name="body" required></textarea></label>
                <button type="submit">Kirim</button>
            </form>
        </section>

        <section>
            <h2>Inbox</h2>
            <div class="list">
                @forelse ($messages as $message)
                    <article class="message {{ $message->is_read ? '' : 'unread' }}">
                        <div class="actions" style="justify-content:space-between">
                            <span class="badge">{{ ucfirst($message->type) }}</span>
                            <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <h2 style="margin-top:10px">{{ $message->title }}</h2>
                        <p>{{ $message->body }}</p>
                        <p>Dari {{ $message->sender }} untuk {{ $message->recipient }}</p>
                        @unless ($message->is_read)
                            <form method="post" action="{{ route('communication.read', $message) }}" class="no-print">
                                @csrf
                                <button class="secondary" type="submit">Tandai Dibaca</button>
                            </form>
                        @endunless
                    </article>
                @empty
                    <div class="message">Belum ada pesan.</div>
                @endforelse
            </div>
            <div class="pagination">{{ $messages->links() }}</div>
        </section>
    </div>
@endsection

