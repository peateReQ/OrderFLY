<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    public $timestamps = true;

    // Szybki dostęp do ustawień
        public static function get($key, $default = null)
        {
            // Obsługa tylko logo
            if ($key === 'app_logo') {
                $setting = self::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            }
            return $default;
        }

        public static function set($key, $value)
        {
            // Obsługa tylko logo
            if ($key === 'app_logo') {
                $setting = self::firstOrNew(['key' => $key]);
                $setting->value = $value;
                $setting->save();
            }
        }
}
