<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apartment
 *
 * @ORM\Table(name="apartments", indexes={@ORM\Index(name="fk_floor_apartment", columns={"floor_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ApartmentRepository")
 */
class Apartment
{
    /**
     * @var int
     *
     * @ORM\Column(name="apartment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $apartmentId;

    /**
     * @var string
     *
     * @ORM\Column(name="apartment_name", type="string", length=255, nullable=false)
     */
    private $apartmentName;

    /**
     * @var float|null
     *
     * @ORM\Column(name="building_area", type="float", precision=10, scale=0, nullable=true)
     */
    private $buildingArea;

    /**
     * @var float|null
     *
     * @ORM\Column(name="total_parts", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalParts;

    /**
     * @var float|null
     *
     * @ORM\Column(name="total_area", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalArea;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price_unfinish", type="integer", nullable=true)
     */
    private $priceUnfinish;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price_finish", type="integer", nullable=true)
     */
    private $priceFinish;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price_rent", type="integer", nullable=true)
     */
    private $priceRent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apartment_status", type="string", length=255, nullable=true)
     */
    private $apartmentStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="additional_info", type="text", length=65535, nullable=true)
     */
    private $additionalInfo;

    /**
     * @var Floor
     *
     * @ORM\ManyToOne(targetEntity="Floor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="floor_id", referencedColumnName="floor_id")
     * })
     */
    private $floor;

    public function getApartmentId(): ?int
    {
        return $this->apartmentId;
    }

    public function getApartmentName(): ?string
    {
        return $this->apartmentName;
    }

    public function setApartmentName(string $apartmentName): self
    {
        $this->apartmentName = $apartmentName;

        return $this;
    }

    public function getBuildingArea(): ?float
    {
        return $this->buildingArea;
    }

    public function setBuildingArea(?float $buildingArea): self
    {
        $this->buildingArea = $buildingArea;

        return $this;
    }

    public function getTotalParts(): ?float
    {
        return $this->totalParts;
    }

    public function setTotalParts(?float $totalParts): self
    {
        $this->totalParts = $totalParts;

        return $this;
    }

    public function getTotalArea(): ?float
    {
        return $this->totalArea;
    }

    public function setTotalArea(?float $totalArea): self
    {
        $this->totalArea = $totalArea;

        return $this;
    }

    public function getPriceUnfinish(): ?int
    {
        return $this->priceUnfinish;
    }

    public function setPriceUnfinish(?int $priceUnfinish): self
    {
        $this->priceUnfinish = $priceUnfinish;

        return $this;
    }

    public function getPriceFinish(): ?int
    {
        return $this->priceFinish;
    }

    public function setPriceFinish(?int $priceFinish): self
    {
        $this->priceFinish = $priceFinish;

        return $this;
    }

    public function getPriceRent(): ?int
    {
        return $this->priceRent;
    }

    public function setPriceRent(?int $priceRent): self
    {
        $this->priceRent = $priceRent;

        return $this;
    }

    public function getApartmentStatus(): ?string
    {
        return $this->apartmentStatus;
    }

    public function setApartmentStatus(?string $apartmentStatus): self
    {
        $this->apartmentStatus = $apartmentStatus;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): self
    {
        $this->floor = $floor;

        return $this;
    }


}
