<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * Log an audit event
     *
     * @param  string  $event
     * @param  array  $data
     * @return void
     */
    public function log(string $event, array $data = []): void
    {
        if (!config('security.audit.enabled', true)) {
            return;
        }

        AuditLog::create([
            'event' => $event,
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'data' => $this->sanitizeData($data),
            'created_at' => now(),
        ]);
    }

    /**
     * Log authentication event
     *
     * @param  string  $action
     * @param  array  $data
     * @return void
     */
    public function logAuthEvent(string $action, array $data = []): void
    {
        if (!config('security.audit.log_auth_events', true)) {
            return;
        }

        $this->log('auth.' . $action, array_merge($data, [
            'auth_action' => $action,
        ]));
    }

    /**
     * Log data modification
     *
     * @param  string  $model
     * @param  string  $action
     * @param  int|string  $modelId
     * @param  array  $changes
     * @return void
     */
    public function logDataModification(string $model, string $action, $modelId, array $changes = []): void
    {
        if (!config('security.audit.log_data_changes', true)) {
            return;
        }

        $this->log('data.' . $action, [
            'model' => $model,
            'model_id' => $modelId,
            'action' => $action,
            'changes' => $this->sanitizeData($changes),
        ]);
    }

    /**
     * Log file access
     *
     * @param  string  $file
     * @param  string  $action
     * @return void
     */
    public function logFileAccess(string $file, string $action = 'access'): void
    {
        if (!config('security.audit.log_file_access', true)) {
            return;
        }

        $this->log('file.' . $action, [
            'file' => $file,
            'action' => $action,
        ]);
    }

    /**
     * Log failed attempt
     *
     * @param  string  $type
     * @param  array  $data
     * @return void
     */
    public function logFailedAttempt(string $type, array $data = []): void
    {
        if (!config('security.audit.log_failed_attempts', true)) {
            return;
        }

        $this->log('failed_attempt.' . $type, array_merge($data, [
            'attempt_type' => $type,
        ]));
    }

    /**
     * Sanitize sensitive data from logs
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

    /**
     * Cleanup old audit logs
     *
     * @return int
     */
    public function cleanupOldLogs(): int
    {
        $retentionDays = config('security.audit.retention_days', 90);

        return AuditLog::where('created_at', '<', now()->subDays($retentionDays))
            ->delete();
    }

    /**
     * Get audit logs for a user
     *
     * @param  int  $userId
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserLogs(int $userId, int $limit = 100)
    {
        return AuditLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get audit logs by event type
     *
     * @param  string  $event
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLogsByEvent(string $event, int $limit = 100)
    {
        return AuditLog::where('event', 'like', $event . '%')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get security events (potential threats)
     *
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSecurityEvents(int $limit = 100)
    {
        $threatEvents = [
            'failed_attempt',
            'rate_limit_exceeded',
            'ip_blacklisted',
            'sql_injection_detected',
            'xss_detected',
        ];

        return AuditLog::whereIn('event', $threatEvents)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
