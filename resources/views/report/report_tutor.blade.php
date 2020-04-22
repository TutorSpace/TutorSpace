@extends('layouts.loggedin')
@section('title', 'report tutor')

@section('content')

<form class="container report-container black" action="/report/{{$reportee->id}}" method="POST">
    @csrf
    @if(!$from)
        <a class="btn btn-lg back-button" id="back-button" href="/home">
            <svg>
                <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
            </svg>
            Back to Home
        </a>
    @elseif($from == 'search')
        <a class="btn btn-lg back-button" id="back-button" href="/search?navInput=">
            <svg>
                <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
            </svg>
            Back to Search
        </a>
    @else
        <a class="btn btn-lg back-button" id="back-button" href="/{{$from}}">
            <svg>
                <use xlink:href="{{asset('assets/sprite.svg#icon-chevron-small-left')}}"></use>
            </svg>
            Back to {{ucwords($from)}}
        </a>
    @endif

    <h2 class="report-container__header">Report Tutor</h2>

    <p class="labels">Name</p>
    <h5>
        {{$reportee->full_name}}
    </h5>

    <p class="labels mb-2">Reason for Report</p>

    <div class="input-group">
        <select id="report-reason" class="report-reason__select custom-select" name="report-reason">
            <option disabled selected>Select Reason</option>
            <option value="1">Inappropiate Language</option>
            <option value="2">Inappropriate Physical Contact</option>
            <option value="3">Offensive Comments</option>
            <option value="4">Other</option>
        </select>
    </div>
    @error('report-reason')
        <p class="text-danger mt-1">Please select a report reason.</p>
    @enderror


    <p class="labels mb-2">Write Report</p>

    <textarea rows="6" class="form-control report-textarea"
        placeholder="Please be as specific as possible as to what is causing you to report this person." name="report-content">
        {{old('report-content') ?? ''}}
    </textarea>
    @error('report-content')
        <p class="text-danger mt-1">Please enter your report.</p>
    @enderror


    <div class="report-buttons">
        <button class="btn btn-lg btn-outline-primary" id="btn-reset" type="button">Reset</button>

        <button class="btn btn-lg btn-primary" type="submit" id="report-button">Report</button>
    </div>

</form>

@endsection

@section('js')

<!-- defined javascript -->
<script src="{{asset('js/report.js')}}"></script>


@endsection
