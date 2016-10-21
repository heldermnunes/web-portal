@extends('layouts.app')

@section('content')
    <div class="container content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading form-title form-m-b-md">Poi manager</div>

                        <div class="links form-m-b-md">
                            <a href="{{ url('/poi/addpoi') }}">
                                upload CSV
                            </a>
                            <a href="#">fill form</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection