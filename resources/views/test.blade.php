@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="text-center"> Test</h1>
    <h4 class="text-center"> Test</h4>
    <p class="text-center fs-2-2">Test</p>
</div>
@endsection

@section('js')
<script>
    toastr.success('here');
</script>
@endsection
