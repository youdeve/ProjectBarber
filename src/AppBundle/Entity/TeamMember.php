<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamMember
 *
 * @ORM\Table(name="team_member")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamMemberRepository")
 */
class TeamMember
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="teamMemberships")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="affectedAgentBarber")
     */
    protected $affectedClient;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user.
     *
     * @param string $user
     *
     * @return TeamMember
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set affectedClient.
     *
     * @param \AppBundle\Entity\User|null $affectedClient
     *
     * @return TeamMember
     */
    public function setAffectedClient(\AppBundle\Entity\User $affectedClient = null)
    {
        $this->affectedClient = $affectedClient;

        return $this;
    }

    /**
     * Get affectedClient.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAffectedClient()
    {
        return $this->affectedClient;
    }
}
