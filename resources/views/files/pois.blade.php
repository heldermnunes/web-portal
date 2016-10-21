@extends('layouts.app')

@section('content')
    <div class="container content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading  form-title form-m-b-md">Upload a csv file:</div>
                        <div class="form">
                            {{ Form::open(array('url' => '/poi/uploadcsv', 'files' => true)) }}

                            <div class="form-file ">
                                {{ Form::file('file')}}
                                {{ Form::token()}}
                            </div>
                            <div class="form-button form-m-b-md">
                                {{ Form::submit('Upload')}}
                            </div>
                            {{ Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
