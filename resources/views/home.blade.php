@extends('layouts.golf')

@section('content')
    <x-golf.navigation />

    <main>
        <x-golf.hero />
        <x-golf.about />
        <x-golf.why-choose />
        <x-golf.services :coaching-programs="$coachingPrograms" />
        <x-golf.testimonials />
        <x-golf.instagram :link-posts="$linkPosts" />
        <x-golf.locations :locations="$locations" />
        <x-golf.booking :coaching-programs="$coachingPrograms" :locations="$locations" />
    </main>

    <x-golf.footer />

    <x-golf.booking-modal :coaching-programs="$coachingPrograms" :locations="$locations" />
@endsection
