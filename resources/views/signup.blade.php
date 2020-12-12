@extends('layouts.layout1')
@section('content')
<div class="signup">
    <h1>Sign Up</h1>
            <form>
                <p>User name</p>
                <input id='username' placeholder="Enter username" type="text">
                <p>Password</p>
                <input id='password' placeholder="Enter password" type="password">
                <p>Name</p>
                <input id='name' placeholder="Enter name" type="text">
                <p>Gender</p>
                <input id='gender' placeholder="Enter gender" type="text">
                <p>Sensor</p>
                <input id='sensor' placeholder="Enter sensor" type="text">
                <p>Status</p>
                <input id='status' placeholder="Enter status" type="text">
                <br>
                <button type="button" onclick='signup()'>Sign Up</button><br>
            </form>
</div>
@endsection
