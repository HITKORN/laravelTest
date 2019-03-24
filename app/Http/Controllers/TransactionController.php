<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Rules\ValidCard;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
	public function __construct(User $user, Transaction $transaction){
        $this->user = $user;
        $this->transaction = $transaction;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function convert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userCard' => ['required', 'digits:20', new ValidCard],
            'points'   => 'required|integer'
        ]);
        $cardUser = $this->user->where('cardNumber', '=', $request->userCard)->first();

        if (isset($cardUser)) {
            if ($cardUser->balance < $request->points) {
                $validator->errors()->add('field', 'Not enough points!');
            }
        } else {
            $validator->errors()->add('field', 'User with this card does not exist');
        }
        if (isset($cardUser)) {
            $date = Carbon::now();
            //в схеме таблицы нет поля для идентифкатора. Просто генерирую иникальное значение для передачи в ответ.
            $uniqid = uniqid();
            $this->transaction->insert([
                'user_id' => $cardUser->id,
                'operation_type' => $request->command,
                'points_number' => (int)$request->points,
                'operation_date' => $date,
                'operation_description' => $validator->errors()->all() != null ? implode(',', $validator->errors()->all()) : 'success',
            ]);
        }

        if ($validator->errors()->all()) {
            $data = [
                'status' => 'fail',
                'error' => implode(',', $validator->errors()->all())
            ];
            return response()->xml($data, $status = 400);
        }

        $data = [
            'status'        => 'success',
            'transactionId' => $uniqid,
            'cardNumber'    => $request->userCard,
            'Points'        => $request->points,
            'timestamp'     => $date,
        ];

        return response()->xml($data, $status = 200);
    }
}
