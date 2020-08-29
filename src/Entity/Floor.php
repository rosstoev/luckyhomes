<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Floor
 *
 * @ORM\Table(name="floors")
 * @ORM\Entity(repositoryClass="App\Repository\FloorRepository")
 */
class Floor
{
    /**
     * @var int
     *
     * @ORM\Column(name="floor_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $floorId;

    /**
     * @var string
     *
     * @ORM\Column(name="floor_name", type="string", length=255, nullable=false)
     */
    private $floorName;

    public function getFloorId(): ?int
    {
        return $this->floorId;
    }

    public function getFloorName(): ?string
    {
        return $this->floorName;
    }

    public function setFloorName(string $floorName): self
    {
        $this->floorName = $floorName;

        return $this;
    }


}
