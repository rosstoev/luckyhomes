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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="floor_name", type="string", length=255, nullable=false)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


}
