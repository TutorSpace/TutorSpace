@if (Auth::check()) 

<h1>profile student</h1>
<h2>Loged In</h2>

@else
    <h1>profile student</h1>
    <h2>Not Loged In</h2>
@endif