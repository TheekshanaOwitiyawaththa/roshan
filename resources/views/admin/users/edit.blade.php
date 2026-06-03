@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <x-admin.page-header title="Edit user" description="Update account details and admin access." />
    <x-admin.user-form
        :user="$user"
        :action="route('admin.users.update', $user)"
        method="PUT"
    />
@endsection
