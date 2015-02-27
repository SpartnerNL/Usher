<?php namespace Maatwebsite\Usher\Domain\Users\Traits;

use Maatwebsite\Usher\Contracts\Users\Embeddables\LastLoginAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastAttemptAt;
use Maatwebsite\Usher\Contracts\Shared\Embeddables\UpdatedAt as UpdatedAtInterface;
use Maatwebsite\Usher\Contracts\Users\Embeddables\RegisteredAt as RegisteredAtInterface;

trait Timestamps
{

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\LastAttemptAt", columnPrefix=false)
     * @var LastAttemptAt
     */
    protected $last_attempt_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\LastLoginAt", columnPrefix=false)
     * @var LastLoginAt
     */
    protected $last_login_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\RegisteredAt", columnPrefix=false)
     * @var RegisteredAt
     */
    protected $registered_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt", columnPrefix=false)
     * @var UpdatedAt
     */
    protected $updated_at = null;

    /**
     * @return LastAttemptAt
     */
    public function getLastAttemptAt()
    {
        return $this->last_attempt_at;
    }

    /**
     * @param LastAttemptAt $last_attempt_at
     */
    public function setLastAttemptAt(LastAttemptAt $last_attempt_at)
    {
        $this->last_attempt_at = $last_attempt_at;
    }

    /**
     * @return LastLoginAt
     */
    public function getLastLoginAt()
    {
        return $this->last_login_at;
    }

    /**
     * @param LastLoginAt $last_login_at
     */
    public function setLastLoginAt(LastLoginAt $last_login_at)
    {
        $this->last_login_at = $last_login_at;
    }

    /**
     * @return RegisteredAt
     */
    public function getRegisteredAt()
    {
        return $this->registered_at;
    }

    /**
     * @param RegisteredAtInterface $registered_at
     */
    public function setRegisteredAt(RegisteredAtInterface $registered_at)
    {
        $this->registered_at = $registered_at;
    }

    /**
     * @return UpdatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param UpdatedAtInterface $updated_at
     */
    public function setUpdatedAt(UpdatedAtInterface $updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
