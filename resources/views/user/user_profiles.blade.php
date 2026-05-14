@extends('layouts.mainlayout')

@section('title', 'Users : Users Post')

@section('content')
@foreach ($posts as $post)
    <p>{{ $post->user->username }} , {{ $post->user->email }} , {{ $post->user->profile->bio ?? 'No bio' }}</p>
    <p>{{ $post->user->username }} , {{ $post->title }} , {{ $post->content }}</p>
@endforeach