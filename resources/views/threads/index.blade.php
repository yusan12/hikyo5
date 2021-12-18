@inject('message_service', 'App\Services\MessageService')
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('layouts.flash-message')
            {{ $threads->links() }}
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($threads as $thread)
            <div class="col-md-10 mb-5">
                <div class="card text-left">
                    <div class="card-header">
                        <h3><span class="badge badge-primary">{{ $thread->messages->count() }} <small>レス</small></span></h3>
                        <h3 class="m-0">{{ $thread->name }}</h3>
                    </div>
                    @foreach ($thread->messages as $message)
                    @if ($loop->index >= 5)
                        @continue
                    @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $loop->iteration }} 名前：{{ $message->user->name }}：{{ $message->created_at }}</h5>
                            <p class="card-text">{!! $message_service->convertUrl($message->body) !!}</p>
                        </div>
                    @endforeach
                    <div class="card-footer">
                        @include('components.message-create', compact('thread'))
                        <a href="{{ route('threads.show', $thread->id) }}">全部読む</a>
                        <a href="{{ route('threads.show', $thread->id) }}">最新50</a>
                        <a href="{{ route('threads.show', $thread->id) }}">1-100</a>
                        <a href="{{ route('threads.index') }}">リロード</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <h5 class="card-header">新規スレッド作成</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('threads.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="thread-title">スレッドタイトル</label>
                            <input name="name" type="text" class="form-control" id="thread-title"
                                placeholder="タイトル" required>
                        </div>
                        <div class="form-group">
                            <label for="thread-place">秘境住所</label>
                            <input name="place" type="text" class="form-control" id="thread-place"
                                placeholder="住所">
                        </div>
                        <div class="form-group">
                            <label for="thread-introduction">秘境紹介</label>
                            <input name="introduction" type="text" class="form-control" id="thread-introduction"
                                placeholder="紹介文">
                        </div>
                        <div class="form-group">
                            <label for="thread-time_from_tokyo">東京からのかかる時間</label>
                            <input name="time_from_tokyo" type="text" class="form-control" id="thread-time_from_tokyo"
                                placeholder="○時間△分">
                        </div>
                        <div class="form-group">
                            <label for="thread-how_much_from_tokyo">東京からのかかる費用</label>
                            <input name="how_much_from_tokyo" type="text" class="form-control" id="thread-how_much_from_tokyo"
                                placeholder="￥1,2345">
                        </div>
                        <div class="form-group">
                            <label for="thread-caution">注意点</label>
                            <input name="caution" type="text" class="form-control" id="thread-caution"
                                placeholder="列車を一本乗り過ごすと2時間待ち。注意！">
                        </div>
                        <div class="form-group">
                            <label for="thread-first-content">内容</label>
                            <textarea name="content" class="form-control" id="thread-first-content" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                                <label for="message-images">画像</label>
                                <input type="file" class="form-control-file" id="message-images" name="images[]" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">スレッド作成</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
