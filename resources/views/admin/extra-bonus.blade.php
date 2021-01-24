@extends('layouts.app')
@section('title', 'Extra Bonus')

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

<h3 class="text-center">Extra Bonus</h3>
<main class="d-flex justify-content-center">
    <table class="table">
        <thead class="bg-primary">
          <tr>
            <th scope="col">Transaction Id</th>
            <th scope="col">Tutor</th>
            <th scope="col">Transaction Time</th>
            <th scope="col">Extra Bonus to Send</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach (App\Transaction::where('extra_bonus_amount', '>', 0)->get() as $transaction)
            <tr>
                <th scope="row" style="width: 10rem">{{ $transaction->id }}</th>
                <td style="width: 15rem">
                        {{ $transaction->session->tutor->first_name . ' ' . $transaction->session->tutor->last_name }}
                </td>
                <td>
                    {{ $transaction->created_at->setTimeZone($tz) }}
                </td>
                <td>
                    $ {{ $transaction->extra_bonus_amount/100 }}
                </td>
                <td>
                    {{ $transaction->extra_bonus_sent ? 'Sent' : 'Unsent' }}
                </td>
                <td style="width: 40rem;">
                    @if (!$transaction->extra_bonus_sent)
                    <form action="{{ route('admin.extra-bonus-sent', $transaction) }}" method="POST" style="width: 100%">
                        @csrf
                        <button class="mt-3 btn btn-primary btn-lg fs-1-6" style="width: 100%">Update Extra Bonus Sent Status</button>
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


