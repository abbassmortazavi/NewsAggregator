<?php
/**
 * VerificationCodeRepositoryInterface.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 22:03
 */

namespace App\Repositories\VerificationCode;

interface VerificationCodeRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function sendCode(array $attributes): mixed;
}
