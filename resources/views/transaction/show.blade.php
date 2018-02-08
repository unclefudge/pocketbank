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
                                        <div class="col-xs-4"><b><a href="{!! \App\User::find($id)->username !!}">{!! \App\User::find($id)->name !!}</b></a>
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

        {{-- Transactions --}}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $user->name }}
                    <small class="pull-right">Balance: {!! $user->balance !!}</small>
                </h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row" style="font-size: 16px; font-weight: 800; color: #000;">
                            <div class="col-xs-3">Date</div>
                            <div class="col-xs-6">Description</div>
                            <div class="col-xs-3">Amount</div>
                        </div>

                        <hr style="margin: 2px">
                        <?php $show = 10; $count = 0; ?>
                        @foreach($user->trans->sortByDesc('created_at')->take($show) as $tran)
                            <div class="row">
                                <div class="col-xs-3">{{ $tran->created_at->format('M d') }}</div>
                                <div class="col-xs-6">{{ $tran->name }}</div>
                                <!--<div class="col-xs-3">{!! $tran->amount_format !!} <a href="/transaction/destroy/{{ $tran->id }}" class="pull-right"><i class="fa fa-trash" style="width: 30px"></i></a></div>-->
                                <div class="col-xs-3">{!! $tran->amount_format !!}
                                    @if(Auth::user()->id < 2)
                                        <a href="#" data-href="/delete/{{ $tran->id }}"
                                           data-date="{{ $tran->created_at->format('M d') }}"
                                           data-name="{{ $tran->name }}"
                                           data-amount="{{ $tran->amount_format }}"
                                           data-toggle="modal"
                                           data-target="#confirm-delete"
                                           class="pull-right"><i class="fa fa-trash" style="width: 30px"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if ($user->trans->count() > $show)
                            <button class="btn-primary" style="margin-top: 20px" id="more_but">Show All</button>
                        @endif
                        <div style="display:none" id="more_trans">
                            @foreach($user->trans->sortByDesc('created_at') as $tran)
                                <?php $count ++ ?>
                                @if ($count > $show)
                                    <div class="row">
                                        <div class="col-xs-3">{{ $tran->created_at->format('d/m/y') }}</div>
                                        <div class="col-xs-6">{{ $tran->name }}</div>
                                        <div class="col-xs-3">{!! $tran->amount_format !!} </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirm Delete Modal --}}
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete - {{ $user->name }}</h4>
                    </div>

                    <div class="modal-body">
                        <!--<p class="trans-details"></p>-->
                        <div class="form-group">
                            {!! Form::label('date', 'Date', ['class' => 'control-label']) !!}
                            {!! Form::text('date', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('amount', 'Amount', ['class' => 'control-label']) !!}
                            {!! Form::text('amount', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-del">Delete</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            // Show appropiate Subcontractor message
            $("#more_but").on("click", function () {
                $("#more_but").hide();
                $("#more_trans").show();
                //$("#subcontractor_sa").hide();
            });

            $('#confirm-delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-del').attr('href', $(e.relatedTarget).data('href'));

                $('#date').val($(e.relatedTarget).data('date'))
                $('#name').val($(e.relatedTarget).data('name'))
                $('#amount').val($(e.relatedTarget).data('amount'))
                var date = ($(e.relatedTarget).data('date'));
                var name = ($(e.relatedTarget).data('name'));
                var amount = ($(e.relatedTarget).data('amount'));
                $('.trans-details').html('<b>' + date + ' - ' + amount + ' : ' + name);
            });
        });
    </script>
@endsection
