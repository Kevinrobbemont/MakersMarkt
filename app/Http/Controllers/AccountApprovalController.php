<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountApprovalController extends Controller
{
    /**
     * Display a list of unapproved accounts.
     */
    public function index(): View
    {
        $unapprovedUsers = User::whereNull('approved_at')
            ->with('role')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.account-approval.index', compact('unapprovedUsers'));
    }

    /**
     * Approve a user account.
     */
    public function approve(User $user): RedirectResponse
    {
        // Only allow approving users who haven't been approved yet
        if ($user->isApproved()) {
            return back()->with('warning', 'Dit account is al goedgekeurd.');
        }

        $user->approve();

        return back()->with('success', "Account van {$user->name} is goedgekeurd.");
    }

    /**
     * Reject (delete) a user account.
     */
    public function reject(User $user): RedirectResponse
    {
        $userName = $user->name;
        $user->reject();

        return back()->with('success', "Account van {$userName} is verwijderd.");
    }
}
