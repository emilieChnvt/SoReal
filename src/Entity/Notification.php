<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $profile = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createAt = null;

    #[ORM\OneToOne(inversedBy: 'notification', cascade: ['persist', 'remove'])]
    private ?Reaction $reactionNotification = null;

    #[ORM\OneToOne(inversedBy: 'notification', cascade: ['persist', 'remove'])]
    private ?FriendshipRequest $friendrequestNotification = null;

    #[ORM\OneToOne(inversedBy: 'notification', cascade: ['persist', 'remove'])]
    private ?Message $messageNotification = null;


    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?Post $postNotification = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTime $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getReactionNotification(): ?Reaction
    {
        return $this->reactionNotification;
    }

    public function setReactionNotification(?Reaction $reactionNotification): static
    {
        $this->reactionNotification = $reactionNotification;

        return $this;
    }

    public function getFriendRequestNotification(): ?FriendshipRequest
    {
        return $this->friendrequestNotification;
    }

    public function setFriendRequestNotification(?FriendshipRequest $friendRequestNotification): static
    {
        $this->friendrequestNotification = $friendRequestNotification;

        return $this;
    }

    public function getMessageNotification(): ?Message
    {
        return $this->messageNotification;
    }

    public function setMessageNotification(?Message $messageNotification): static
    {
        $this->messageNotification = $messageNotification;

        return $this;
    }




    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPostNotification(): ?Post
    {
        return $this->postNotification;
    }

    public function setPostNotification(?Post $postNotification): static
    {
        $this->postNotification = $postNotification;

        return $this;
    }
}
