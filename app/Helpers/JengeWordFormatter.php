<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use InvalidArgumentException;

class JengeWordFormatter
{
    /**
     * Formats single words in various ways, such as singular/plural conversions and case transformations.
     * Not intended for phrases or multi-word inputs.
     */

    /**
     * Validate and sanitize input.
     *
     * @param string $keyWord
     * @return string
     * @throws InvalidArgumentException
     */
    private static function validateInput(string $keyWord): string
    {
        if (!is_string($keyWord) || (trim($keyWord) === '')) {
            throw new InvalidArgumentException('Input must be a non-empty string.');
        }
        return trim($keyWord);
    }

    /**
     * Convert to singular.
     *
     * Examples:
     * singular('cats') => 'cat'
     * singular('children') => 'child'
     */
    public static function singular(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return Str::singular($keyWord);
    }

    /**
     * Convert to plural.
     *
     * Examples:
     * plural('cat') => 'cats'
     * plural('child') => 'children'
     */
    public static function plural(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return Str::plural($keyWord);
    }

    /**
     * Convert to singular and make all lowercase.
     *
     * Examples:
     * singularLower('Cats') => 'cat'
     * singularLower('CHILDREN') => 'child'
     */
    public static function singularLower(string $keyWord): string
    {
        return strtolower(self::singular($keyWord));
    }

    /**
     * Convert to plural and make all lowercase.
     *
     * Examples:
     * pluralLower('Cat') => 'cats'
     * pluralLower('CHILD') => 'children'
     */
    public static function pluralLower(string $keyWord): string
    {
        return strtolower(self::plural($keyWord));
    }

    /**
     * Convert to make the first letter lowercase.
     *
     * Examples:
     * lcfirst('Cat') => 'cat'
     * lcfirst('CHILDREN') => 'children'
     */
    public static function lcfirst(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return lcfirst($keyWord);
    }

    /**
     * Convert to singular and make the first letter lowercase.
     *
     * Examples:
     * singularLcfirst('Cats') => 'cat'
     * singularLcfirst('CHILDREN') => 'child'
     */
    public static function singularLcfirst(string $keyWord): string
    {
        return lcfirst(self::singular($keyWord));
    }

    /**
     * Convert to plural and make the first letter lowercase.
     *
     * Examples:
     * pluralLcfirst('Cat') => 'cats'
     * pluralLcfirst('CHILD') => 'children'
     */
    public static function pluralLcfirst(string $keyWord): string
    {
        return lcfirst(self::plural($keyWord));
    }

    /**
     * Convert to capitalize the first letter.
     *
     * Examples:
     * ucfirst('cat') => 'Cat'
     * ucfirst('children') => 'Children'
     */
    public static function ucfirst(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return ucfirst($keyWord);
    }

    /**
     * Convert to singular and capitalize the first letter.
     *
     * Examples:
     * singularUcfirst('cats') => 'Cat'
     * singularUcfirst('CHILDREN') => 'Child'
     */
    public static function singularUcfirst(string $keyWord): string
    {
        return ucfirst(self::singular($keyWord));
    }

    /**
     * Convert to plural and capitalize the first letter.
     *
     * Examples:
     * pluralUcfirst('cat') => 'Cats'
     * pluralUcfirst('CHILD') => 'Children'
     */
    public static function pluralUcfirst(string $keyWord): string
    {
        return ucfirst(self::plural($keyWord));
    }

    /**
     * Convert to title case.
     *
     * Examples:
     * title('cat') => 'Cat'
     * title('children') => 'Children'
     */
    public static function title(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return Str::title($keyWord);
    }

    /**
     * Convert to singular and apply a title case.
     *
     * Examples:
     * singularTitle('cats') => 'Cat'
     * singularTitle('CHILDREN') => 'Child'
     */
    public static function singularTitle(string $keyWord): string
    {
        return Str::title(self::singular($keyWord));
    }

    /**
     * Convert to plural and apply title case.
     *
     * Examples:
     * pluralTitle('cat') => 'Cats'
     * pluralTitle('CHILD') => 'Children'
     */
    public static function pluralTitle(string $keyWord): string
    {
        return Str::title(self::plural($keyWord));
    }

    /**
     * Convert to StudlyCase (PascalCase).
     *
     * Examples:
     * studly('cat') => 'Cat'
     * studly('children') => 'Children'
     */
    public static function studly(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return Str::studly($keyWord);
    }

    /**
     * Convert to singular and apply StudlyCase (PascalCase).
     *
     * Examples:
     * singularStudly('cats') => 'Cat'
     * singularStudly('CHILDREN') => 'Child'
     */
    public static function singularStudly(string $keyWord): string
    {
        return Str::studly(self::singular($keyWord));
    }

    /**
     * Convert to plural and apply StudlyCase (PascalCase).
     *
     * Examples:
     * pluralStudly('cat') => 'Cats'
     * pluralStudly('CHILD') => 'Children'
     */
    public static function pluralStudly(string $keyWord): string
    {
        return Str::studly(self::plural($keyWord));
    }

    /**
     * Convert to camelCase.
     *
     * Examples:
     * camel('cat') => 'cat'
     * camel('children') => 'children'
     */
    public static function camel(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return Str::camel($keyWord);
    }

    /**
     * Convert to singular and apply camelCase.
     *
     * Examples:
     * singularCamel('cats') => 'cat'
     * singularCamel('CHILDREN') => 'child'
     */
    public static function singularCamel(string $keyWord): string
    {
        return Str::camel(self::singular($keyWord));
    }

    /**
     * Convert to plural and apply camelCase.
     *
     * Examples:
     * pluralCamel('cat') => 'cats'
     * pluralCamel('CHILD') => 'children'
     */
    public static function pluralCamel(string $keyWord): string
    {
        return Str::camel(self::plural($keyWord));
    }

    /**
     * Convert to singular and make all uppercase.
     *
     * Examples:
     * singularUpper('cats') => 'CAT'
     * singularUpper('CHILDREN') => 'CHILD'
     */
    public static function singularUpper(string $keyWord): string
    {
        return strtoupper(self::singular($keyWord));
    }

    /**
     * Convert to plural and make all uppercase.
     *
     * Examples:
     * pluralUpper('cat') => 'CATS'
     * pluralUpper('CHILD') => 'CHILDREN'
     */
    public static function pluralUpper(string $keyWord): string
    {
        return strtoupper(self::plural($keyWord));
    }

    /**
     * Convert to snake_case.
     *
     * Examples:
     * snake('cat') => 'cat'
     * snake('children') => 'children'
     */
    public static function snake(string $keyWord): string
    {
        $keyWord = self::validateInput($keyWord);
        return Str::snake($keyWord);
    }

    /**
     * Convert to singular and apply snake_case.
     *
     * Examples:
     * singularSnake('cats') => 'cat'
     * singularSnake('CHILDREN') => 'child'
     */
    public static function singularSnake(string $keyWord): string
    {
        return Str::snake(self::singular($keyWord));
    }

    /**
     * Convert to plural and apply snake_case.
     *
     * Examples:
     * pluralSnake('cat') => 'cats'
     * pluralSnake('CHILD') => 'children'
     */
    public static function pluralSnake(string $keyWord): string
    {
        return Str::snake(self::plural($keyWord));
    }
}
