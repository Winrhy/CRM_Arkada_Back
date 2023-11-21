<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_action = null;

    #[ORM\Column(length: 255)]
    private ?string $jwt_token = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Interaction::class)]
    private Collection $interactions;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: FormTemplate::class)]
    private Collection $formTemplates;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Form::class)]
    private Collection $forms;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: CtaTemplate::class)]
    private Collection $ctaTemplates;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Cta::class)]
    private Collection $ctas;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: DbLogs::class)]
    private Collection $dbLogs;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: MailTemplate::class)]
    private Collection $mailTemplates;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Mail::class)]
    private Collection $mails;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Attachment::class)]
    private Collection $attachments;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->interactions = new ArrayCollection();
        $this->formTemplates = new ArrayCollection();
        $this->forms = new ArrayCollection();
        $this->ctaTemplates = new ArrayCollection();
        $this->ctas = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->dbLogs = new ArrayCollection();
        $this->mailTemplates = new ArrayCollection();
        $this->mails = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUserId($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUserId() === $this) {
                $contact->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Interaction>
     */
    public function getInteractions(): Collection
    {
        return $this->interactions;
    }

    public function addInteraction(Interaction $interaction): static
    {
        if (!$this->interactions->contains($interaction)) {
            $this->interactions->add($interaction);
            $interaction->setUserId($this);
        }

        return $this;
    }

    public function removeInteraction(Interaction $interaction): static
    {
        if ($this->interactions->removeElement($interaction)) {
            // set the owning side to null (unless already changed)
            if ($interaction->getUserId() === $this) {
                $interaction->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormTemplate>
     */
    public function getFormTemplates(): Collection
    {
        return $this->formTemplates;
    }

    public function addFormTemplate(FormTemplate $formTemplate): static
    {
        if (!$this->formTemplates->contains($formTemplate)) {
            $this->formTemplates->add($formTemplate);
            $formTemplate->setUserId($this);
        }

        return $this;
    }

    public function removeFormTemplate(FormTemplate $formTemplate): static
    {
        if ($this->formTemplates->removeElement($formTemplate)) {
            // set the owning side to null (unless already changed)
            if ($formTemplate->getUserId() === $this) {
                $formTemplate->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Form>
     */
    public function getForms(): Collection
    {
        return $this->forms;
    }

    public function addForm(Form $form): static
    {
        if (!$this->forms->contains($form)) {
            $this->forms->add($form);
            $form->setUserId($this);
        }

        return $this;
    }

    public function removeForm(Form $form): static
    {
        if ($this->forms->removeElement($form)) {
            // set the owning side to null (unless already changed)
            if ($form->getUserId() === $this) {
                $form->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CtaTemplate>
     */
    public function getCtaTemplates(): Collection
    {
        return $this->ctaTemplates;
    }

    public function addCtaTemplate(CtaTemplate $ctaTemplate): static
    {
        if (!$this->ctaTemplates->contains($ctaTemplate)) {
            $this->ctaTemplates->add($ctaTemplate);
            $ctaTemplate->setUserId($this);
        }

        return $this;
    }

    public function removeCtaTemplate(CtaTemplate $ctaTemplate): static
    {
        if ($this->ctaTemplates->removeElement($ctaTemplate)) {
            // set the owning side to null (unless already changed)
            if ($ctaTemplate->getUserId() === $this) {
                $ctaTemplate->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cta>
     */
    public function getCtas(): Collection
    {
        return $this->ctas;
    }

    public function addCta(Cta $cta): static
    {
        if (!$this->ctas->contains($cta)) {
            $this->ctas->add($cta);
            $cta->setUserId($this);
        }

        return $this;
    }

    public function removeCta(Cta $cta): static
    {
        if ($this->ctas->removeElement($cta)) {
            // set the owning side to null (unless already changed)
            if ($cta->getUserId() === $this) {
                $cta->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setUserId($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getUserId() === $this) {
                $task->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DbLogs>
     */
    public function getDbLogs(): Collection
    {
        return $this->dbLogs;
    }

    public function addDbLog(DbLogs $dbLog): static
    {
        if (!$this->dbLogs->contains($dbLog)) {
            $this->dbLogs->add($dbLog);
            $dbLog->setUserId($this);
        }

        return $this;
    }

    public function removeDbLog(DbLogs $dbLog): static
    {
        if ($this->dbLogs->removeElement($dbLog)) {
            // set the owning side to null (unless already changed)
            if ($dbLog->getUserId() === $this) {
                $dbLog->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MailTemplate>
     */
    public function getMailTemplates(): Collection
    {
        return $this->mailTemplates;
    }

    public function addMailTemplate(MailTemplate $mailTemplate): static
    {
        if (!$this->mailTemplates->contains($mailTemplate)) {
            $this->mailTemplates->add($mailTemplate);
            $mailTemplate->setUserId($this);
        }

        return $this;
    }

    public function removeMailTemplate(MailTemplate $mailTemplate): static
    {
        if ($this->mailTemplates->removeElement($mailTemplate)) {
            // set the owning side to null (unless already changed)
            if ($mailTemplate->getUserId() === $this) {
                $mailTemplate->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mail>
     */
    public function getMails(): Collection
    {
        return $this->mails;
    }

    public function addMail(Mail $mail): static
    {
        if (!$this->mails->contains($mail)) {
            $this->mails->add($mail);
            $mail->setUserId($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): static
    {
        if ($this->mails->removeElement($mail)) {
            // set the owning side to null (unless already changed)
            if ($mail->getUserId() === $this) {
                $mail->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Attachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): static
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setUserId($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): static
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getUserId() === $this) {
                $attachment->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeImmutable|null $created_at
     */
    public function setCreatedAt(?\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    /**
     * @param \DateTimeImmutable|null $modified_at
     */
    public function setModifiedAt(?\DateTimeImmutable $modified_at): void
    {
        $this->modified_at = $modified_at;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getLastAction(): ?\DateTimeImmutable
    {
        return $this->last_action;
    }

    /**
     * @param \DateTimeImmutable|null $last_action
     */
    public function setLastAction(?\DateTimeImmutable $last_action): void
    {
        $this->last_action = $last_action;
    }

    /**
     * @return string|null
     */
    public function getJwtToken(): ?string
    {
        return $this->jwt_token;
    }

    /**
     * @param string|null $jwt_token
     */
    public function setJwtToken(?string $jwt_token): void
    {
        $this->jwt_token = $jwt_token;
    }
}
