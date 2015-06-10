<?php
/**
 * Created by PhpStorm.
 * User: berredo
 * Date: 10/06/15
 * Time: 10:50
 */

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Cliente
 *
 * @ORM\Table(name="tbl_cliente")
 * @ORM\Entity
 */
class Cliente
{
    /**
     * @var guid
     *
     * @ORM\Column(name="cli_id", type="guid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_nome", type="string", length=100, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_telefone", type="string", length=10, nullable=true)
     */
    private $telefone;

    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="cliente")
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
     * Set nome
     *
     * @param string $nome
     * @return Cliente
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return Cliente
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Add notas
     *
     * @param \ApiBundle\Entity\Nota $notas
     * @return Cliente
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
