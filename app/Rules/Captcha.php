<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReCaptcha\ReCaptcha;
class Captcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));

        // Xác thực reCAPTCHA thông qua giá trị token được gửi và địa chỉ IP người dùng
        $response = $recaptcha->verify($value, request()->ip());

        // Nếu xác thực không thành công, gọi hàm $fail với thông báo lỗi
        if (!$response->isSuccess()) {
            $fail('Vui lòng xác minh danh tính !');
        }
    }

}
