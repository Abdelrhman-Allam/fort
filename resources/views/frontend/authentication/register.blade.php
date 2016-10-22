{{-- Master Layout --}}
@extends('rinvex/fort::frontend/common.layout')

{{-- Page Title --}}
@section('title')
    @parent
    » {{ trans('rinvex/fort::frontend/forms.register.heading') }}
@stop

{{-- Main Content --}}
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('rinvex/fort::frontend/forms.register.heading') }}</div>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'rinvex.fort.frontend.auth.register.post', 'class' => 'form-horizontal']) }}

                            @include('rinvex/fort::frontend/alerts.success')
                            @include('rinvex/fort::frontend/alerts.warning')
                            @include('rinvex/fort::frontend/alerts.error')

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                {{ Form::label('username', trans('rinvex/fort::frontend/forms.register.username'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.register.username'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::label('email', trans('rinvex/fort::frontend/forms.register.email'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.register.email'), 'required' => 'required']) }}

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {{ Form::label('password', trans('rinvex/fort::frontend/forms.register.password'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.register.password'), 'required' => 'required']) }}

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                {{ Form::label('password_confirmation', trans('rinvex/fort::frontend/forms.register.password_confirmation'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.register.password_confirmation'), 'required' => 'required']) }}

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::button(trans('rinvex/fort::frontend/forms.register.submit'), ['class' => 'btn btn-primary', 'type' => 'submit']) }}
                                    {{ Form::button(trans('rinvex/fort::frontend/forms.common.reset'), ['class' => 'btn btn-default']) }}
                                </div>
                            </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
