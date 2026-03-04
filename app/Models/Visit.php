<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Visit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'referer',
        'country',
        'city',
        'device',
        'browser',
        'os',
        'session_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
                     ->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeThisYear(Builder $query): Builder
    {
        return $query->whereYear('created_at', Carbon::now()->year);
    }

    // ── Helpers ───────────────────────────────────────────

    /**
     * Record a visit from the current request.
     */
    public static function recordVisit(Request $request): static
    {
        $userAgent = $request->userAgent() ?? '';

        return static::create([
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'url'        => $request->fullUrl(),
            'referer'    => $request->header('referer'),
            'browser'    => static::parseBrowser($userAgent),
            'os'         => static::parseOs($userAgent),
            'device'     => static::parseDevice($userAgent),
            'session_id' => session()->getId(),
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * Parse browser name from user agent string.
     */
    protected static function parseBrowser(string $userAgent): string
    {
        $browsers = [
            'Edge'    => '/Edg\//i',
            'Opera'   => '/OPR\//i',
            'Chrome'  => '/Chrome\//i',
            'Firefox' => '/Firefox\//i',
            'Safari'  => '/Safari\//i',
            'IE'      => '/MSIE|Trident/i',
        ];

        foreach ($browsers as $name => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $name;
            }
        }

        return 'Other';
    }

    /**
     * Parse OS name from user agent string.
     */
    protected static function parseOs(string $userAgent): string
    {
        $systems = [
            'Windows'  => '/Windows/i',
            'macOS'    => '/Macintosh/i',
            'Linux'    => '/Linux/i',
            'Android'  => '/Android/i',
            'iOS'      => '/iPhone|iPad|iPod/i',
        ];

        foreach ($systems as $name => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $name;
            }
        }

        return 'Other';
    }

    /**
     * Parse device type from user agent string.
     */
    protected static function parseDevice(string $userAgent): string
    {
        if (preg_match('/Mobile|Android.*Mobile|iPhone|iPod/i', $userAgent)) {
            return 'Mobile';
        }

        if (preg_match('/iPad|Android(?!.*Mobile)|Tablet/i', $userAgent)) {
            return 'Tablet';
        }

        return 'Desktop';
    }
}
