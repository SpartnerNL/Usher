<?php namespace Maatwebsite\Usher\Traits;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Shared\Embeddables\CreatedAt;
use Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt;

trait Timestamps
{

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Shared\Embeddables\CreatedAt", columnPrefix=false)
     * @var CreatedAt
     */
    protected $createdAt;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt", columnPrefix=false)
     * @var UpdatedAt
     */
    protected $updatedAt;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreatedAt(
            new CreatedAt
        );

        $this->setUpdatedAt(
            new UpdatedAt
        );
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(
            new UpdatedAt
        );
    }

    /**
     * @return CreatedAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param CreatedAt $createdAt
     */
    public function setCreatedAt(CreatedAt $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return UpdatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param UpdatedAt $updatedAt
     */
    public function setUpdatedAt(UpdatedAt $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
