<?php
/**
 * VerificationCodeServiceInterface.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 22:01
 */

namespace App\Services\VerificationCode;

interface VerificationCodeServiceInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function sendCode(array $attributes): mixed;

    /**
     * @param array $attributes
     * @return mixed
     */
    public function verifyCode(array $attributes): mixed;

    /**
     * @param array $attributes
     * @return mixed
     */
    public function resetPassword(array $attributes): mixed;
}
