<?php
/**
 * AuthRepositoryInterface.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 20:46
 */

namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function login(array $attributes): mixed;
}
