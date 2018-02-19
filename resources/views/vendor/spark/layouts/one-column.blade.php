@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="card card-default">
        <div class="card-body">
            @yield('form')
            {{-- {{__('Your application\'s dashboard.')}} --}}
        </div>
    </div>

    {{-- <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-8">

            </div>
        </div>
    </div> --}}
</home>
@endsection
