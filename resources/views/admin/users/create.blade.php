@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <x-admin.page-header title="Add user" description="Create a new account for the admin panel." />
    <x-admin.user-form :action="route('admin.users.store')" />
@endsection
