<?php

namespace App\Service;

class HomePageService
{
    private array $users = [
        [
            'email' => 'user1@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'roles' => '["ROLE_USER"]',
            'name' => 'John Doe',
            'avatar' => 'avatar1.jpg',
            'created_at' => '2023-01-01 10:00:00',
            'updated_at' => '2023-01-01 10:00:00'
        ],
        [
            'email' => 'user2@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'roles' => '["ROLE_USER"]',
            'name' => 'Jane Smith',
            'avatar' => 'avatar2.jpg',
            'created_at' => '2023-01-02 11:00:00',
            'updated_at' => '2023-01-02 11:00:00'
        ]
    ];

    private array $categories = [
        [
            'name' => 'Salary',
            'type' => 'income',
            'user_id' => 1,
            'created_at' => '2023-01-01 10:05:00',
            'updated_at' => '2023-01-01 10:05:00'
        ],
        [
            'name' => 'Freelance',
            'type' => 'income',
            'user_id' => 1,
            'created_at' => '2023-01-01 10:10:00',
            'updated_at' => '2023-01-01 10:10:00'
        ],
        [
            'name' => 'Food',
            'type' => 'expense',
            'user_id' => 1,
            'created_at' => '2023-01-01 10:15:00',
            'updated_at' => '2023-01-01 10:15:00'
        ],
        [
            'name' => 'Transport',
            'type' => 'expense',
            'user_id' => 2,
            'created_at' => '2023-01-02 11:05:00',
            'updated_at' => '2023-01-02 11:05:00'
        ]
    ];

    private array $transactions = [
        [
            'amount' => 1500.00,
            'type' => 'income',
            'description' => 'Monthly salary',
            'date' => '2023-01-05 00:00:00',
            'category_id' => 1,
            'user_id' => 1,
            'created_at' => '2025-07-05 09:00:00',
            'updated_at' => '2025-07-05 09:00:00'
        ],
        [
            'amount' => 500.00,
            'type' => 'income',
            'description' => 'Freelance project',
            'date' => '2023-01-10 00:00:00',
            'category_id' => 2,
            'user_id' => 1,
            'created_at' => '2025-07-10 12:00:00',
            'updated_at' => '2025-07-10 12:00:00'
        ],
        [
            'amount' => 25.50,
            'type' => 'expense',
            'description' => 'Groceries',
            'date' => '2025-07-15 00:00:00',
            'category_id' => 3,
            'user_id' => 1,
            'created_at' => '2025-07-15 18:00:00',
            'updated_at' => '2025-07-15 18:00:00'
        ],
        [
            'amount' => 10.00,
            'type' => 'expense',
            'description' => 'Taxi',
            'date' => '2023-01-20 00:00:00',
            'category_id' => 4,
            'user_id' => 2,
            'created_at' => '2025-07-20 19:00:00',
            'updated_at' => '2025-07-20 19:00:00'
        ]
    ];

    private array $goals = [
        [
            'name' => 'New Laptop',
            'target_amount' => 1200.00,
            'current_amount' => 300.00,
            'deadline' => '2023-06-01 00:00:00',
            'user_id' => 1,
            'created_at' => '2023-01-01 10:20:00',
            'updated_at' => '2023-01-01 10:20:00'
        ],
        [
            'name' => 'Vacation',
            'target_amount' => 2000.00,
            'current_amount' => 500.00,
            'deadline' => '2023-12-01 00:00:00',
            'user_id' => 2,
            'created_at' => '2023-01-02 11:10:00',
            'updated_at' => '2023-01-02 11:10:00'
        ]
    ];

    public function __construct(private int $userId)
    {
    }

    private function filterByUserId($data) : array
    {
        return array_filter($data, function ($item) : bool {
            return $item['user_id'] === $this->userId;
        });
    }

    public function getCategories() : array
    {
        return $this->filterByUserId($this->categories);
    }

    public function getTransactions() : array
    {
        return $this->filterByUserId($this->transactions);
    }

    public function getGoals() : array
    {
        return $this->filterByUserId($this->goals);
    }

    private function filterByDateAndUserIdAndType($data, $type) : array
    {
        $now = new \DateTime();
        $currentMonth = $now->format('m');
        $currentYear = $now->format('Y');

        return array_filter($data, function ($item) use ($currentMonth, $currentYear, $type) {
            $dateTime = new \DateTime($item['created_at']);
            return $dateTime->format('m') === $currentMonth &&
                $dateTime->format('Y') === $currentYear &&
                $item['type'] === $type &&
                $item['user_id'] === $this->userId;
        });
    }

    public function getIncome() : float
    {

        $arIncome = $this->filterByDateAndUserIdAndType($this->transactions, 'income');

        //    $income = array_sum(array_column($arIncome, 'amount'));
        return !empty($arIncome) ? array_sum(array_column($arIncome, 'amount')) : 0;
    }

    public function getExpense() : float
    {
        $arExpense = $this->filterByDateAndUserIdAndType($this->transactions, 'expense');
        return !empty($arExpense) ? array_sum(array_column($arExpense, 'amount')) : 0;
    }
}