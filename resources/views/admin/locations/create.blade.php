@extends('layouts.admin')

@section('title', 'Add Location')

@section('content')
    <x-admin.page-header title="Add Location" description="Add a new Perth coaching location." />
    <x-admin.location-form :action="route('admin.locations.store')" />
@endsection
