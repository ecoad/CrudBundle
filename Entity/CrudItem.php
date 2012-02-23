<?php

namespace BrowserCreative\CrudBundle\Entity;

use Hub\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \DateTime;

/**
 * BrowserCreative\CrudBundle\Entity\CrudItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BrowserCreative\CrudBundle\Entity\CrudItemRepository")
 */
class CrudItem
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $subject
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var DateTime $date_created
     *
     * @ORM\Column(name="date_created", type="datetimetz")
     */
    private $date_created;

    /**
     * @ORM\ManyToOne(targetEntity="Hub\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *
     * @var User $user
     */
    private $author;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var DateTime $start_date
     *
     * @ORM\Column(name="start_date", type="datetimetz", nullable=true)
     */
    private $start_date;

    /**
     * @var DateTime $end_date
     *
     * @ORM\Column(name="end_date", type="datetimetz", nullable=true)
     */
    private $end_date;

    /**
     * @ORM\Column(name="image_path", type="string", nullable=true)
     */
    public $image_path;

    /**
     * @Assert\Image(maxSize="10M")
     */
    protected $image_file;

    /**
     * @ORM\Column(name="attachment_path", type="string", nullable=true)
     */
    public $attachment_path;

    /**
     * @Assert\File(maxSize="100M")
     */
    public $attachment_file;

    public function __construct()
    {
        $this->setDateCreated(new \DateTime());
        $this->setActive(false);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set date_created
     *
     * @param datetimetz $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    }

    /**
     * Get date_created
     *
     * @return datetimetz 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set author
     *
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set $start_date
     *
     * @param Datetime $start_date
     */
    public function setStartDate(DateTime $start_date = null)
    {
        $this->start_date = $start_date;
    }

    /**
     * Get $start_date
     *
     * @return Datetime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set $end_date
     *
     * @param Datetime $end_date
     */
    public function setEndDate(DateTime $end_date = null)
    {
        $this->end_date = $end_date;
    }

    /**
     * Get $end_date
     *
     * @return Datetime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set image_path
     *
     * @param string $image_path
     */
    public function setImagePath($image_path)
    {
        $this->image_path = $image_path;
    }

    /**
     * Get image_path
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->image_path;
    }

    /**
     * Set attachment_path
     *
     * @param string $attachment_path
     */
    public function setAttachmentPath($attachment_path)
    {
        $this->attachment_path = $attachment_path;
    }

    /**
     * Get attachment_path
     *
     * @return string
     */
    public function getAttachmentPath()
    {
        return $this->attachment_path;
    }

    /**
     * Get image_file
     *
     * @return UploadedFile 
     */
    public function getImageFile()
    {
        return $this->image_file;
    }

    /**
     * Set image_file
     *
     * @param UploadedFile $image_file
     */
    public function setImageFile(UploadedFile $image_file)
    {
        $this->image_file = $image_file;
    }

    /**
     * Get attachment_file
     *
     * @return UploadedFile 
     */
    public function getAttachmentFile()
    {
        return $this->attachment_file;
    }

    /**
     * Set attachment_file
     *
     * @param UploadedFile $attachment_file
     */
    public function setAttachmentFile(UploadedFile $attachment_file)
    {
        $this->attachment_file = $attachment_file;
    }

}
