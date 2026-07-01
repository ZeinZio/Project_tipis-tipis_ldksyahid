@extends('landing-page.template.body')

@section('styles')
    <!-- React App Assets -->
    <script type="module" crossorigin src="{{ asset('cv-editor/assets/index-BMMBsRKP.js') }}"></script>
    <link rel="stylesheet" crossorigin href="{{ asset('cv-editor/assets/index-C4oflBDj.css') }}">
    
    <!-- Inject Laravel Data -->
    <script>
        window.CV_TEMPLATE_ID = "{{ $template_id }}";
        
        // Pass Laravel route URLs so React can use them
        window.CV_ROUTES = {
            changeTemplate: "{{ route('user.cv.index') }}",
            dashboard: "{{ route('user.dashboard') }}"
        };

        window.CV_USER_DATA = {
            name: "{{ $user->name ?? '' }}",
            email: "{{ $user->email ?? '' }}",
            phone: "{{ $profile->nohp ?? '' }}",
            address: "{{ $profile->alamat ?? '' }}",
            summary: "{{ $profile->tentangdiri ?? '' }}",
            qrCode: "data:image/svg+xml;base64,{!! $qrCode ?? '' !!}"
        };
    </script>
    <style>
        /* Custom wrapper to ensure React has enough height below the navbar */
        .cv-editor-wrapper {
            width: 100%;
            height: auto;
            min-height: calc(100vh - 80px); /* Adjust based on navbar height */
            padding-top: 80px; /* Offset for fixed navbar */
            overflow: visible;
        }
        #root {
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="cv-editor-wrapper">
        <div id="root"></div>
    </div>
@endsection
