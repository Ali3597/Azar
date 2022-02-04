<?php

namespace App\Entity;

use App\Entity\Produit;
use Tchoulom\ViewCounterBundle\Entity\ViewCounter as BaseViewCounter;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * ViewCounter.
 *
 * @ORM\Table(name="view_counter")
 * @ORM\Entity()
 */
class ViewCounter extends BaseViewCounter
{

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, cascade={"persist"}, inversedBy="viewCounters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Design::class, cascade={"persist"}, inversedBy="viewCounters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $design;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, cascade={"persist"}, inversedBy="viewCounters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $article;

    /**
     * Gets the Page (Produit entity)
     *
     * @return ViewCountable
     */
    public function getPage(): ViewCountable
    {
        return $this->produit;
    }

    /**
     * Set the Page (Produit entity)
     *
     * @param ViewCountable $produit
     *
     * @return ViewCounterInterface
     */
    public function setPage(ViewCountable $produit): ViewCounterInterface
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Gets Produit
     *
     * @return Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Sets Produit
     *
     * @param Produit $produit
     *
     * @return $this
     */
    public function setProduit(Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Gets Design
     *
     * @return Design
     */
    public function getDesign()
    {
        return $this->design;
    }

    /**
     * Sets Design
     *
     * @param Design $design
     *
     * @return $this
     */
    public function setDesign(Design $design)
    {
        $this->design = $design;

        return $this;
    }

    /**
     * Get the value of article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of article
     *
     * @return  self
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }
}
