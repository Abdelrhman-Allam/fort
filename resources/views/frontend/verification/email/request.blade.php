@extends('rinvex/fort::frontend.common.layout')

{{-- Main Content --}}
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('rinvex/fort::frontend/forms.verification.email.heading') }}</div>

                    <div class="panel-body">
                        {{ Form::open(['route' => 'rinvex.fort.frontend.verification.email.send', 'class' => 'form-horizontal']) }}

                            @include('rinvex/fort::frontend.alerts.success')
                            @include('rinvex/fort::frontend.alerts.warning')
                            @include('rinvex/fort::frontend.alerts.error')

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::label('email', trans('rinvex/fort::frontend/forms.verification.email.field'), ['class' => 'col-md-4 control-label']) }}

                                <div class="col-md-6">
                                    {{ Form::email('email', old('email', auth()->guest() ? '' : $currentUser->email), ['class' => 'form-control', 'placeholder' => trans('rinvex/fort::frontend/forms.verification.email.field'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    {{ Form::button('<i class="fa fa-envelope"></i> '.trans('rinvex/fort::frontend/forms.verification.email.submit'), ['class' => 'btn btn-primary', 'type' => 'submit']) }}
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
