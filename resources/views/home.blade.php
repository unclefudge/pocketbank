@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Kids Accounts --}}
        @if(Auth::user()->id < 3)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Account Balances</div>
                        <div class="panel-body">
                            @if(Auth::user()->id < 3)
                                @foreach ([3, 4, 5] as $id)
                                    <div class="row" style="line-height: 2">
                                        <div class="col-xs-4"><a href="{!! \App\User::find($id)->username !!}"><i class="fa fa-search" style="width: 30px"></i>{!! \App\User::find($id)->name !!}</a>
                                        </div>
                                        <div class="col-xs-4">{!! \App\User::find($id)->balance !!}</div>
                                        <div class="col-xs-4"><a href="/update/{{$id}}" class="btn btn-primary btn-xs">Update</a></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
