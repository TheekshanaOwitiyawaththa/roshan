@extends('layouts.admin')

@section('title', 'Add Coaching Program')

@section('content')
    <x-admin.page-header title="Add Coaching Program" description="Create a new tailored coaching program for the public website." />
    <x-admin.coaching-program-form :action="route('admin.coaching-programs.store')" />
@endsection
