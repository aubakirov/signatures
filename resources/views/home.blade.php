@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                @if(auth()->check())
                    <Order :user="{{auth()->user()}}"></Order>
                @else
                    <div class="card mb-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Admin</h5>
                            <p>email: admin@gmail.com</p>
                            <p>pass: 1234567</p>
                        </div>
                    </div>

                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">User</h5>
                            <p>email: user@gmail.com</p>
                            <p>pass: 1234567</p>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
