<?php

/**
 * This file is part of the Tmdb PHP API created by Michael Roterman.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Tmdb
 * @author Michael Roterman <michael@wtfz.net>
 * @copyright (c) 2013, Michael Roterman
 * @version 0.0.1
 */

namespace Tmdb\Model\Search\SearchQuery;

use Tmdb\Model\Search\SearchQuery;

/**
 * Class MovieSearchQuery
 * @package Tmdb\Model\Search\SearchQuery
 */
class MovieSearchQuery extends SearchQuery
{
    /**
     * ISO 639-1 code.
     *
     * @param string
     *
     * @return static
     */
    public function language($language): self
    {
        $this->set('language', $language);

        return $this;
    }

    /**
     * Toggle the inclusion of adult titles. Expected value is: true or false
     *
     * @param bool
     *
     * @return static
     */
    public function includeAdult($include_adult): self
    {
        $this->set('include_adult', (bool) $include_adult);

        return $this;
    }

    /**
     * Filter the results release dates to matches that include this value.
     *
     * @param string
     *
     * @return static
     */
    public function year($year): self
    {
        if ($year instanceof \DateTime) {
            $year = $year->format('Y');
        }

        $this->set('year', (int) $year);

        return $this;
    }

    /**
     * Filter the results so that only the primary release dates have this value.
     *
     * @param string
     *
     * @return static
     */
    public function primaryReleaseYear($primary_release_year): self
    {
        $this->set('primary_release_year', $primary_release_year);

        return $this;
    }

    /**
     * By default, the search type is 'phrase'.
     *
     * This is almost guaranteed the option you will want.
     * It's a great all purpose search type and by far the most tuned for every day querying.
     *
     * For those wanting more of an "autocomplete" type search, set this option to 'ngram'.
     *
     * @deprecated
     *
     * @param string
     *
     * @return static
     */
    public function searchType($search_type = 'phrase'): self
    {
        return $this;
    }
}
