<?php
/**
 * VerificationCodeRepository.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 22:03
 */


namespace App\Repositories\VerificationCode;

use App\Models\VerificationCode;

class VerificationCodeRepository implements VerificationCodeRepositoryInterface
{
    /**
     * @param VerificationCode $verificationCode
     */
    public function __construct(protected VerificationCode $verificationCode)
    {
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function sendCode(array $attributes): mixed
    {
        return $this->verificationCode->query()->create($attributes);
    }
}
