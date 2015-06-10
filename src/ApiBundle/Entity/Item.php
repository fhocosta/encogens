<?php
/**
 * Created by PhpStorm.
 * User: berredo
 * Date: 10/06/15
 * Time: 11:05
 */

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tipo
 * @ORM\Table(name="tbl_item")
 * @ORM\Entity
 */
class Item
{
    /**
     * @var guid
     *
     * @ORM\Column(name="ite_id", type="guid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ite_nome", type="string", length=100, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="ite_descricao", type="string", length=100, nullable=true)
     */
    private $descricao;


    /**
     * @var Tipo
     *
     * @ORM\ManyToOne(targetEntity="Tipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ite_tipo", referencedColumnName="tip_id")
     * })
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity="Pacote", mappedBy="item")
     */
    private $pacotes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pacotes = new ArrayCollection();
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
     * @return Item
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
     * Set descricao
     *
     * @param string $descricao
     * @return Item
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set tipo
     *
     * @param \ApiBundle\Entity\Tipo $tipo
     * @return Item
     */
    public function setTipo(Tipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \ApiBundle\Entity\Tipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Add pacotes
     *
     * @param \ApiBundle\Entity\Pacote $pacotes
     * @return Item
     */
    public function addPacote(Pacote $pacotes)
    {
        $this->pacotes[] = $pacotes;

        return $this;
    }

    /**
     * Remove pacotes
     *
     * @param \ApiBundle\Entity\Pacote $pacotes
     */
    public function removePacote(Pacote $pacotes)
    {
        $this->pacotes->removeElement($pacotes);
    }

    /**
     * Get pacotes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPacotes()
    {
        return $this->pacotes;
    }
}
