@extends('layouts.app')

{{-- Main Content --}}

@section('content')

    <style>
        td {
            vertical-align: middle !important;
        }
    </style>

    <div class="container">

        @include('rinvex.fort::frontend.alerts.success')
        @include('rinvex.fort::frontend.alerts.warning')
        @include('rinvex.fort::frontend.alerts.error')

        <div class="panel panel-default">

            {{-- Heading --}}
            <div class="panel-heading">
                <h4>
                    {{ trans('rinvex.fort::backend/abilities.heading') }}
                    <span class="pull-right" style="margin-top: -7px">
                        <a href="{{ route('rinvex.fort.backend.abilities.create') }}" class="btn btn-default"><i class="fa fa-plus"></i></a>
                    </span>
                </h4>
            </div>

            {{-- Data --}}
            <div class="panel-body">

                <div class="table-responsive">

                    <table class="table table-hover" style="margin-bottom: 0">

                        <thead>
                            <tr>
                                <th style="width: 30%">{{ trans('rinvex.fort::backend/abilities.title') }}</th>
                                <th style="width: 40%">{{ trans('rinvex.fort::backend/abilities.description') }}</th>
                                <th style="width: 20%">{{ trans('rinvex.fort::backend/abilities.dates') }}</th>
                                <th style="width: 10%" class="text-right">{{ trans('rinvex.fort::backend/abilities.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($abilities as $ability)

                                <tr>
                                    <td>
                                        <a href="{{ route('rinvex.fort.backend.abilities.show', ['ability' => $ability->id]) }}">
                                            <strong>{{ $ability->title }}</strong> <small>({{ $ability->action }})</small>
                                            <div class="small ">{{ $ability->policy }}</div>
                                        </a>
                                    </td>

                                    <td>
                                        {{ $ability->description }}
                                    </td>

                                    <td class="small">
                                        @if($ability->created_at)
                                            <div>{{ trans('rinvex.fort::backend/abilities.created') }}:
                                                <time datetime="{{ $ability->created_at }}">{{ $ability->created_at->format('Y-m-d') }}</time>
                                            </div>
                                        @endif
                                        @if($ability->updated_at)
                                            <div>{{ trans('rinvex.fort::backend/abilities.updated') }}:
                                                <time datetime="{{ $ability->updated_at }}">{{ $ability->updated_at->format('Y-m-d') }}</time>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <a href="{{ route('rinvex.fort.backend.abilities.edit', ['ability' => $ability->id]) }}" class="btn btn-xs btn-default" title="{{ trans('rinvex.fort::backend/abilities.edit', ['ability' => $ability->action]) }}"><i class="fa fa-pencil text-primary"></i></a>
                                        <a href="{{ route('rinvex.fort.backend.abilities.delete', ['ability' => $ability->id]) }}" class="btn btn-xs btn-default" title="{{ trans('rinvex.fort::backend/abilities.delete', ['ability' => $ability->action]) }}" onclick="event.preventDefault(); document.getElementById('ability-delete-form-{{ $ability->id }}').submit();"><i class="fa fa-trash-o text-danger"></i></a>
                                        <form id="ability-delete-form-{{ $ability->id }}" action="{{ route('rinvex.fort.backend.abilities.delete', ['ability' => $ability->id]) }}" method="POST" style="display: none;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination --}}
            @include('rinvex.fort::backend.abilities.pagination', ['resource' => $abilities])

        </div>

    </div>

@endsection
