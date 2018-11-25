<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @Assert\NotBlank()
     * @Serializer\Expose
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     * @Serializer\Expose
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Serializer\Expose
     */
    private $description;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=6, scale=2)
     * @Assert\NotBlank()
     * @Serializer\Expose
     */
    private $price;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @Serializer\Expose
     */
    private $created;

    /**
     * @ORM\PrePersist
     */
    public function onCreate ()
    {
        $this->created = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Ad
     */
    public function setUser(?User $user): Ad
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Ad
     */
    public function setTitle(?string $title): Ad
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Ad
     */
    public function setDescription(?string $description): Ad
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Ad
     */
    public function setPrice(?float $price): Ad
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return Ad
     */
    public function setCreated(\DateTime $created): Ad
    {
        $this->created = $created;

        return $this;
    }
}
