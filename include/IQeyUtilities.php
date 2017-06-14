<?php

/**
 * Class utilities for the FAQ.
 */
class IQeyUtilities
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

    /**
     * Get all categories for the given QuerySet.<br>
     * The array contains all FAQ categories with id, icon, title and the amount of topic for current category
     *
     * @param $categoryQuerySet QuerySet the categories to parse
     * @return array[Category] the categories found for the given context. Empty array when no category present in the QuerySet.
     */
    function getCategoriesArray($categoryQuerySet)
    {
        $resultArray = array();
        // Get the categories for the given context
        foreach ($categoryQuerySet as $category) {
            // Build the category data
            $categoryArray = array();
            $categoryArray['id'] = $category->getId();
            $categoryArray['icon'] = $this->getCategoryIcon($category->getLocalName());
            $categoryArray['title'] = $this->getCategoryTitle($category->getLocalName());
            $categoryArray['amountTopic'] = $category->faq_count;

            array_push($resultArray, $categoryArray);
        }
        return $resultArray;
    }
}
