<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecurityMonitoringController extends Controller
{
    /**
     * Security monitoring dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'ADMIN') {
            abort(403, 'Unauthorized');
        }

        // Date filter
        $dateFrom = $request->input('date_from', now()->subDays(30)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());

        // Overall stats
        $totalLogins = LoginLog::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count();
        $suspiciousLogins = LoginLog::where('is_suspicious', true)
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->count();
        $blockedAccounts = User::where('is_active', false)
            ->whereNotNull('blocked_reason')
            ->count();
        $uniqueIps = LoginLog::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->distinct('ip_address')
            ->count('ip_address');
        $totalUsers = User::where('role', 'CUSTOMER')->count();
        $usersWithout2FA = User::where('role', 'CUSTOMER')
            ->whereNull('two_factor_confirmed_at')
            ->count();

        // Recent suspicious activity (last 50)
        $suspiciousActivity = LoginLog::with('user')
            ->where('is_suspicious', true)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        // Recent login activity (paginated)
        $filter = $request->input('filter', 'all');
        $searchQuery = $request->input('search', '');

        $loginLogsQuery = LoginLog::with('user')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->orderByDesc('created_at');

        if ($filter === 'suspicious') {
            $loginLogsQuery->where('is_suspicious', true);
        }

        if ($searchQuery) {
            $loginLogsQuery->where(function ($q) use ($searchQuery) {
                $q->where('ip_address', 'like', "%{$searchQuery}%")
                  ->orWhere('browser', 'like', "%{$searchQuery}%")
                  ->orWhere('platform', 'like', "%{$searchQuery}%")
                  ->orWhereHas('user', function ($uq) use ($searchQuery) {
                      $uq->where('fname', 'like', "%{$searchQuery}%")
                         ->orWhere('lname', 'like', "%{$searchQuery}%")
                         ->orWhere('email', 'like', "%{$searchQuery}%")
                         ->orWhere('username', 'like', "%{$searchQuery}%");
                  });
            });
        }

        $loginLogs = $loginLogsQuery->paginate(25)->withQueryString();

        // Currently blocked users
        $blockedUsers = User::where('is_active', false)
            ->whereNotNull('blocked_reason')
            ->orderByDesc('blocked_until')
            ->get();

        // Top suspicious IPs
        $topSuspiciousIps = LoginLog::where('is_suspicious', true)
            ->selectRaw('ip_address, COUNT(*) as count')
            ->groupBy('ip_address')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return view('admin.security-monitoring', compact(
            'totalLogins',
            'suspiciousLogins',
            'blockedAccounts',
            'uniqueIps',
            'totalUsers',
            'usersWithout2FA',
            'suspiciousActivity',
            'loginLogs',
            'blockedUsers',
            'topSuspiciousIps',
            'dateFrom',
            'dateTo',
            'filter',
            'searchQuery',
        ));
    }

    /**
     * Export security report as CSV.
     */
    public function exportReport(Request $request): StreamedResponse
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'ADMIN') {
            abort(403, 'Unauthorized');
        }

        $dateFrom = $request->input('date_from', now()->subDays(30)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $type = $request->input('type', 'all'); // all, suspicious, blocked

        $filename = "security-report-{$type}-{$dateFrom}-to-{$dateTo}.csv";

        return response()->streamDownload(function () use ($dateFrom, $dateTo, $type) {
            $handle = fopen('php://output', 'w');

            if ($type === 'blocked') {
                // Blocked users report
                fputcsv($handle, [
                    'User ID', 'Name', 'Email', 'Username', 'Blocked Reason',
                    'Blocked Until', 'Total Logins', 'Suspicious Logins',
                ]);

                User::where('is_active', false)
                    ->whereNotNull('blocked_reason')
                    ->chunk(100, function ($users) use ($handle) {
                        foreach ($users as $u) {
                            fputcsv($handle, [
                                $u->id,
                                $u->fname . ' ' . $u->lname,
                                $u->email,
                                $u->username,
                                $u->blocked_reason,
                                $u->blocked_until?->format('Y-m-d H:i:s'),
                                $u->loginLogs()->count(),
                                $u->loginLogs()->where('is_suspicious', true)->count(),
                            ]);
                        }
                    });
            } else {
                // Login activity report
                fputcsv($handle, [
                    'Date & Time', 'User ID', 'Name', 'Email', 'IP Address',
                    'Device', 'Browser', 'Platform', 'Suspicious',
                ]);

                $query = LoginLog::with('user')
                    ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                    ->orderByDesc('created_at');

                if ($type === 'suspicious') {
                    $query->where('is_suspicious', true);
                }

                $query->chunk(200, function ($logs) use ($handle) {
                    foreach ($logs as $log) {
                        fputcsv($handle, [
                            $log->created_at->format('Y-m-d H:i:s'),
                            $log->user?->id,
                            $log->user ? $log->user->fname . ' ' . $log->user->lname : 'Deleted User',
                            $log->user?->email,
                            $log->ip_address,
                            $log->device,
                            $log->browser,
                            $log->platform,
                            $log->is_suspicious ? 'Yes' : 'No',
                        ]);
                    }
                });
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
