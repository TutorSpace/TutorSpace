@extends('layouts.app')
@section('title', 'Tutor Verification')

@section('links-in-head')
<style>
    h3 {
        margin-top: 12rem;
    }
    main {
        margin-top: 3rem;
        font-size: 16px;
    }
    table {
        max-width: 90vw;
    }

    th {
        text-align: center !important;
    }

    td {
        text-align: center
    }

    thead {
        color: white;
    }

    form {
        width: 8rem;
    }

    .actions {
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    button {
        width: 8rem;
    }
</style>
@endsection

@section('body-class')

bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('content')

@include('partials.nav')

@php
$tz = App\CustomClass\TimeFormatter::getTZ();
@endphp

<h3 class="text-center">Tutor Verification</h3>
<main class="d-flex justify-content-center">
    <table class="table">
        <thead class="bg-primary">
          <tr>
            <th scope="col">Tutor Verification Id</th>
            <th scope="col">Tutor</th>
            <th scope="col">Requested Time</th>
            <th scope="col">Verified Courses</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach (Illuminate\Support\Facades\DB::table('notifications')->where('type', 'App\Notifications\TutorVerificationInitiatedNotification')->get() as $notif)
            <tr>
                <th scope="row" style="width: 10rem">{{ $notif->id }}</th>
                <td style="width: 15rem">
                    <div>
                        {{ App\User::find($notif->notifiable_id)->first_name . ' ' . App\User::find($notif->notifiable_id)->last_name }}
                    </div>
                    <div>
                        {{ $notif->notifiable_id }}
                    </div>

                </td>
                <td>
                    {{ Carbon\Carbon::parse($notif->created_at)->setTimeZone($tz) }}
                </td>
                <td>
                    @foreach (App\User::find($notif->notifiable_id)->verifiedCourses as $course)
                        {{ $course->course }},
                    @endforeach
                </td>
                <td>
                    <form action="{{ route('admin.course.post', App\User::find($notif->notifiable_id)) }}" method="POST" style="width: 100%">
                        @csrf
                        <input type="text" placeholder="course name" class="form-control form-control-lg course fs-1-6" name="course">
                    </form>
                    @if (App\User::find($notif->notifiable_id)->notifications()->where('type', 'App\Notifications\TutorVerificationCompleted')->doesntExist())
                    <form action="{{ route('admin.tutor-verification.completed', $notif->notifiable_id) }}" style="width: 100%;" method="POST">
                        @csrf
                        <button class="mt-3 btn btn-primary btn-lg fs-1-6" style="width: 100%">Send Verified Success Notifi</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
</main>

@endsection



@section('js')
<script>

</script>
@endsection


