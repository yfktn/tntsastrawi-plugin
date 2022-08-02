<?php namespace Yfktn\TntSastrawi\Classes;
/**
 * Every new provider must implement this interface.
 * @package Yfktn\TntSastrawi\Classes
 */
interface TntSastrawiProviderInterface
{
    public function getIndexName(): string;

    public function getIndexQuery(): string;

    public function doSearch(): array;

    public function getRemoveHtmlTag(): bool;

    public function getStopWords(): array;
}