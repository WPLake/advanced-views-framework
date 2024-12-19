<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Org\Wplake\Advanced_Views\Optional_Vendors\Symfony\Component\Translation\Dumper;

use Org\Wplake\Advanced_Views\Optional_Vendors\Symfony\Component\Translation\Exception\LogicException;
use Org\Wplake\Advanced_Views\Optional_Vendors\Symfony\Component\Translation\MessageCatalogue;
use Org\Wplake\Advanced_Views\Optional_Vendors\Symfony\Component\Translation\Util\ArrayConverter;
use Org\Wplake\Advanced_Views\Optional_Vendors\Symfony\Component\Yaml\Yaml;
/**
 * YamlFileDumper generates yaml files from a message catalogue.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class YamlFileDumper extends FileDumper
{
    private string $extension;
    public function __construct(string $extension = 'yml')
    {
        $this->extension = $extension;
    }
    public function formatCatalogue(MessageCatalogue $messages, string $domain, array $options = []) : string
    {
        if (!\class_exists(Yaml::class)) {
            throw new LogicException('Dumping translations in the YAML format requires the Symfony Yaml component.');
        }
        $data = $messages->all($domain);
        if (isset($options['as_tree']) && $options['as_tree']) {
            $data = ArrayConverter::expandToTree($data);
        }
        if (isset($options['inline']) && ($inline = (int) $options['inline']) > 0) {
            return Yaml::dump($data, $inline);
        }
        return Yaml::dump($data);
    }
    protected function getExtension() : string
    {
        return $this->extension;
    }
}