<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Repositories\UserRepository;

class NiftyWalletService
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * NiftyWalletService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getWallet(int $user_id)
    {
        $user = $this->userRepo->get($user_id);
        if ($user->wallet) {
            return $user->wallet;
        }
        return null;
    }

    public function storeTransaction(int $user_id, array $data)
    {
        $wallet = $this->getWallet($user_id);
        if (count($wallet->transactions) > 0) {
            $transactions = $wallet->transactions;
        } else {
            $transactions = [];
        }
        array_push($transactions, $data);
        if (intval($data['type']) == TransactionType::CREDIT) {
            $wallet->balance += $data['amount'];
        }
        if (intval($data['type']) == TransactionType::DEBIT) {
            $wallet->balance -= $data['amount'];
        }
        return true;
    }
}
