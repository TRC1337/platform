---
title: Clear the cache of compiled routes when the cache gets cleared
issue: NEXT-12449
---
# Core
* Changed `\Shopware\Core\Framework\Adapter\Cache\CacheClearer` so it also removes the files generated by the `\Symfony\Component\Routing\Generator\Dumper\CompiledUrlGeneratorDumper`
