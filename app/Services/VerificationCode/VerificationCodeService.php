<?php
/**
 * VerificationCodeService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 22:01
 */


namespace App\Services\VerificationCode;

use App\Mail\SendVerificationCodeToEmail;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\VerificationCode\VerificationCodeRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VerificationCodeService implements VerificationCodeServiceInterface
{
    public function __construct(protected VerificationCodeRepositoryInterface $repository)
    {
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws Throwable
     */
    public function sendCode(array $attributes): mixed
    {
        $user = app(UserRepositoryInterface::class)->getUser($attributes['email']);
        throw_if(!$this->checkVerificationCode($user), new Exception(trans('After Two minute You can Requested Again!!')));

        $attributes['code'] = $this->generateCode();
        $attributes['expired_at'] = now()->addMinutes((int)env('VERIFICATION_EXPIRED'));
        $attributes['user_id'] = $user->id;
        //delete all verification code
        if (count($user->verificationCodes) > 0) {
            $this->deleteAllUserVerificationCodes($user);
        }
        $name = $user->name ?? "User";
        Mail::to($user->email)->send(new SendVerificationCodeToEmail($name, $attributes['code']));

        return $this->repository->sendCode($attributes);
    }

    /**
     * @param object $user
     * @return bool
     */
    public function checkVerificationCode(object $user): bool
    {
        $userVerificationCode = $user->verificationCodes()->latest()->first();
        if (!is_null($userVerificationCode)) {
            return $userVerificationCode->used && $userVerificationCode->expired_at < now() || $userVerificationCode->used === 0 && $userVerificationCode->expired_at < now();
        }
        return true;
    }

    /**
     * @param object $user
     * @return void
     */
    public function deleteAllUserVerificationCodes(object $user): void
    {
        $user->verificationCodes()->delete();
    }

    /**
     * @return int
     */
    private function generateCode(): int
    {
        return rand(0, 999999);
    }

    /**
     * @throws Exception
     */
    public function verifyCode(array $attributes): true
    {
        $user = app(UserRepositoryInterface::class)->getUser($attributes['email']);
        $latestCode = $user->verificationCodes()->latest()->first();

        if (!is_null($latestCode)) {

            if ((bool)$latestCode->used === true) {
                throw new Exception(trans('Code is Used!'));
            }

            if ($latestCode->code === (int)$attributes['code']) {
                $latestCode->update(['used' => true]);
                return true;
            } else {
                throw new Exception(trans('Code is not valid!'), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        throw new Exception(trans('Not Send Any Code'), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function resetPassword(array $attributes): mixed
    {
        $user = app(UserRepositoryInterface::class)->getUser($attributes['email']);
        $attributes['password'] = Hash::make($attributes['password']);
        app(UserRepositoryInterface::class)->update($user, $attributes);
        return true;
    }
}
