<?php

/*
 * This file is part of the StateMachine package.
 *
 * (c) Alexandre Bacco
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace winzou\Bundle\TNTExpressBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('winzou_tnt_express')
            ->children()
                ->scalarNode('username')->isRequired()->end()
                ->scalarNode('password')->isRequired()->end()
                ->booleanNode('sandbox')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
