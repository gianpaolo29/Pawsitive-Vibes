<?php

namespace App\Services;

use App\Models\LoginLog;
use App\Models\User;
use App\Notifications\SuspiciousLoginNotification;
use Illuminate\Http\Request;

class LoginSecurityService
{
    // Max different IPs allowed in the time window before auto-block
    const MAX_DIFFERENT_IPS = 3;

    // Time window in hours to check for different IPs
    const TIME_WINDOW_HOURS = 24;

    // How long to auto-block (in hours)
    const BLOCK_DURATION_HOURS = 24;

    /**
     * Log a successful login and check for suspicious activity.
     */
    public static function logAndCheck(User $user, Request $request): array
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent() ?? '';

        // Parse user agent
        $browser = self::parseBrowser($userAgent);
        $platform = self::parsePlatform($userAgent);
        $device = self::parseDevice($userAgent);

        // Check if this is a new IP for this user
        $isNewIp = !LoginLog::where('user_id', $user->id)
            ->where('ip_address', $ip)
            ->exists();

        // Log the login
        $log = LoginLog::create([
            'user_id'    => $user->id,
            'ip_address' => $ip,
            'device'     => $device,
            'browser'    => $browser,
            'platform'   => $platform,
            'is_suspicious' => false,
        ]);

        // Check for suspicious activity
        $recentIps = LoginLog::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subHours(self::TIME_WINDOW_HOURS))
            ->distinct('ip_address')
            ->pluck('ip_address');

        $uniqueIpCount = $recentIps->count();
        $isSuspicious = $uniqueIpCount >= self::MAX_DIFFERENT_IPS;

        if ($isSuspicious) {
            // Mark this login as suspicious
            $log->update(['is_suspicious' => true]);

            // Auto-block the account
            $user->update([
                'is_active' => false,
                'blocked_reason' => "Suspicious activity detected: {$uniqueIpCount} different IP addresses used in the last " . self::TIME_WINDOW_HOURS . " hours.",
                'blocked_until' => now()->addHours(self::BLOCK_DURATION_HOURS),
            ]);

            // Notify admins
            $admins = User::where('role', 'ADMIN')->get();
            foreach ($admins as $admin) {
                $admin->notify(new SuspiciousLoginNotification($user, $uniqueIpCount, $recentIps->toArray()));
            }

            return [
                'blocked' => true,
                'reason' => 'suspicious_activity',
                'ip_count' => $uniqueIpCount,
            ];
        }

        return [
            'blocked' => false,
            'new_ip' => $isNewIp,
            'ip_count' => $uniqueIpCount,
        ];
    }

    private static function parseBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg/')) return 'Edge';
        if (str_contains($ua, 'Chrome/')) return 'Chrome';
        if (str_contains($ua, 'Firefox/')) return 'Firefox';
        if (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome')) return 'Safari';
        if (str_contains($ua, 'Opera') || str_contains($ua, 'OPR/')) return 'Opera';
        return 'Unknown';
    }

    private static function parsePlatform(string $ua): string
    {
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS')) return 'macOS';
        if (str_contains($ua, 'Linux') && !str_contains($ua, 'Android')) return 'Linux';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) return 'iOS';
        return 'Unknown';
    }

    private static function parseDevice(string $ua): string
    {
        if (str_contains($ua, 'Mobile') || str_contains($ua, 'Android') || str_contains($ua, 'iPhone')) return 'Mobile';
        if (str_contains($ua, 'iPad') || str_contains($ua, 'Tablet')) return 'Tablet';
        return 'Desktop';
    }
}
