<?php
declare(strict_types=1);

namespace Genealogy\Helpers;

use Genealogy\Entities\Person;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait GenerateTree
 * @package Genealogy\Helpers
 */
trait GenerateTree
{
    /**
     * @param Collection $nodes
     * @param Person|null $currentPerson
     * @param string $html
     * @param bool $addRow
     * @return string
     */
    protected function generateTreeMap(Collection $nodes, Person $currentPerson = null, &$html = '', $addRow = false): string
    {
        if ($nodes->isEmpty()) {
            return $html;
        }

        if ($addRow) {
            $html .= '<div class="container-fluid ml-sm-3"><div class="row">';
        }
        foreach ($nodes as $person) {
            $classborder = $currentPerson && $currentPerson->id === $person->id ? ' border-primary' : '';
            $classLink = $person->isDead() ? ' text-secondary' : '';

            $html .= '<div class="col mb-sm-3">
                    <div class="card' . $classborder . '">
                        <div class="card-body' . $classLink . '">
                            <div class="clearfix mb-sm-1">';

            if ($person->avatar) {
                $html .= '<img src="' . $person->getAvatar() . '" alt="' . $person->last_name . '" class="img-thumbnail float-left mr-sm-2" width="50" height="50">';
            }

            $html .= '<ul class="content float-left list-unstyled mb-0">
                                    <li>'. ($person->isLeaf() ? '<a href="#" data-toggle="modal" data-target="#delete-person" data-action="' . route('persons.destroy', $person->id) . '" data-person-name="' . $person->getFullName() . '"><i class="material-icons">highlight_off</i></a>' : '') .'
                                        <a class="' . $classLink . '" href="' . route('persons.show', ['id' => $person->id]) . '">' . $person->getFullName() . '</a> '
                                        . ($person->isDead() ? '<i class="material-icons">cloud_queue</i>' : '') . '</li>
                                    <li>' . $person->contact->mobile . '</li>
                                </ul>
                            </div>

                            <ul class="list-unstyled list-inline mb-0">
                                <li class="list-inline-item"><a class="' . $classLink . '" href="' . route('parents.create', ['id' => $person->id]) . '">+ Parent</a></li>
                                <li class="list-inline-item"><a class="' . $classLink . '" href="' . route('siblings.create', ['id' => $person->id]) . '">+ Sibling</a></li>
                                <li class="list-inline-item"><a class="' . $classLink . '" href="' . route('children.create', ['id' => $person->id]) . '">+ Child</a></li>
                            </ul>
                        </div>
                    </div>
                </div>';
            $this->generateTreeMap($person->children, $currentPerson, $html, true);
        }

        if ($addRow) {
            $html .= '</div></div>';
        }

        return $html;
    }
}
