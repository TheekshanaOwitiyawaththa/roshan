@extends('layouts.admin')

@section('title', 'Edit Coaching Program')

@section('content')
    <x-admin.page-header title="Edit Coaching Program" description="Update program details shown on the website." />
    <x-admin.coaching-program-form :program="$program" :action="route('admin.coaching-programs.update', $program)" method="PUT" />
@endsection
