<?php

namespace ItBlaster\SphinxSearchPropelBundle\Twig;

use ItBlaster\SphinxSearchPropelBundle\Search\Sphinxsearch;


/**
 * Twig extension for Sphinxsearch bundle
 */
class SphinxsearchExtension extends \Twig_Extension
{
    /**
     * @var Sphinxsearch
     */
    protected $searchd;

    /**
     * Constructor
     * @param Sphinxsearch $searchd
     */
    public function __construct(Sphinxsearch $searchd)
    {
        $this->searchd = $searchd;
    }

    /**
     * Highlight $text for the $query using $index
     * @param string $text Text content
     * @param string $index Sphinx index name
     * @param string $query Query to search
     * @param array[optional] $options Options to pass to SphinxAPI
     *
     * @return string
     */
    public function sphinx_highlight($text, $index, $query, $options = array())
    {
        $result = $this->searchd->getClient()->BuildExcerpts(array((string)$text), $index, $query, $options);

        if (!empty($result[0])) {
            return $result[0];
        } else {
            return '';
        }
    }

    /**
     * Filters list
     * @return array
     */
    public function getFilters()
    {
        return array(
            'sphinx_highlight' => new \Twig_Filter_Function(array($this, 'sphinx_highlight'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Implement getName() method
     * @return string
     */
    public function getName()
    {
        return 'it_blaster_sphinx_search_propel_extension_0';
    }
}
