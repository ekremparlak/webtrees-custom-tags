<?php

/**
 * Example module.
 */

declare(strict_types=1);

namespace CustomTagsNamespace;

use Fisharebest\Webtrees\Elements\AddressWebPage;
use Fisharebest\Webtrees\Elements\CustomElement;
use Fisharebest\Webtrees\Elements\EmptyElement;
use Fisharebest\Webtrees\Elements\NameOfRepository;
use Fisharebest\Webtrees\Elements\SourceDescriptiveTitle;
use Fisharebest\Webtrees\Elements\SubmitterText;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Registry;

/**
 * Class ExampleModuleCustomTags
 *
 * This example shows how to create a custom module.
 * All the functions are optional.  Just implement the ones you need.
 *
 * Modules *must* implement ModuleCustomInterface.  They *may* also implement other interfaces.
 */
class WebtreesCustomTags extends AbstractModule implements ModuleCustomInterface
{
    // For every module interface that is implemented, the corresponding trait *should* also use be used.
    use ModuleCustomTrait;

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return I18N::translate('Custom tags');
    }

    /**
     * A sentence describing what this module does.
     *
     * @return string
     */
    public function description(): string
    {
        return I18N::translate('This module provides some custom tags');
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return 'Greg Roach';
    }

    /**
     * The version of this module.
     *
     * @return string
     */
    public function customModuleVersion(): string
    {
        return '1.0.0';
    }

    /**
     * A URL that will provide the latest version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return 'https://github.com/ekremparlak/webtrees-custom-tags/raw/main/latest-version.txt';
    }

    /**
     * Where to get support for this module.  Perhaps a github repository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return 'https://github.com/ekremparlak/webtrees-custom-tags';
    }

    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return array<string>
     */
    public function customTranslations(string $language): array
    {
        switch ($language) {
            case 'tr':
            case 'tr-TR':
                return [
                    'Marriage Surname' => 'Evlilik Soyadı',
                ];

            default:
                return [];
        }
    }

    /**
     * Called for all *enabled* modules.
     */
    public function boot(): void
    {
        $elementFactory = Registry::elementFactory();
        $elementFactory->registerTags($this->customTags());
        $elementFactory->registerSubTags($this->customSubTags());
    }
    
    /**
     * @return array<string,ElementInterface>
     */
    protected function customTags(): array
    {
        return [
            'FAM:DATA'       => new EmptyElement(I18N::translate('Data'), ['TEXT' => '0:1']),
            'FAM:TEXT'       => new SubmitterText(I18N::translate('Text')),
            'INDI:COMM'      => new CustomElement(I18N::translate('Comment'), ['URL' => '0:1']),
            'INDI:COMM:URL'  => new AddressWebPage(I18N::translate('URL')),
            'INDI:DATA'      => new EmptyElement(I18N::translate('Data'), ['TEXT' => '0:1']),
            'INDI:DATA:TEXT' => new SubmitterText(I18N::translate('Text')),
            'INDI:_MARSM'     => new CustomElement(I18N::translate('Marriage Surname')),
        ];
    }

    /**
     * @return array<string,array<int,array<int,string>>>
     */
    protected function customSubTags(): array
    {
        return [
            'FAM'       => [['DATA', '0:M']],
            'INDI'      => [['_MARSN', '0:1']],
        ];
    }
}
