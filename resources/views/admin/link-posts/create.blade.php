@extends('layouts.admin')

@section('title', 'Add Life on the Links Image')

@section('content')
    <x-admin.page-header title="Add gallery image" description="Add a new image to the Life on the Links section." />
    <x-admin.link-post-form :action="route('admin.link-posts.store')" />
@endsection
