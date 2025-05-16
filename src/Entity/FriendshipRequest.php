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

    #[ORM\OneToOne(mappedBy: 'friendrequestNotification', cascade: ['persist', 'remove'])]
    private ?Notification $notification = null;

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

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): static
    {
        // unset the owning side of the relation if necessary
        if ($notification === null && $this->notification !== null) {
            $this->notification->setFriendRequestNotification(null);
        }

        // set the owning side of the relation if necessary
        if ($notification !== null && $notification->getFriendRequestNotification() !== $this) {
            $notification->setFriendRequestNotification($this);
        }

        $this->notification = $notification;

        return $this;
    }
}
