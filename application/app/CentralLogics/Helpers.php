<?php

namespace App\CentralLogics;

use App\Models\District;
use App\Models\PaymentTransaction;
use App\Models\Thana;
use App\Models\Union;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Helpers
{
    public static function error_processor($validator): array
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            $err_keeper[] = ['code' => $index, 'message' => $error[0]];
        }
        return $err_keeper;
    }
//    public static function get_qrcode($data)
//    {
//        $qrcode = QrCode::size(70)->generate(json_encode([
//            'name' => $data['name'],
//            'phone' => $data['phone'],
//            'type' => $data['type'] != 0 ? ($data['type'] == 1 ? 'agent' : 'customer') : null,
//            'image' => $data['image'] ?? ''
//        ]));
//        return $qrcode;
//    }

    function translate($key): string
    {
        $local = session()->has('local') ? session('local') : 'en';
        App::setLocale($local);
        $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
        $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
        if (!array_key_exists($key, $lang_array)) {
            $lang_array[$key] = $processed_key;
            $str = "<?php return " . var_export($lang_array, true) . ";";
            file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
            $result = $processed_key;
        } else {
            $result = __('messages.' . $key);
        }
        return $result;
    }

    public static function pin_check($user_id, $pin)
    {
        $user = User::find($user_id);
        if (Hash::check($pin, $user->password)) {
            return true;
        } else {
            return false;
        }
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if ($image == null) {
            return $old_image;
        }
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = Helpers::upload($dir, $format, $image);
        return $imageName;
    }

    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
        } else {
            $imageName = 'def.png';
        }

        return $imageName;
    }

    public static function get_qrcode($data)
    {
        $qrcode = QrCode::size(70)->generate(json_encode([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'type' => $data['type'] != 0 ? ($data['type'] == 1 ? 'agent' : 'customer') : null,
            'image' => $data['image'] ?? ''
        ]));
        return $qrcode;
    }

    public static function get_user_info($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public static function currency()
    {
        echo '৳';
    }
    public static function unit()
    {
        echo 'L';
    }

    public static function generateUniqueInvoiceNumber() {
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $invoiceNumber = 'SSL' . mt_rand(100000, 999999) . mt_rand(100, 999);
            $paymentTransactionExists = PaymentTransaction::where('bill_no', $invoiceNumber)->exists();
            $attempts++;
            if ($attempts >= $maxAttempts) {
                throw new \Exception("Failed to generate a unique invoice number after $maxAttempts attempts.");
            }
        } while ($paymentTransactionExists);

        return $invoiceNumber;
    }
}
