<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $displayName = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ofUser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Bio = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $posts;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Reaction>
     */
    #[ORM\OneToMany(targetEntity: Reaction::class, mappedBy: 'author')]
    private Collection $reactions;

    /**
     * @var Collection<int, Friendship>
     */
    #[ORM\OneToMany(targetEntity: Friendship::class, mappedBy: 'personA', cascade: ['remove'])]
    private Collection $friendAsPersonA;

    /**
     * @var Collection<int, Friendship>
     */
    #[ORM\OneToMany(targetEntity: Friendship::class, mappedBy: 'personB', cascade: ['remove'])]
    private Collection $friendAsPersonB;

    /**
     * @var Collection<int, FriendshipRequest>
     */
    #[ORM\OneToMany(targetEntity: FriendshipRequest::class, mappedBy: 'sender', orphanRemoval: true)]
    private Collection $sentFriendRequest;

    /**
     * @var Collection<int, FriendshipRequest>
     */
    #[ORM\OneToMany(targetEntity: FriendshipRequest::class, mappedBy: 'receiver', orphanRemoval: true)]
    private Collection $receiverFriendRequest;

    /**
     * @var Collection<int, Conversation>
     */
    #[ORM\ManyToMany(targetEntity: Conversation::class, mappedBy: 'partcipants')]
    private Collection $conversations;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $messages;

    /**
     * @var Collection<int, Share>
     */
    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'sender', orphanRemoval: true)]
    private Collection $sentShares;

    /**
     * @var Collection<int, Share>
     */
    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'recipient')]
    private Collection $receivedShares;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'profile', orphanRemoval: true)]
    private Collection $notifications;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->reactions = new ArrayCollection();
        $this->friendAsPersonA = new ArrayCollection();
        $this->friendAsPersonB = new ArrayCollection();
        $this->sentFriendRequest = new ArrayCollection();
        $this->receiverFriendRequest = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->sentShares = new ArrayCollection();
        $this->receivedShares = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(User $ofUser): static
    {
        $this->ofUser = $ofUser;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->Bio;
    }

    public function setBio(?string $Bio): static
    {
        $this->Bio = $Bio;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reaction>
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): static
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions->add($reaction);
            $reaction->setAuthor($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): static
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getAuthor() === $this) {
                $reaction->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendAsPersonA(): Collection
    {
        return $this->friendAsPersonA;
    }

    public function addFriendAsPersonA(Friendship $friendAsPersonA): static
    {
        if (!$this->friendAsPersonA->contains($friendAsPersonA)) {
            $this->friendAsPersonA->add($friendAsPersonA);
            $friendAsPersonA->setPersonA($this);
        }

        return $this;
    }

    public function removeFriendAsPersonA(Friendship $friendAsPersonA): static
    {
        if ($this->friendAsPersonA->removeElement($friendAsPersonA)) {
            // set the owning side to null (unless already changed)
            if ($friendAsPersonA->getPersonA() === $this) {
                $friendAsPersonA->setPersonA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendAsPersonB(): Collection
    {
        return $this->friendAsPersonB;
    }

    public function addFriendAsPersonB(Friendship $friendAsPersonB): static
    {
        if (!$this->friendAsPersonB->contains($friendAsPersonB)) {
            $this->friendAsPersonB->add($friendAsPersonB);
            $friendAsPersonB->setPersonB($this);
        }

        return $this;
    }

    public function removeFriendAsPersonB(Friendship $friendAsPersonB): static
    {
        if ($this->friendAsPersonB->removeElement($friendAsPersonB)) {
            // set the owning side to null (unless already changed)
            if ($friendAsPersonB->getPersonB() === $this) {
                $friendAsPersonB->setPersonB(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, FriendshipRequest>
     */
    public function getSentFriendRequest(): Collection
    {
        return $this->sentFriendRequest;
    }

    public function addSentFriendRequest(FriendshipRequest $sentFriendRequest): static
    {
        if (!$this->sentFriendRequest->contains($sentFriendRequest)) {
            $this->sentFriendRequest->add($sentFriendRequest);
            $sentFriendRequest->setSender($this);
        }

        return $this;
    }

    public function removeSentFriendRequest(FriendshipRequest $sentFriendRequest): static
    {
        if ($this->sentFriendRequest->removeElement($sentFriendRequest)) {
            // set the owning side to null (unless already changed)
            if ($sentFriendRequest->getSender() === $this) {
                $sentFriendRequest->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriendshipRequest>
     */
    public function getReceiverFriendRequest(): Collection
    {
        return $this->receiverFriendRequest;
    }

    public function addReceiverFriendRequest(FriendshipRequest $receiverFriendRequest): static
    {
        if (!$this->receiverFriendRequest->contains($receiverFriendRequest)) {
            $this->receiverFriendRequest->add($receiverFriendRequest);
            $receiverFriendRequest->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiverFriendRequest(FriendshipRequest $receiverFriendRequest): static
    {
        if ($this->receiverFriendRequest->removeElement($receiverFriendRequest)) {
            // set the owning side to null (unless already changed)
            if ($receiverFriendRequest->getReceiver() === $this) {
                $receiverFriendRequest->setReceiver(null);
            }
        }

        return $this;
    }

    public function isPendingSendRequest(Profile $profile): bool
    {
        foreach($this->receiverFriendRequest as $friendRequest){
            if($friendRequest->getSender() === $profile){}
                return true;
        }

        foreach($this->sentFriendRequest as $friendRequest){
            if($friendRequest->getReceiver() === $profile){
                return true;
            }
        }
        return false;
    }

    public function getFriends():array
    {
        $friends = [];
        foreach ($this->friendAsPersonB as $friendShip) {
            $friends[] = $friendShip->getPersonA();
        }
        foreach ($this->friendAsPersonA as $friendShip) {
            $friends[] = $friendShip->getPersonB();
        }
        return $friends;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->addPartcipant($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            $conversation->removePartcipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    public function isChattingWith(Profile $profile): ?Conversation
    {
        foreach($this->conversations as $conversation){
            if($conversation->getPartcipants()->contains($profile)){
                return $conversation;
            }
        }
        return null;
    }
    public function isFriendWith(Profile $profile):bool
    {
        foreach ($this->friendAsPersonB as $friendShip) {
            if($friendShip->getPersonA() === $profile){
                return true;
            }
        }
        foreach ($this->friendAsPersonA as $friendShip) {
            if($friendShip->getPersonB() === $profile){
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getSentShares(): Collection
    {
        return $this->sentShares;
    }

    public function addSentShare(Share $sentShare): static
    {
        if (!$this->sentShares->contains($sentShare)) {
            $this->sentShares->add($sentShare);
            $sentShare->setSender($this);
        }

        return $this;
    }

    public function removeSentShare(Share $sentShare): static
    {
        if ($this->sentShares->removeElement($sentShare)) {
            // set the owning side to null (unless already changed)
            if ($sentShare->getSender() === $this) {
                $sentShare->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getReceivedShares(): Collection
    {
        return $this->receivedShares;
    }

    public function addReceivedShare(Share $receivedShare): static
    {
        if (!$this->receivedShares->contains($receivedShare)) {
            $this->receivedShares->add($receivedShare);
            $receivedShare->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedShare(Share $receivedShare): static
    {
        if ($this->receivedShares->removeElement($receivedShare)) {
            // set the owning side to null (unless already changed)
            if ($receivedShare->getRecipient() === $this) {
                $receivedShare->setRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setProfile($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getProfile() === $this) {
                $notification->setProfile(null);
            }
        }

        return $this;
    }
}
