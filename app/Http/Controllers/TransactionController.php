<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List Transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction/list');
    }

    /**
     * Create Transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = User::find($id);

        return view('transaction/create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'name'   => 'required',
            'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);

        $fields = request()->all();
        if (preg_match('/\.[0-9]$/', request('amount')))
            $fields['amount'] = preg_replace('/\./', '', request('amount')) . '0';
        elseif (preg_match('/\.[0-9][0-9]$/', request('amount')))
            $fields['amount'] = preg_replace('/\./', '', request('amount'));
        else
            $fields['amount'] = request('amount') . '00';

        $fields['created_by'] = Auth::user()->id;
        //dd($fields);
        $trans = Transaction::create($fields);

        $user = User::find(request('user_id'));

        return redirect($user->username);
    }

    /**
     * Destroy a resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trans = Transaction::find($id);
        $user = User::find($trans->user_id);
        $trans->delete();

        return redirect($user->username);
    }

    /**
     * Show the transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function lily()
    {
        $user = User::find(3);

        return view('transaction/show', compact('user'));
    }

    /**
     * Show the transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function jesse()
    {
        $user = User::find(4);

        return view('transaction/show', compact('user'));
    }

    /**
     * Show the transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function daisy()
    {
        $user = User::find(5);

        return view('transaction/show', compact('user'));
    }

    /**
     * Show the transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //return view('transaction/list');
    }
}
