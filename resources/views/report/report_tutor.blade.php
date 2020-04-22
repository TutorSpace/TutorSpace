@extends('layouts.loggedin')
@section('title', 'report tutor')

@section('content')

<form class="container report-container">
    <a type="button" class="btn btn-lg btn-outline-dark dark-button" id="back-button"
        href="/profile_student.html">Back to Student Profile</a>

    <h2 class="report-container__header">Report Tutor</h2>

    <p class="labels">Name</p>
    <p class="body-copy">
        <h5>Jamie Chang</h5>
    </p>

    <p class="labels">Reason for Report</p>

    <div class="input-group">
        <select id="report-reason" class="report-reason__select custom-select">
            <option value="select-reason">Select Reason</option>
            <option value="inappropiate-language">Inappropiate Language</option>
            <option value="saab">Inappropriate Physical Contact</option>
            <option value="mercedes">Offensive Comments</option>
            <option value="audi">Other</option>
        </select>
    </div>


    <p class="labels">Write Report</p>

    <textarea rows="6" class="form-control report-textarea"
        placeholder="Please be as specific as possible as to what is causing you to report this person."></textarea>


    <!-- button class should be changed to btn-blue for the dark blue color -->

    <div class="report-buttons">
        <a type="button" class="btn btn-lg btn-outline-primary" href="/profile_student.html">Cancel</a>

        <button type="button" class="btn btn-lg btn-primary" type="submit" id="report-button">Report</button>
    </div>

</form>

@endsection

@section('js')

<!-- defined javascript -->
<script src="{{asset('js/report.js')}}"></script>


@endsection
