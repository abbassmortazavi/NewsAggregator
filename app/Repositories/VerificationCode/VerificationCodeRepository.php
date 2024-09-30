<?php
/**
 * VerificationCodeRepository.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 22:03
 */


namespace App\Repositories\VerificationCode;

use App\Base\BaseRepository;
use App\Models\VerificationCode;

class VerificationCodeRepository extends BaseRepository implements VerificationCodeRepositoryInterface
{
    /**
     * @param VerificationCode $model
     */
    public function __construct(VerificationCode $model)
    {
        parent::__construct($model);
    }
}
