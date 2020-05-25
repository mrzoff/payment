<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Amount could not be blank")
     * @Assert\GreaterThanOrEqual(value = 0, message = "Amount must be greate then 0")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Wallet could not be blank")
     */
    private $wallet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getWallet(): ?string
    {
        return $this->wallet;
    }

    public function setWallet(string $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if(!preg_match('/^[Z][0-9]{12}$/', $this->wallet)) {
            $context->buildViolation('Not valid wallet. Format Z123456789012')
                ->atPath('wallet')
                ->addViolation();
        }
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     *  @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $this->setStatus(true);
    }
}
