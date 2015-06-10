<?php
/**
 * Created by PhpStorm.
 * User: berredo
 * Date: 10/06/15
 * Time: 10:58
 */

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Viagem
 * @ORM\Table(name="tbl_viagem")
 * @ORM\Entity
 */
class Viagem {
    /**
     * @var guid
     *
     * @ORM\Column(name="via_id", type="guid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="via_de", type="string", length=100, nullable=true)
     */
    private $de;

    /**
     * @var string
     *
     * @ORM\Column(name="via_para", type="string", length=100, nullable=true)
     */
    private $para;


    /**
     * @var string
     *
     * @ORM\Column(name="via_data_ida", type="date", nullable=true)
     */
    private $dataIda;

    /**
     * @var string
     *
     * @ORM\Column(name="via_data_volta", type="date", nullable=true)
     */
    private $dataVolta;

    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="viagem")
     */
    private $notas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->notas = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return guid 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set de
     *
     * @param string $de
     * @return Viagem
     */
    public function setDe($de)
    {
        $this->de = $de;

        return $this;
    }

    /**
     * Get de
     *
     * @return string 
     */
    public function getDe()
    {
        return $this->de;
    }

    /**
     * Set para
     *
     * @param string $para
     * @return Viagem
     */
    public function setPara($para)
    {
        $this->para = $para;

        return $this;
    }

    /**
     * Get para
     *
     * @return string 
     */
    public function getPara()
    {
        return $this->para;
    }

    /**
     * Set dataIda
     *
     * @param \DateTime $dataIda
     * @return Viagem
     */
    public function setDataIda($dataIda)
    {
        $this->dataIda = $dataIda;

        return $this;
    }

    /**
     * Get dataIda
     *
     * @return \DateTime 
     */
    public function getDataIda()
    {
        return $this->dataIda;
    }

    /**
     * Set dataVolta
     *
     * @param \DateTime $dataVolta
     * @return Viagem
     */
    public function setDataVolta($dataVolta)
    {
        $this->dataVolta = $dataVolta;

        return $this;
    }

    /**
     * Get dataVolta
     *
     * @return \DateTime 
     */
    public function getDataVolta()
    {
        return $this->dataVolta;
    }

    /**
     * Add notas
     *
     * @param \ApiBundle\Entity\Nota $notas
     * @return Viagem
     */
    public function addNota(Nota $notas)
    {
        $this->notas[] = $notas;

        return $this;
    }

    /**
     * Remove notas
     *
     * @param \ApiBundle\Entity\Nota $notas
     */
    public function removeNota(Nota $notas)
    {
        $this->notas->removeElement($notas);
    }

    /**
     * Get notas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotas()
    {
        return $this->notas;
    }
}
