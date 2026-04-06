<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class AuditLog extends Model
{
    use HasFactory, Prunable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event',
        'user_id',
        'user_email',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the audit log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        $retentionDays = config('security.audit.retention_days', 90);

        return static::where('created_at', '<', now()->subDays($retentionDays));
    }

    /**
     * Scope a query to only include logs for a specific event.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $event
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', 'like', $event . '%');
    }

    /**
     * Scope a query to only include logs for a specific user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include logs from a specific IP.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $ip
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromIP($query, string $ip)
    {
        return $query->where('ip_address', $ip);
    }

    /**
     * Scope a query to only include security-related events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSecurityEvents($query)
    {
        $threatEvents = [
            'failed_attempt',
            'rate_limit_exceeded',
            'ip_blacklisted',
            'sql_injection_detected',
            'xss_detected',
        ];

        return $query->where(function ($q) use ($threatEvents) {
            foreach ($threatEvents as $event) {
                $q->orWhere('event', 'like', $event . '%');
            }
        });
    }

    /**
     * Get the data as a sanitized array.
     *
     * @return array
     */
    public function getSanitizedDataAttribute(): array
    {
        return $this->sanitizeData($this->data ?? []);
    }

    /**
     * Sanitize sensitive data from logs.
     *
     * @param  array  $data
     * @return array
     */
    protected function sanitizeData(array $data): array
    {
        $sensitiveKeys = [
            'password', 'password_confirmation', 'current_password',
            'pin', 'security_answer', 'token', 'api_key', 'secret',
            'nik', 'nomor_kk', 'nomor_akta', 'credit_card',
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->sanitizeData($value);
            } elseif (is_string($value) && in_array(strtolower($key), $sensitiveKeys)) {
                $data[$key] = '***REDACTED***';
            }
        }

        return $data;
    }
}
