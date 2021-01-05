@extends('layouts.app')
@section('title', 'Refund')

@section('links-in-head')
<style>
    main {
        margin-top: 15rem;
        font-size: 16px;
    }
    table {
        max-width: 80vw;
    }

    th {
        text-align: center !important;
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
index
@endsection

@section('content')

@include('partials.nav')

<main class="d-flex justify-content-center">
    <table class="table">
        <thead class="bg-primary">
          <tr>
            <th scope="col">Session ID</th>
            <th scope="col">Refund Status</th>
            <th scope="col">Refund Requested Time</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach (App\Transaction::where('refund_status', '!=', null)->get() as $transaction)
            <tr>
                <th scope="row">{{ $transaction->session_id }}</th>
                <td>{{ $transaction->refund_status }}</td>
                <td>
                    {{ $transaction->refund_requested_time }}
                </td>
                <td class="d-flex actions">
                    <form action="{{ route('payment.stripe.approve_refund', $transaction->session) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-lg">Approve</button>
                    </form>
                    <form action="" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-lg mt-2">Decline</button>
                    </form>
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


