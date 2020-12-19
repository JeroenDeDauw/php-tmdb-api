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
namespace Tmdb\Repository;

use Tmdb\Exception\NotImplementedException;
use Tmdb\Exception\RuntimeException;
use Tmdb\Factory\MovieFactory;
use Tmdb\Factory\TvFactory;
use Tmdb\Model\Query\Discover\DiscoverMoviesQuery;
use Tmdb\Model\Query\Discover\DiscoverTvQuery;

/**
 * Class DiscoverRepository
 * @package Tmdb\Repository
 * @see http://docs.themoviedb.apiary.io/#discover
 */
class DiscoverRepository extends AbstractRepository
{
    /**
     * Discover movies by different types of data like average rating,
     * number of votes, genres and certifications.
     *
     * @param DiscoverMoviesQuery $query
     * @param array               $headers
     *
     * @throws RuntimeException    when certification_country is set but certification.lte is not given
     *
     * @return \Tmdb\Model\Collection\ResultCollection
     */
    public function discoverMovies(DiscoverMoviesQuery $query, array $headers = []): \Tmdb\Model\Collection\ResultCollection
    {
        $query = $query->toArray();

        if (array_key_exists('certification_country', $query) && !array_key_exists('certification.lte', $query)) {
            throw new RuntimeException(
                'When the certification_country option is given the certification.lte option is required.'
            );
        }

        $data = $this->getApi()->discoverMovies($query, $headers);

        return $this->getMovieFactory()->createResultCollection($data);
    }

    /**
     * Discover TV shows by different types of data like average rating,
     * number of votes, genres, the network they aired on and air dates.
     *
     * @param DiscoverTvQuery $query
     * @param array           $headers
     *
     * @return \Tmdb\Model\Collection\ResultCollection
     */
    public function discoverTv(DiscoverTvQuery $query, array $headers = []): \Tmdb\Model\Collection\ResultCollection
    {
        $data = $this->getApi()->discoverTv($query->toArray(), $headers);

        return $this->getTvFactory()->createResultCollection($data);
    }

    /**
     * Return the related API class
     *
     * @return \Tmdb\Api\Discover
     */
    public function getApi()
    {
        return $this->getClient()->getDiscoverApi();
    }

    /**
     * Discover currently does not offer an factory
     *
     * @throws NotImplementedException
     * @return null|\Tmdb\Factory\FactoryInterface
     */
    public function getFactory()
    {
        throw new NotImplementedException('Discover does not support a generic factory.');
    }

    /**
     * @return \Tmdb\Factory\MovieFactory
     */
    public function getMovieFactory()
    {
        return new MovieFactory($this->getClient()->getHttpClient());
    }

    /**
     * @return \Tmdb\Factory\TvFactory
     */
    public function getTvFactory()
    {
        return new TvFactory($this->getClient()->getHttpClient());
    }
}
