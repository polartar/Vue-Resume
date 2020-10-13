@extends('layouts.user')

@section('content')
    <section class="page-section page-section-slim page-section-white">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">

                <div class="cell">
                    @if(count($resumes) == 0)
                        <h1 class="m-b-n">Welcome, You Don't Have Any Resumes Yet</h1>
                    @else
                        <h1 class="m-b-n">Welcome Back, Choose a Resume or Create a New One</h1>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="page-section page-section-light-gray">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                @foreach($resumes as $resume)
                    <div class="cell medium-6 large-4">
                        <div class="card">
                            <h3 class="card-heading">{{ $resume->name }}</h3>
                            <div class="card-conent">
                                Created on: {{ $resume->created_at->timezone('America/New_York')->format('F j, Y') }}
                            </div>
                            <div class="card-button">
                                <a href="{{ route('resume-builder', ['resume' => $resume->id]) }}" class="button">Edit Resume</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="page-section page-section-slim  page-section-secondary-blue">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell text-center">
                    <a href="{{ route('new-resume') }}" class="button button-no-margin">Build a new resume!</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        //
    </script>
@endpush
