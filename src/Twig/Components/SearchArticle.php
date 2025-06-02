<?php



namespace App\Twig\Components;

use App\Service\UxPackageRepository;
use App\Repository\ArticleRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('SearchArticle', template: 'components/SearchArticle.html.twig')]
final class SearchArticle
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public ?string $query = null;

    public function __construct(private ArticleRepository $ar) {}

    public function getArticles(): array
    {
        if ($this->query) { // s'il y une requête, on cherche les articles correspondans
            return $this->ar->searchByTitle($this->query);
        }

        return $this->ar->findby([], ['created_at' => 'DESC'], 10);
    }
}

/**
 * LiveProp est une classe qu'on utilise en annotation pour définir les propriétés "Live"
 * que l'on va utiliser dans le composant. C'est comme le passage de props en JavaScript.
 * 
 * "writable : true" signifie que la propriété est modifiable depuis le composant.
 * "url : true" signifie que la propriété sera disponible dans l'URL.
 */
