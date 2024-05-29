<?php

namespace App\Livewire\Payment;

use App\Models\bonuses;
use App\Models\discounts;
use App\Models\employees;
use App\Models\payment_methods;
use App\Models\payments;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Payment extends Component
{
    use WithPagination;
    use WithFileUploads;


    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    public $openCreate = false;
    public $paymentCreate = [
        'amount' => "",
        'final_amount' => "",
        'payment_type' => "",
        'employee_id' => "",
        'payment_method_id' => "",
        'user_id ' => ""
    ];

    public $employees;
    public $payment_methods;

    public $paymentIDDiscount;
    public $openDiscount = false;
    public $discountCreate = [
        'amount' => "",
        'discount_type' => "",
        'payment_id' => "",
        'user_id' => ""
    ];

    public $paymentIDBond;
    public $openBond = false;
    public $bondCreate = [
        'amount' => "",
        'description' => "",
        'payment_id' => "",
        'user_id' => ""
    ];


    public function mount()
    {
        $this->employees = employees::all();
        $this->payment_methods = payment_methods::all();
    }
    public function render()
    {
        $payments = payments::join('employees', 'employees.id', '=', 'payments.employee_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'payments.payment_method_id')
            ->where(function ($query) {
                $query->where('employees.full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('employees.document_number', 'like', '%' . $this->search . '%');
            })
            ->where(function ($querys) {
                $querys->where('employees.state', '=', 'A')
                    ->orWhere('employees.state', '=', 'I');
            })
            ->orderBy($this->sort, $this->direction)
            ->select('payments.*', 'employees.full_name as full_name', 'employees.document_number as document_number', 'employees.state as state', 'payment_methods.payment_method as payment_method')
            ->paginate(10, pageName: 'pagePayments');

        return view('livewire.payment.payment', compact('payments'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
                $this->render();
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function save()
    {
        $user = Auth::user();
        $payments = payments::create([
            'amount' => $this->paymentCreate['amount'],
            'final_amount' => $this->paymentCreate['amount'],
            'payment_type' => $this->paymentCreate['payment_type'],
            'employee_id' => $this->paymentCreate['employee_id'],
            'payment_method_id' => $this->paymentCreate['payment_method_id'],
            'user_id' => $user->id
        ]);
        $this->resetPage(pageName: 'pagePayments');
        $this->openCreate = false;
        $this->reset(['paymentCreate', 'openCreate']);
    }

    public function openModalDiscount($paymentId)
    {
        $this->paymentIDDiscount = $paymentId;
        $this->openDiscount = true;
    }

    public function saveDiscount()
    {
        $user = Auth::user();
        $discount = discounts::create([
            'amount' => $this->discountCreate['amount'],
            'discount_type' => $this->discountCreate['discount_type'],
            'payment_id' => $this->paymentIDDiscount,
            'user_id' => $user->id
        ]);

        $payment = Payments::find($this->paymentIDDiscount);
        if ($payment) {
            $payment->final_amount -= $this->discountCreate['amount'];
            $payment->save();
        }

        $this->resetPage(pageName: 'pagePayments');
        $this->openDiscount = false;
        $this->reset(['discountCreate', 'openDiscount', 'paymentIDDiscount']);
    }

    public function openModalBond($paymentId)
    {
        $this->paymentIDBond = $paymentId;
        $this->openBond = true;
    }

    public function saveBond()
    {
        $user = Auth::user();
        $bond = bonuses::create([
            'amount' => $this->bondCreate['amount'],
            'description' => $this->bondCreate['description'],
            'payment_id' => $this->paymentIDBond,
            'user_id' => $user->id
        ]);

        $payment = Payments::find($this->paymentIDBond);
        if ($payment) {
            $payment->final_amount += $this->bondCreate['amount'];
            $payment->save();
        }

        $this->resetPage(pageName: 'pagePayments');
        $this->openBond = false;
        $this->reset(['bondCreate', 'openBond', 'paymentIDBond']);
    }
}
