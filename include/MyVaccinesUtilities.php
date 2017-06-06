<?php

/**
 * Class utilities for the FAQ.
 */
class MyVaccinesUtilities
{
    const CONTEXT_PUBLIC = "public";
    const CONTEXT_PROFESSIONAL = "professional";
    const CATEGORY_SPLIT_CHARACTER = "!!";

    /**
     * Get the current context for the given param.
     *
     * @param $contextParam string the context param
     * @return string the current context
     */
    function getCurrentContext($contextParam)
    {
        // Check if the context from the url is allowed
        if (!in_array($contextParam, $this->getAllowedContextArray())) {
            // Set default value when context not allowed
            $currentContext = $this::CONTEXT_PUBLIC;
        } else {
            $currentContext = $contextParam;
        }
        return $currentContext;
    }

    /**
     * Get the context name (public, professional) for the given category.
     *
     * @param $category category to parse
     * @return string context of the category in lower case
     */
    function getCategoryContext($category)
    {
        // Explode the category to get the context, the icon and the category title
        $categoryExplodedArray = explode($this::CATEGORY_SPLIT_CHARACTER, $category);

        return mb_strtolower($categoryExplodedArray[0]);
    }

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

        return mb_strtolower($categoryExplodedArray[1]);
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

        return $categoryExplodedArray[2];
    }

    /**
     * Get all allowed context for the FAQ.
     *
     * @return array[string] with all allowed context
     */
    function getAllowedContextArray()
    {
        return array(self::CONTEXT_PUBLIC, self::CONTEXT_PROFESSIONAL);
    }

    /**
     * Get all categories for the given context for the given QuerySet.
     *
     * @param $categoryQuerySet QuerySet the categories to parse
     * @param $context string the context
     * @return array[Category] the categories found for the given context. Empty array when no category found for the given context.
     */
    function getCategoriesForContext($categoryQuerySet, $context)
    {
        $resultArray = array();
        // Get the categories for the given context
        foreach ($categoryQuerySet as $category) {
            $categoryContext = $this->getCategoryContext($category->getLocalName());
            if ($categoryContext == $context) {
                // Build the category data
                $categoryArray = array();
                $categoryArray['id'] = $category->getId();
                $categoryArray['icon'] = $this->getCategoryIcon($category->getLocalName());
                $categoryArray['title'] = $this->getCategoryTitle($category->getLocalName());
                $categoryArray['amountTopic'] = $category->faq_count;

                array_push($resultArray, $categoryArray);
            }
        }
        return $resultArray;
    }

    /**
     * Get an array of FAQs for the given context.
     *
     * @param $faqs array that contains all FAQs
     * @param $context string the current context
     * @return array an array that contains all the FAQs for the given context
     */
    function getFAQForContext($faqs, $context)
    {
        // Tool
        $faqsForContext = array();

        // Get all faqs for the given context
        foreach ($faqs as $faq) {
            if ($this->getCategoryContext($faq->getCategory()->getName()) == $context) {
                array_push($faqsForContext, $faq);
            }
        }

        return $faqsForContext;
    }
}
