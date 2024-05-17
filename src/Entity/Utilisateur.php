<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?bool $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateofbirth = null;

    #[ORM\Column(length: 80)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'Utilisateurs')]
    private Collection $friend;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'friend')]
    private Collection $Utilisateurs;



    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeUtilisateur $TypeUtilisateur = null;

    /**
     * @var Collection<int, Activity>
     */
    #[ORM\OneToMany(targetEntity: Activity::class, mappedBy: 'Utilisateur')]
    private Collection $activities;

    /**
     * @var Collection<int, Goals>
     */
    #[ORM\ManyToMany(targetEntity: Goals::class, inversedBy: 'utilisateurs')]
    private Collection $atteindreObj;

    /**
     * @var Collection<int, Activity>
     */
    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'utilisateurs')]
    private Collection $participate;

    public function __construct()
    {
        $this->friend = new ArrayCollection();
        $this->Utilisateurs = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->atteindreObj = new ArrayCollection();
        $this->participate = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDateofbirth(): ?\DateTimeInterface
    {
        return $this->dateofbirth;
    }

    public function setDateofbirth(\DateTimeInterface $dateofbirth): static
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFriend(): Collection
    {
        return $this->friend;
    }

    public function addFriend(self $friend): static
    {
        if (!$this->friend->contains($friend)) {
            $this->friend->add($friend);
        }

        return $this;
    }

    public function removeFriend(self $friend): static
    {
        $this->friend->removeElement($friend);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->Utilisateurs;
    }

    public function addUtilisateur(self $utilisateur): static
    {
        if (!$this->Utilisateurs->contains($utilisateur)) {
            $this->Utilisateurs->add($utilisateur);
            $utilisateur->addFriend($this);
        }

        return $this;
    }

    public function removeUtilisateur(self $utilisateur): static
    {
        if ($this->Utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeFriend($this);
        }

        return $this;
    }

    

   
    public function getTypeUtilisateur(): ?TypeUtilisateur
    {
        return $this->TypeUtilisateur;
    }

    public function setTypeUtilisateur(?TypeUtilisateur $TypeUtilisateur): static
    {
        $this->TypeUtilisateur = $TypeUtilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setUtilisateur($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getUtilisateur() === $this) {
                $activity->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Goals>
     */
    public function getAtteindreObj(): Collection
    {
        return $this->atteindreObj;
    }

    public function addAtteindreObj(Goals $atteindreObj): static
    {
        if (!$this->atteindreObj->contains($atteindreObj)) {
            $this->atteindreObj->add($atteindreObj);
        }

        return $this;
    }

    public function removeAtteindreObj(Goals $atteindreObj): static
    {
        $this->atteindreObj->removeElement($atteindreObj);

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getParticipate(): Collection
    {
        return $this->participate;
    }

    public function addParticipate(Activity $participate): static
    {
        if (!$this->participate->contains($participate)) {
            $this->participate->add($participate);
        }

        return $this;
    }

    public function removeParticipate(Activity $participate): static
    {
        $this->participate->removeElement($participate);

        return $this;
    }

   
}
