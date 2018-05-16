<?php

namespace App\Entity;

use App\Enum\MissionStatusEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MissionRepository")
 */
class Mission
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Interim", inversedBy="mission")
     * @ORM\JoinColumn(nullable=false)
     */
    private $interim;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contract", inversedBy="mission", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contract;


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->contract->getInterim() != $this->interim) {
            $context->buildViolation("Le contrat selectionné n'appartient pas à cet intérimaire")
                ->atPath('contract')
                ->addViolation();
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, MissionStatusEnum::getAvailableStatus())) {
            throw new \InvalidArgumentException("Statut invalide");
        }

        $this->status = $status;

        return $this;
    }

    public function getInterim(): ?Interim
    {
        return $this->interim;
    }

    public function setInterim(?Interim $interim): self
    {
        $this->interim = $interim;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(Contract $contract): self
    {

        $this->contract = $contract;

        return $this;
    }
}
