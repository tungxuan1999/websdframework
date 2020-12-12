@extends('layouts.layout1')
@section('content')
  <div class="login">
  <h1>Login</h1>
    <form>
        <p>User name</p>
        <input id='username' placeholder="Enter username" type="text">
        <p>Password</p>
        <input id='password' placeholder="Enter password" type="password">
        <br>
        <button type="button" onclick='login()'>Login</button><br>
    </form>

  </div>

  <div class="status">
  <h1>Status</h1>
    <form>
        <button type="button" onclick="getstatus()">Status</button>
        <table id="status" border="1" ></table>
    </form>

  </div>

<div id="status"></div>

@endsection
