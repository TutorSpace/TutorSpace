@extends('layouts.app')
@section('title', 'Refund')

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

<h3 class="text-center">Refund</h3>
<main class="d-flex justify-content-center">
    <table class="table">
        <thead class="bg-primary">
          <tr>
            <th scope="col">Session ID</th>
            <th scope="col">Refund Status</th>
            <th scope="col" colspan="2">Student</th>
            <th scope="col">Refund Requested Time</th>
            <th scope="col">Refund Reason</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach (App\Transaction::where('refund_status', '!=', null)->get() as $transaction)
            <tr>
                <th scope="row">{{ $transaction->session_id }}</th>
                <td>{{ $transaction->refund_status }}</td>
                <td>
                    Student Name: {{ $transaction->session->student->first_name . $transaction->session->student->last_name }}
                </td>
                <td>
                    Student Id: {{ $transaction->session->student->id }}
                </td>
                <td>
                    {{ $transaction->refund_requested_time }}
                </td>
                <td>
                    <input type="text" class="form-control form-control-lg">
                </td>
                <td class="d-flex actions">
                    @if ($transaction->refund_status == 'user_initiated')
                    <form action="{{ route('payment.stripe.approve_refund', $transaction->session) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-lg">Approve</button>
                    </form>
                    <form action="{{ route('payment.stripe.decline_refund', $transaction->session) }}" method="POST" class="form-decline">
                        @csrf
                        <button class="btn btn-danger btn-lg mt-2">Decline</button>
                        <input type="hidden" name="refund-decline-reason">
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
$('.form-decline').submit(function() {
    let reason = $(this).parent().prev().find('input').val();
    $(this).find('input').val(reason);
    return true;
});
</script>
@endsection


