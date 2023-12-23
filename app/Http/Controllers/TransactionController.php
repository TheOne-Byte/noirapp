<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\OrderValidation;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('seller_id', auth()->user()->id)
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

        return view('transaction.transactions', compact('transactions','status'),['active' => 'transactionPage']);
    }

    public function markAsDone($id)
    {
        $transaction = Transaction::findOrFail($id);
        $schedule = $transaction->schedule;
        $authUserId = auth()->user()->id;

    // Mendapatkan pengguna berdasarkan ID yang terautentikasi
        $user = User::where('id', $authUserId)->first();

        $user->points += $transaction->price;
        $user->save();
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
        return view('transaction.history', compact('transactions','status'),['active' => 'historyPage'],compact('transactions','transactions'));
    }

    public function foruser(){
        $transaction = OrderValidation::where('buyer_id', auth()->user()->id)->get();

        $status = [""];
        for($i = 0; $i < Count($transaction) ; $i++) {
            $seller = User::where('id',$transaction[$i]->seller_id)->first();
            if($transaction[$i]->status == "REQ"){
                $status[$i] = 'Waiting To Be Accepted By ' . $seller->username;
            }
            else if($transaction[$i]->status == "RJC"){
                $status[$i] = 'Rejected, Refund Done';
            }
            else if($transaction[$i]->status == "APV"){
                $status[$i] = 'Accepted By ' . $seller->username;
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


