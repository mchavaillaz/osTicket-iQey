<?php

/**
 * Class utilities for the FAQ.
 */
class MyVaccinesUtilities
{
    const CATEGORY_SPLIT_CHARACTER = "!!";

    /**
     * Get the icon name for the given category.
     *
     * @param $category category to parse
     * @return string icon name of the category in lower case
     */
    function getCategoryIcon($category)
    {
        // Explode the category to get the context, the icon and the category title
        $categoryExplodedArray = explode($this::CATEGORY_SPLIT_CHARACTER, $category);

        return mb_strtolower($categoryExplodedArray[0]);
    }

    /**
     * Get the category title.
     *
     * @param $category category to parse
     * @return string the category title
     */
    function getCategoryTitle($category)
    {
        // Explode the category to get the context, the icon and the category title
        $categoryExplodedArray = explode($this::CATEGORY_SPLIT_CHARACTER, $category);

        return $categoryExplodedArray[1];
    }
}
