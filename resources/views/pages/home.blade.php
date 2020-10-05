@extends('layouts.user')

@section('content')
    <div class="grid-container">
        <div class="grid-x grid-margin-x">

            <div class="cell">
                @if(count($resumes) == 0)
                    <h3>Welcome, you don't have any resumes yet.</h3>
                @else
                    <h3>Welcome back, choose a resume or create a new one.</h3>
                @endif
            </div>

            <div class="cell">
                <ul>
                    @foreach($resumes as $resume)
                        <li>
                            <a href="{{ route('resume-builder', ['resume' => $resume->id]) }}">{{ $resume->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>


            <div class="cell">
                @if(count($resumes) == 0)
                    <h3>Let's fix that!</h3>
                @endif
                <a href="{{ route('new-resume') }}" class="button">Build a new resume!</a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        //
    </script>
@endpush
