<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin/moderator dashboard.
     */
    public function index()
    {
        $stats = [
            [
                'label' => 'Totaal producten',
                'value' => Product::count(),
            ],
            [
                'label' => 'Afgeronde orders',
                'value' => Order::where('status', 'completed')->count(),
            ],
            [
                'label' => 'Geplaatste reviews',
                'value' => Review::count(),
            ],
            [
                'label' => 'Actieve makers',
                'value' => User::whereHas('role', function ($query) {
                    $query->where('name', 'maker');
                })->count(),
            ],
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
