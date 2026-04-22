<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SecuritySetting extends Model
{
    protected $table    = 'security_settings';
    protected $fillable = ['key', 'value'];
 
    /**
     * Get a setting value.
     * SecuritySetting::get('max_login_attempts', 5)
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $row = static::where('key', $key)->first();
        return $row ? $row->value : $default;
    }
 
    /**
     * Set a setting value.
     * SecuritySetting::set('two_factor_enabled', '1')
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => (string) $value]);
    }
}
