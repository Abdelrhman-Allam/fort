{{-- Master Layout --}}
@extends('rinvex/fort::frontend/common.layout')

{{-- Page Title --}}
@section('title')
    @parent
    » {{ trans('rinvex/fort::frontend/forms.login.heading') }}
@stop

{{-- Main Content --}}
@section('content')

    <style>
        .btn span.fa-check {
            opacity: 0;
        }
        .btn.active span.fa-check {
            opacity: 1;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <section class="panel panel-default">
                    <header class="panel-heading">{{ trans('rinvex/fort::frontend/forms.login.heading') }}</header>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'rinvex.fort.frontend.auth.login.process', 'class' => 'form-horizontal']) }}

                            @include('rinvex/fort::frontend/alerts.success')
                            @include('rinvex/fort::frontend/alerts.warning')
                            @include('rinvex/fort::frontend/alerts.error')

                            <div class="form-group{{ $errors->has('loginfield') ? ' has-error' : '' }}">
                                {{ Form::label('loginfield', trans('rinvex/fort::frontend/forms.login.loginfield'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::text('loginfield', old('loginfield'), ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.login.loginfield'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('loginfield'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('loginfield') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {{ Form::label('password', trans('rinvex/fort::frontend/forms.login.password'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.login.password'), 'required' => 'required']) }}

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">

                                    <div class="btn-group" data-toggle="buttons">

                                        <label for="remember" class="btn btn-default">
                                            <span class="fa fa-check"></span>
                                            <input id="remember" name="remember" type="checkbox" autocomplete="off" value="1" @if(old('remember')) checked @endif> {{ trans('rinvex/fort::frontend/forms.login.remember') }}
                                        </label>

                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::button('<i class="fa fa-sign-in"></i> '.trans('rinvex/fort::frontend/forms.login.submit'), ['class' => 'btn btn-primary', 'type' => 'submit']) }}
                                    {{ Form::button(trans('rinvex/fort::frontend/forms.login.forgot_password'), ['class' => 'btn btn-link']) }}
                                </div>
                            </div>

                        {{ Form::close() }}
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
