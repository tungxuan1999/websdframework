@extends('layouts.layout1')
    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <!-- <h1 class="h3 mb-2 text-gray-800">Orders</h1> -->
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body">
                    <p>Name: {{$profile->full_name}}</p>
                    <p>Address: {{$profile->address}}</p>
                    <p>Birthday: {{$profile->birthday}}</p>
                    <img height="100" src="{{$profile->avatar}}">
                </div>
            </div>
        </div>
    @endsection
