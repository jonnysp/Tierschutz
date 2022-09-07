<?php


namespace Jonnysp\Tierschutz\ContaoManager;

use Jonnysp\Rezept\JonnyspRezept;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;


class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(JonnyspTierschutz::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['tier']),
        ];
    }
}
