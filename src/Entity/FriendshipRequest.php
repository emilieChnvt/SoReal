<?php

namespace App\Entity;

use App\Repository\FriendshipRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendshipRequestRepository::class)]
class FriendshipRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sentFriendRequest')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $sender = null;

    #[ORM\ManyToOne(inversedBy: 'receiverFriendRequest')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $receiver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?Profile
    {
        return $this->sender;
    }

    public function setSender(?Profile $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?Profile
    {
        return $this->receiver;
    }

    public function setReceiver(?Profile $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }
}
