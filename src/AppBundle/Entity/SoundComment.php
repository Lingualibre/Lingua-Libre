<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="sound_comments")
 */
class SoundComment
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="Sound")
	 * @ORM\JoinColumn(name="sounds_id", referencedColumnName="id")
	 */
	private $sound;

	/**
	 * @ORM\Column(type="boolean", length=1, nullable=false)
	 */
	private $visibility;

	/**
	 * @ORM\Column(type="datetime", length=128, nullable=false)
	 */
	private $datetime;

	public function __construct()
	{
		$this->datetime = new DateTime(); 
		$this->soundComments = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * @ORM\Column(type="text", length=10000, nullable=false)
	 */
	private $text;

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
	 * Set sound
	 *
	 * @param \AppBundle\Entity\Sound $sound
	 *
	 * @return SoundComment
	 */
	public function setSound(\AppBundle\Entity\Sound $sound = null)
	{
		$this->sound = $sound;

		return $this;
	}

	/**
	 * Get sound
	 *
	 * @return \AppBundle\Entity\Sound
	 */
	public function getSound()
	{
		return $this->sound;
	}

	/**
	 * Set user
	 *
	 * @param \AppBundle\Entity\User $user
	 *
	 * @return SoundComment
	 */
	public function setUser(\AppBundle\Entity\User $user = null)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \AppBundle\Entity\User
	 */
	public function getUser()
	{
		return $this->user;
	}

	public function editableBy($user)
	{
		return $this->user->editableBy($user);
	}

	/**
	 * Set datetime
	 *
	 * @param datetime $datetime
	 *
	 * @return SoundComment
	 */
	public function setDatetime($datetime)
	{
		$this->datetime = $datetime;

		return $this;
	}

	/**
	 * Get datetime
	 *
	 * @return datetime
	 */
	public function getDatetime()
	{
		return $this->datetime;
	}

	/**
	 * Set text
	 *
	 * @param text $text
	 *
	 * @return SoundComment
	 */
	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * Get text
	 *
	 * @return text
	 */
	public function getText()
	{
		return $this->text;
	}

	

	public function export()
	{
		$result = array();
		if ($this->getVisibility()) $result["visibility"] = $this->getVisibility();
		if ($this->getTxt()) $result["text"] = $this->getTxt();
		if ($this->getDatetime()) $result["datetime"] = $this->getDatetime();
		return $result;
	}


    /**
     * Set visibility
     *
     * @param boolean $visibility
     *
     * @return SoundComment
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return boolean
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}
