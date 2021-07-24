@extends('layouts.app')

@section('content')
<form action="menu_save" method="post">
    {{ csrf_field() }}
    <input type='text' name="menu_name">
    <input type='text' name="price">
    <select name='status'>
        <option value="A">Active</option>
        <option value="N">Disable</option>

    </select>
    <input type="submit">
</form>

@endsection