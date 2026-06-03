@extends('layouts.admin')

@section('title', 'Edit Location')

@section('content')
    <x-admin.page-header title="Edit Location" description="Update location details for the public website." />
    <x-admin.location-form :location="$location" :action="route('admin.locations.update', $location)" method="PUT" />
@endsection
