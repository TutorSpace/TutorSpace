@extends('layouts.app')

@section('content')

<select class="js-example-responsive" style="width: 50%">

        <optgroup label="Group Name">
          <option>Nested option</option>
        </optgroup>
</select>


@endsection

@section('js')
<script>
    $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});
</script>
@endsection
