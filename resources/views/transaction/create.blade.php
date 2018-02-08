@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Update --}}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $user->name }} <small class="pull-right">Balance: {!! $user->balance !!}</small></h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action="/transaction">
                            {{ csrf_field() }}

                            {!! Form::hidden('user_id', $user->id) !!}

                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <i class="fa fa-warning"></i><strong> Error(s) have occured</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group {!! fieldHasError('name', $errors) !!}">
                                {!! Form::label('name', 'Description', ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                {!! fieldErrorMessage('name', $errors) !!}
                            </div>

                            <div class="form-group {!! fieldHasError('amount', $errors) !!}">
                                {!! Form::label('amount', 'Amount', ['class' => 'control-label']) !!}
                                {!! Form::text('amount', null, ['class' => 'form-control']) !!}
                                {!! fieldErrorMessage('amount', $errors) !!}
                            </div>

                            <a href="{!! URL::previous() !!}" class="btn btn-default"> Cancel</a>
                            <button type="submit" class="btn btn-primary" name="deposit">Deposit</button>
                            <button type="submit" class="btn btn-danger" name="expense">Expense</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
