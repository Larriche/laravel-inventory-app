<?php 

namespace App\Services;

class UtilityService {
    /**
     * Generate a regex for searching for similar items
     * when spaces are ignored
     * 
     * @param  string $term Term to use for search usually an item's name
     * @return string The generated regex for use in SQL
     */
    public static function getSimilarityRegex($term)
    {
        $regex = "^";

        // Reduce contiguous spaces to one space 
        // for explode function to work desirably
        $stripped_term = preg_replace('/\s+/', ' ', trim($term));

        // Split the parts separated by a space
        $term_parts = explode(" ", $stripped_term);

        // Take each part and attach to it regex for matching
        // one or more spaces
        for ($i = 0; $i < count($term_parts) - 2; $i++) {
            $part = $term_parts[$i];
            $regex .= $part."\\\\s+";
        }

        $regex .= $term_parts[count($term_parts) - 1].'$';

        return $regex;
    }
}