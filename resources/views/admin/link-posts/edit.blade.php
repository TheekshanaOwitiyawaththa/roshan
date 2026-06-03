@extends('layouts.admin')

@section('title', 'Edit Life on the Links Image')

@section('content')
    <x-admin.page-header title="Edit gallery image" description="Update this Life on the Links gallery image." />
    <x-admin.link-post-form
        :link-post="$linkPost"
        :action="route('admin.link-posts.update', $linkPost)"
        method="PUT"
    />
@endsection
