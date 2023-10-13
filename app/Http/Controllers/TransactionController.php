<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\OrderValidation;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('seller_id', auth()->user()->id)
                                ->where('status', 'ON_GOING')
                                ->get();

        return view('transaction.transactions', compact('transactions'),['active' => 'transactionPage']);
    }

    public function markAsDone($id)
    {
        $transaction = Transaction::findOrFail($id);
        $schedule = $transaction->schedule;

        $transaction->status = 'DONE';
        $schedule->delete();
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaction marked as done.');
    }

    public function history(){
        $transactions = Transaction::where('buyer_id', auth()->user()->id)
            ->get();
        $status = [""];
        for($i = 0; $i < Count($transactions) ; $i++) {
            if($transactions[$i]->status == "ON_GOING"){
                $status[$i] = 'On Going';
            }
            else if($transactions[$i]->status == "DONE"){
                $status[$i] = 'Done';
            }
        }
        return view('transaction.history', compact('transactions','status'),['active' => 'historyPage']);
    }

    public function foruser(){
        $transaction = OrderValidation::where('buyer_id', auth()->user()->id)->whereNotIn('status',['REQ','APV'])->get();
        $status = [""];
        for($i = 0; $i < Count($transaction) ; $i++) {
            if($transaction[$i]->status == "REQ"){
                $status[$i] = 'Waiting';
            }
            else if($transaction[$i]->status == "RJC"){
                $status[$i] = 'Rejected, Refund Done';
            }
            else if($transaction[$i]->status == "APV"){
                $status[$i] = 'Accepted';
            }
        }
        return view('transaction.transactionsforuser', [
            'title' => "User by category",
            'active' => 'category',
            'transactions' => $transaction,// Use the correct model name
            'status' => $status
        ]);
    }
}


