@extends('layouts.app')
@section('title', 'Referral Bonus')

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

<h3 class="text-center">Referral Bonus</h3>
<main class="d-flex justify-content-center">
    <table class="table">
        <thead class="bg-primary">
          <tr>
            <th scope="col">Email</th>
            <th scope="col">Referral Success Time</th>
            <th scope="col">Referral Bonus to Send</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach (App\ReferralClaimedUser::all() as $referralClaimedUser)
            <tr>
                <td>
                    {{ $referralClaimedUser->email }}
                </td>
                <td>
                    {{ $referralClaimedUser->created_at->setTimeZone($tz) }}
                </td>
                <td>
                    $ {{ $referralClaimedUser->bonus_amount_dollar }}
                </td>
                <td>
                    {{ $referralClaimedUser->money_sent ? 'Sent' : 'Unsent' }}
                </td>
                <td style="width: 40rem;">
                    @if (!$referralClaimedUser->money_sent)
                    <form action="{{ route('admin.referral-bonus-sent', $referralClaimedUser) }}" method="POST" style="width: 100%">
                        @csrf
                        <button class="mt-3 btn btn-primary btn-lg fs-1-6" style="width: 100%">Update Referral Bonus Sent Status</button>
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


